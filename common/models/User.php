<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/*
 * User model
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $phone
 * @property int $status
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CashBoxLog[] $cashBoxLogs
 * @property CashFlowTransaction[] $cashFlowTransactions
 * @property UserAddress[] $userAddresses
 * @property Address[] $addresses
 * @property UserCompany[] $userCompanies
 * @property Company[] $companies
 * @property UserInvitation[] $userInvitations
 * @property UserProfile $userProfile
 * @property UserProfile[] $userProfiles
 */

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DISABLED = 0;
    const STATUS_CREATED = 10; // needs validation using email link
    const STATUS_UNFINISH = 20;
    const STATUS_ACTIVE = 30;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [[/*'username',*/ 'email'/*, 'status'*/], 'required'],
            [['password_reset_token', 'auth_key'], 'string'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            //[['username', 'email', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['password_hash', 'email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_UNFINISH], // change to STATUS_CREATED when email message function is done
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_UNFINISH, self::STATUS_CREATED, self::STATUS_DISABLED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('erp.sys', 'ID'),
            //'username' => Yii::t('erp.sys', 'Username'),
            //'password' => Yii::t('erp.sys', 'Password'),
            'username' => Yii::t('erp.sys', 'Username'),
            'email' => Yii::t('erp.sys', 'Email'),
            'phone' => Yii::t('erp.sys', 'Phone'),
            'status' => Yii::t('erp.sys', 'Status'),
            'auth_key' => Yii::t('erp.sys', 'Auth Key'),
            'password_hash' => Yii::t('erp.sys', 'Password Hash'),
            'password_reset_token' => Yii::t('erp.sys', 'Password Reset Token'),
            'email' => Yii::t('erp.sys', 'Email'),
            'auth_key' => Yii::t('erp.sys', 'Auth Key'),
            'status' => Yii::t('erp.sys', 'Status'),
            'created_at' => Yii::t('erp.sys', 'Created At'),
            'updated_at' => Yii::t('erp.sys', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
              'class' => TimestampBehavior::className(),
              'value' => date('Y-m-d H:i:s',time()),
            ],
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUserProfiles()
    {
        return $this->hasMany(UserProfile::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    /*
     * @return \yii\db\ActiveQuery
     * /
    public function getCashBoxLogs()
    {
        return $this->hasMany(CashBoxLog::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * /
    public function getCashFlowTransactions()
    {
        return $this->hasMany(CashFlowTransaction::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * /
    public function getUserAddresses()
    {
        return $this->hasMany(UserAddress::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * /
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['id' => 'address_id'])->viaTable('user_address', ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * /
    public function getUserCompanies()
    {
        return $this->hasMany(UserCompany::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * /
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['id' => 'company_id'])->viaTable('user_company', ['user_id' => 'id']);
    }

    /**
      * @return \yii\db\ActiveQuery
      * /
    public function getCompany()
    {
       return $this->hasOne(Company::className(), ['id' => 'company_id'])->viaTable('user_company', ['user_id' => 'id']);
    }

    /**
      * @return Array[\yii\db\ActiveQuery]
      * /
    public function getCompanyList()
    {
        $companies = [];
        foreach ($this->companies as $company) {
          $companies[$company->id] = $company->legal_name;
        }
        return $companies;
    }

    /**
      * @return Array[\yii\db\ActiveQuery]
      * /
    public function getVenueList()
    {
        $venues = [];
        foreach ($this->companies as $company) {
            foreach ($company->venues as $venue) {
                $venues[$venue->id] = $venue->legal_name;
            }
        }
        return $venues;
    }

    /**
     * @return \yii\db\ActiveQuery
     * /
    public function getUserInvitations()
    {
        return $this->hasMany(UserInvitation::className(), ['invited_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * /
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    /**
      * @return \yii\db\ActiveQuery
      * /
    public function getBrands()
    {
        $brands = [];
        foreach ($this->companies as $company) {
          if (!empty($company->brands))
            array_push($brands, $company->brands);
        }
        return $brands;
    }

    /**
      * @return \yii\db\ActiveQuery
      * /
    public function getBrandList()
    {
        $brands = [];
        foreach ($this->companies as $company) {
          if (!empty($company->brands))
            foreach ($company->brands as $item) {
              if (!array_key_exists($item->id, $brands))
                $brands[$item->id] = $item->name;
            }
        }
        return $brands;
    }
    */

    /**
     * {@inheritdoc}
     */
    public function finishSignup()
    {
      $this->status = self::STATUS_ACTIVE;
      $this->save();
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => [self::STATUS_ACTIVE, self::STATUS_UNFINISH, self::STATUS_CREATED]]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => [self::STATUS_ACTIVE, self::STATUS_UNFINISH, self::STATUS_CREATED]]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => [self::STATUS_ACTIVE, self::STATUS_UNFINISH, self::STATUS_CREATED],
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
