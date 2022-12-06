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

use common\models\Currency;
use common\models\ExchangeRate;
use common\models\CashierRecord;
use common\models\CashierTransaction;
use common\models\CashboxDetail;

use frontend\models\CashboxForm;



/**
 * Site controller
 */
class CashboxController extends Controller
{
    /**
     * {@inheritdoc}
     */
    //public function behaviors()
    //{
    //}

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
     */
    public function actionIndex()
    {
        Yii::debug(print_r("going to index ", true));
        if(\Yii::$app->user->isGuest)
            return $this->redirect(['site/index']);

        Yii::debug(print_r("creating form ", true));
        $model = new CashboxForm();
        if ($model->load(Yii::$app->request->post())) {
            Yii::debug(print_r("loading form", true));
            if ($cashbox = $model->processRecord()) {
                Yii::debug(print_r("form processed", true));
                return $this->goHome();
            }
        }

        return $this->render('index', [
          'model' => $model,
        ]);
    }

}
