<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "country_currency".
 *
 * @property int $country_id
 * @property int $currency_id
 * @property string $created_at
 *
 * @property Country $country
 * @property Currency $currency
 */
class CountryCurrency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country_currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_id', 'currency_id', 'created_at'], 'required'],
            [['country_id', 'currency_id'], 'integer'],
            [['created_at'], 'safe'],
            [['country_id', 'currency_id'], 'unique', 'targetAttribute' => ['country_id', 'currency_id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'country_id' => Yii::t('erp.sys', 'Country ID'),
            'currency_id' => Yii::t('erp.sys', 'Currency ID'),
            'created_at' => Yii::t('erp.sys', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }
}
