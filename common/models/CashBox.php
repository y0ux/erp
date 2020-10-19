<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cash_box".
 *
 * @property string $id
 * @property string $name
 * @property int $box_type main, unique, secondary, safe
 * @property string $code
 * @property string $venue_id
 * @property string $currency_id
 * @property double $initial_amount
 * @property string $details
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Venue $venue
 * @property Currency $currency
 * @property CashBoxLog[] $cashBoxLogs
 */
class CashBox extends \yii\db\ActiveRecord
{

    const MAIN = 1;
    const SECONDARY = 2;
    const UNIQUE = 3;
    const SAFE = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cash_box';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'box_type', 'venue_id', 'currency_id', 'initial_amount'], 'required'],
            [['box_type', 'venue_id', 'currency_id'], 'integer'],
            [['initial_amount'], 'number'],
            [['details'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'code'], 'string', 'max' => 255],
            [['venue_id'], 'exist', 'skipOnError' => true, 'targetClass' => Venue::className(), 'targetAttribute' => ['venue_id' => 'id']],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sys.cashbox', 'ID'),
            'name' => Yii::t('sys.cashbox', 'Name'),
            'box_type' => Yii::t('sys.cashbox', 'Box Type'),
            'code' => Yii::t('sys.cashbox', 'Code'),
            'venue_id' => Yii::t('sys.cashbox', 'Venue ID'),
            'currency_id' => Yii::t('sys.cashbox', 'Currency ID'),
            'initial_amount' => Yii::t('sys.cashbox', 'Initial Amount'),
            'details' => Yii::t('sys.cashbox', 'Details'),
            'created_at' => Yii::t('sys.cashbox', 'Created At'),
            'updated_at' => Yii::t('sys.cashbox', 'Updated At'),
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
    public function getVenue()
    {
        return $this->hasOne(Venue::className(), ['id' => 'venue_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCashBoxLogs()
    {
        return $this->hasMany(CashBoxLog::className(), ['cash_box_id' => 'id']);
    }

    /**
     * @return Array
     */
    public static function getCashBoxTypes()
    {
        return [
          self::MAIN => \Yii::t('sys.cashbox', 'Main'),
          self::SECONDARY => \Yii::t('sys.cashbox', 'Secondary'),
          self::UNIQUE => \Yii::t('sys.cashbox', 'Unique'),
          self::SAFE => \Yii::t('sys.cashbox', 'Safe'),
        ];
    }
}
