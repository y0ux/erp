<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "signup_invitation".
 *
 * @property int $Id
 * @property string $invitation_token
 * @property int $status
 * @property int $type
 * @property string $invited
 * @property string $validity_date
 * @property int $limit_validity
 * @property string $created_at
 * @property string $updated_at
 */
class SignupInvitation extends \yii\db\ActiveRecord
{
    CONST STATUS_DISABLED = 0;
    CONST STATUS_ACTIVE = 1;
    CONST STATUS_UNIQUE = 2;

    CONST TYPE_CANCELED = 0; // when no type applies
    CONST TYPE_SINGLE_UNLIMITED = 10; // DEFAULT, single use, no time limit
    CONST TYPE_SINGLE_LIMITED = 11; // single use, time limited
    CONST TYPE_MULTIPLE_UNLIMITED = 20; // multiple uses, no time limit - manual disabling
    CONST TYPE_MULTIPLE_LIMITED = 21; // multiple uses, time limited
    CONST TYPE_MULTIPLE_QUANTITY = 22; // multiple uses, uses limited

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'signup_invitation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invitation_token'], 'required'],
            [['status', 'type', 'limit_validity'], 'integer'],
            [['validity_date', 'created_at', 'updated_at'], 'safe'],
            [['invitation_token', 'invited'], 'string', 'max' => 255],
            [['invitation_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('erp.sys', 'ID'),
            'invitation_token' => Yii::t('erp.sys', 'Invitation Token'),
            'status' => Yii::t('erp.sys', 'Status'),
            'type' => Yii::t('erp.sys', 'Type'),
            'invited' => Yii::t('erp.sys', 'Invited'),
            'validity_date' => Yii::t('erp.sys', 'Validity Date'),
            'limit_validity' => Yii::t('erp.sys', 'Limit Validity'),
            'created_at' => Yii::t('erp.sys', 'Created At'),
            'updated_at' => Yii::t('erp.sys', 'Updated At'),
        ];
    }

    public static function findToken($tokenString) {
      if ($tokenString)
        return SignupInvitation::find()->where(['invitation_token' => $tokenString])->one();
      return null;
    }

    /**
    * Check if token is active
    */
    public function isActive()
    {
      return $this->status != self::STATUS_DISABLED;
    }

    /**
    * Validate token settings
    */
    public function validateToken($invited = null)
    {
      if ($this->status == self::STATUS_ACTIVE) {
        switch($this->type) {
          case self::TYPE_SINGLE_UNLIMITED:
          case self::TYPE_MULTIPLE_UNLIMITED:
            return true;
          case self::TYPE_SINGLE_LIMITED:
          case self::TYPE_MULTIPLE_LIMITED:
            if (strtotime($this->validity_date) < time())
              return true;
            $this->useInvitationToken(); // time is up
            break;
          case self::TYPE_MULTIPLE_QUANTITY:
            if ($this->limit_validity >= 1)
              return true;
            $this->useInvitationToken(); // invalidate, was completly used
            break;
          default:
            $this->useInvitationToken(); // any other option is invalid
        }
      }
      elseif ($this->status == self::STATUS_UNIQUE) {
        switch($this->type) {
          case self::TYPE_SINGLE_UNLIMITED:
            if (!empty($this->invited) && !empty($invited) && $this->invited == $invited)
              return true;
            break;
          case self::TYPE_SINGLE_LIMITED:
            if (!empty($this->invited) && !empty($invited) && $this->invited == $invited && strtotime($this->validity_date) < time())
              return true;
            break;
          case self::TYPE_MULTIPLE_UNLIMITED:
          case self::TYPE_MULTIPLE_LIMITED:
          case self::TYPE_MULTIPLE_QUANTITY:
          default:
            $this->useInvitationToken(); // everything else is invalid
        }
      }
      return false;
    }

    /**
    * Change status
    */
    public function useInvitationToken($newStatus = self::STATUS_DISABLED)
    {
      $this->status = $newStatus;
      $this->update();
    }

    /**
    * Process token
    */
    public function processToken($invited = null)
    {
      if ($this->validateToken($invited)) {
        if ($this->status == self::STATUS_ACTIVE) {
          switch($this->type) {
            case self::TYPE_SINGLE_UNLIMITED:
            case self::TYPE_SINGLE_LIMITED:
              $this->useInvitationToken();
              break;
            case self::TYPE_MULTIPLE_UNLIMITED:
            case self::TYPE_MULTIPLE_LIMITED:
              $this->limit_validity++;
              $this->update();
              break;
            case self::TYPE_MULTIPLE_QUANTITY:
              if (--$this->limit_validity < 1) {
                $this->useInvitationToken(); // invalidate, was completly used
                Yii::$app->session->setFlash('error', 'STATUS_ACTIVE > TYPE_MULTIPLE_QUANTITY fail');
              }
              $this->update();
              break;
            default:
              $this->useInvitationToken();
          }
        }
        elseif ($this->status == self::STATUS_UNIQUE) {
          switch($this->type) {
            case self::TYPE_SINGLE_UNLIMITED:
              if (!empty($this->invited) && !empty($invited) && $this->invited == $invited)
                $this->useInvitationToken();
              else
                Yii::$app->session->setFlash('error', 'STATUS_UNIQUE > TYPE_SINGLE_UNLIMITED fail');
              break;
            case self::TYPE_SINGLE_LIMITED:
              if (!empty($this->invited) && !empty($invited) && strtotime($this->validity_date) < time() && $this->invited == $invited)
                $this->useInvitationToken();
              else
                Yii::$app->session->setFlash('error', 'STATUS_UNIQUE > TYPE_SINGLE_LIMITED fail');
              break;
            case self::TYPE_MULTIPLE_UNLIMITED:
            case self::TYPE_MULTIPLE_LIMITED:
            case self::TYPE_MULTIPLE_QUANTITY:
            default:
              $this->useInvitationToken(); // invalidate, everything else is invalid
          }
        }
      }
    }

    /**
    * Generates invitation token
    */
    public function generateInvitationToken()
    {
      $this->invitation_token = Yii::$app->security->generateRandomString();
    }
}
