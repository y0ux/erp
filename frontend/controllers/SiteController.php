<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\UserProfile;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;


use common\models\Company;
use common\models\BankAccount;
use common\models\Bank;
use common\models\Brand;
use common\models\Stand;
use common\models\UserCompany;
use common\models\CompanyBankAccount;

use common\models\User;

use Square\SquareClient;
use Square\Environment;
use Square\Exceptions\ApiException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     * @throws NotFoundHttpException if api call fails
     */
    public function actionIndex()
    {
      if(\Yii::$app->user->isGuest)
        return $this->render('index');
      if(\Yii::$app->user->identity->status == User::STATUS_CREATED)
        return $this->redirect(['profile']);
      if(\Yii::$app->user->identity->status == User::STATUS_UNFINISH)
        return $this->redirect(['profile']);
      if (empty(Yii::$app->user->identity->company))
        return $this->redirect(['register']);

      return $this->render('panel', [

      ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!empty(Yii::$app->params['system.status']) && Yii::$app->params['system.status'] == "closed") {
            Yii::$app->session->setFlash('error', 'El sistema esta cerrado no se permite ingresar. Gracias!');
            if (!Yii::$app->user->isGuest) {
                Yii::$app->user->logout();
            }
            return $this->render('index');
        }
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        //Yii::$app->session->setFlash('success', 'We are guest');
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //Yii::$app->session->setFlash('success', 'Logging in');
            return $this->goBack();
        } else {
            $model->password = '';
            //Yii::$app->session->setFlash('error', 'Can not login');
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                // RBCA
                /*$auth = Yii::$app->authManager;
                $authorRole = $auth->getRole('author');
                $auth->assign($authorRole, $user->getId());*/
                //Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
                Yii::$app->session->setFlash('success', 'Thank you for registration.');
                Yii::$app->user->login($user);
                // take it home
                return $this->goHome();
            }
            //Yii::$app->session->setFlash('error', 'Todo fallo.');
        }

        $invitation_token = Yii::$app->request->getQueryParam("invitation_token","");
        //Yii::$app->session->setFlash('error', 'Token: '.$invitation_token);
        return $this->render('signup', [
            'model' => $model,
            'invitation_token' => $invitation_token,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionProfile()
    {
        $model = new UserProfile();
        $model->user_id = Yii::$app->user->identity->id;
        //Yii::$app->session->setFlash('error', 'getting in');
        if ($model->load(Yii::$app->request->post())) {
            //Yii::$app->session->setFlash('success', 'information loaded '.print_r($model,true));
            if ($model->save()) {
              //  Yii::$app->session->setFlash('success', 'Thank you for finishing.');
                Yii::$app->user->identity->finishSignup();
                // take it home
                return $this->goHome();
            }
            //Yii::$app->session->setFlash('error', 'profile failed.');
        }
        return $this->render('userProfile', [
            'model' => $model,
        ]);
    }






    /**
     * Displays a single Venue model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = Company::findOne($id);
        if (empty($model))
          throw new NotFoundHttpException('Id: '.$id.' does not exists.', 404, null);
        if (!empty($model->user) && $model->user->id == Yii::$app->user->id)
          return $this->render('company', [
              'model' => $model,
          ]);
        throw new ForbiddenHttpException('Please, access your registration only.', 403, null);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRegister()
    {
      //if (Yii::$app->user->identity->id > 1)  // BLOQUEO STAFF ACTIVAR CODIGO
        //return $this->render('panel');
      if (!empty(Yii::$app->user->identity->company)) {
          return $this->redirect(['view', 'id' => Yii::$app->user->identity->company->id]);
      }
      $company = new Company();
      $bank_account = new BankAccount();
      $brand = new Brand();
      if($this->save($company, $bank_account, $brand))
          return $this->redirect(['view', 'id' => $company->id]);

      return $this->render('register',[
          'model' => [
            'company' => $company,
            'bank_account' => $bank_account,
            'brand' => $brand,
          ],
          'lists' => [
            //'stands_taken' => Company::getTakenCompanyStands(),
            //'company_types' => Company::getCompanyTypes(),
          ]
      ]);
    }

    /**
     * Updates an existing BusinessProfile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $company = Company::find()->where(['id' => $id])->one();

        if (!empty($company->user) && $company->user->id == Yii::$app->user->id) {
          $bank_account = $company->getFirstBankAccount()->one();
          if (empty($bank_account))
              $bank_account = new BankAccount();

          $brand = $company->getBrand()->one();
          if (empty($brand))
              $brand = new Brand();

          if($this->save($company, $bank_account, $brand))
              return $this->redirect(['view', 'id' => $company->id]);

          return $this->render('register',[
              'model' => [
                'company' => $company,
                'bank_account' => $bank_account,
                'brand' => $brand,
              ],
              'lists' => [
                //'stands_taken' => Company::getTakenCompanyStands(),
                //'company_types' => Company::getCompanyTypes(),
              ]
          ]);
        }
        throw new ForbiddenHttpException('Please, modify your registration only.', 403, null);
      }

    /**
     * Updates o creates a company.
     * @param Company $company
     * @param BankAccount $bank_account
     * @param Brand $brand
     * @return mixed
     */
    protected function save($company, $bank_account, $brand)
    {
      $flash_id = 'company-'.($company->isNewRecord? 'create' : 'update');
      Yii::$app->session->addFlash($flash_id, "flash_id: ".print_r($flash_id, true));
      Yii::$app->session->addFlash($flash_id, "model isNewRecord? ".($company->isNewRecord? "yes":"no"));

      $company_transaction = Company::getDb()->beginTransaction();
      try
      {
          $stand_position = null;
          if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            if(isset($data['Company'])) {
              $company->details = json_encode([
                'city' => isset($data['Company']['city'])? $data['Company']['city'] : '',
                'firstTime' => isset($data['Company']['first-time'])? true : false,
                'costCompromise' => isset($data['Company']['cost-compromise'])? true : false,
              ]);
            }
          }
          if ( $company->load(Yii::$app->request->post()) && $company->save() )
          {
              Yii::$app->session->addFlash($flash_id,'checking company user relationship');
              if ($company->isNewRecord || UserCompany::find()->where(['company_id' => $company->id, 'user_id' => Yii::$app->user->id])->one() == null)
              {
                  Yii::$app->session->addFlash($flash_id,'saving relationshing');
                  // save user relaltionship
                  $user_company = new UserCompany();
                  $user_company->company_id = $company->id;
                  $user_company->user_id = Yii::$app->user->id;
                  // move this to after save
                  if (!$user_company->save())
                      throw now \Throwable("Can't save User-Company realtionship, otherwise won't be able to update later... bail");
              }
              else
              {
                  Yii::$app->session->addFlash($flash_id,'relationship already created');
              }

              // save bank account info
              Yii::$app->session->addFlash($flash_id,'checking bank_account.. isNewRecord? '.($bank_account->isNewRecord? "yes" : "no"));
              $bank_account_transaction = BankAccount::getDb()->beginTransaction();
              $bank_account_isNew = $bank_account->isNewRecord;
              if ( $bank_account->load(Yii::$app->request->post()) && $bank_account->save() )
              {
                  Yii::$app->session->addFlash($flash_id, 'saving bank_account');
                  if ($bank_account_isNew)
                  {
                      Yii::$app->session->addFlash($flash_id, 'saving company - bank_account relationship');
                      $company_bank_account = new CompanyBankAccount();
                      $company_bank_account->company_id = $company->id;
                      $company_bank_account->bank_account_id = $bank_account->id;
                      if ($company_bank_account->save())
                      {
                          Yii::$app->session->addFlash($flash_id, 'commiting bank account');
                          $bank_account_transaction->commit();
                      }
                      else
                      {
                          Yii::$app->session->addFlash($flash_id, 'roollingback bank account');
                          $bank_account_transaction->rollBack();
                      }
                  }
                  else
                  {
                      Yii::$app->session->addFlash($flash_id, 'updating bank account');
                      $bank_account_transaction->commit();
                  }
              }
              else {
                return false;
              }

              // save brand info
              Yii::$app->session->addFlash($flash_id,'checking brand.. isNewRecord? '.($brand->isNewRecord? "yes" : "no"));
              $brand->company_id = $company->id;
              if ( $brand->load(Yii::$app->request->post()) && $brand->save() )
              {
                  Yii::$app->session->addFlash($flash_id, 'saving brand');
              }
              else {
                return false;
              }

              Yii::$app->session->addFlash($flash_id, 'commiting company');
              $company_transaction->commit();

              return true;
          }
      }
      catch (Exception $e)
      {
          $company_transaction->rollBack();
          Yii::$app->session->addFlash($flash_id,"There was an error trying to save the Company information: [".$e->getMessage()."]");
      }
      return false;
    }

    /**
     * Deletes an existing Venue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        Company::findOne($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionCreateSignupInvitation()
    {
      /*  INCOMPLETE ALL */
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
