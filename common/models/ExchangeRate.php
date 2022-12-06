<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "exchange_rate".
 *
 * @property int $id
 * @property string $rate_name
 * @property int $from_currency_id
 * @property int $to_currency_id
 * @property double $value
 * @property int $type
 * @property int $frequency
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Currency $fromCurrency
 * @property Currency $toCurrency
 */
class ExchangeRate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exchange_rate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rate_name', 'from_currency_id', 'to_currency_id', 'value', 'type', 'created_at'], 'required'],
            [['from_currency_id', 'to_currency_id', 'type', 'frequency'], 'integer'],
            [['value'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['rate_name'], 'string', 'max' => 255],
            [['from_currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['from_currency_id' => 'id']],
            [['to_currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['to_currency_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('erp.sys', 'ID'),
            'rate_name' => Yii::t('erp.sys', 'Rate Name'),
            'from_currency_id' => Yii::t('erp.sys', 'From Currency ID'),
            'to_currency_id' => Yii::t('erp.sys', 'To Currency ID'),
            'value' => Yii::t('erp.sys', 'Value'),
            'type' => Yii::t('erp.sys', 'Type'),
            'frequency' => Yii::t('erp.sys', 'Frequency'),
            'created_at' => Yii::t('erp.sys', 'Created At'),
            'updated_at' => Yii::t('erp.sys', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'from_currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'to_currency_id']);
    }
}
