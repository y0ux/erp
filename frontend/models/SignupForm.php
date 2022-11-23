<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\SignupInvitation;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $invitation_token;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            /*['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],*/

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['invitation_token', 'required'],
            ['invitation_token', 'exist', 'skipOnError' => true, 'targetClass' => SignupInvitation::className(), 'targetAttribute' => ['invitation_token' => 'invitation_token']],
            ['invitation_token', 'checkToken'],//,'guestEmail' => 'email'],
        ];
    }

    public function checkToken($attribute, $params, $validator)
    {
      //Yii::$app->session->setFlash('error', 'guestEmail: '.$params['guestEmail']);

      //$email = $this->$params['guestEmail']
      $token = SignupInvitation::findToken($this->$attribute);
      if (empty($token) || !$token->validateToken($this->email)) {
        $this->addError($attribute, 'The token is invalid.');
      }
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        //Yii::$app->session->setFlash('warning', 'ingresa a modelo');
        if (!$this->validate()) {
            //Yii::$app->session->setFlash('error', 'Validation fail.');
            return null;
        }
        //Yii::$app->session->setFlash('success', 'Validation pass.');

        // get token
        $token = SignupInvitation::findToken($this->invitation_token);
        if (empty($token)) {
          //Yii::$app->session->setFlash('error', 'Token failed.');
          return null;
        }
        $user = new User();
        //$user->username = $this->username;
        $user->username = $this->email;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        Yii::$app->session->setFlash('success', 'usuario generado ');
        if ($user->save()) {
            $token->processToken($this->email);
            Yii::$app->session->setFlash('success', 'token procesado ');
            return $user;
        }
        return null;
    }
}
