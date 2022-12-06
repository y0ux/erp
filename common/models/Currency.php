<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @property string $denominations
 * @property string $iso_4217_alphabetic_code
 * @property int $iso_4217_numberic_code
 * @property int $iso_4217_minor_unit
 * @property string $symbol
 * @property string $symbol_name
 * @property string $symbol_unicode
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CountryCurrency[] $countryCurrencies
 * @property Country[] $countries
 * @property ExchangeRate[] $exchangeRates
 * @property ExchangeRate[] $exchangeRates0
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'denominations', 'iso_4217_alphabetic_code', 'iso_4217_numberic_code', 'created_at'], 'required'],
            [['status', 'iso_4217_numberic_code', 'iso_4217_minor_unit'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'denominations'], 'string', 'max' => 255],
            [['iso_4217_alphabetic_code'], 'string', 'max' => 3],
            [['symbol'], 'string', 'max' => 5],
            [['symbol_name'], 'string', 'max' => 20],
            [['symbol_unicode'], 'string', 'max' => 6],
            [['iso_4217_alphabetic_code', 'iso_4217_numberic_code'], 'unique', 'targetAttribute' => ['iso_4217_alphabetic_code', 'iso_4217_numberic_code']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('erp.sys', 'ID'),
            'name' => Yii::t('erp.sys', 'Name'),
            'status' => Yii::t('erp.sys', 'Status'),
            'denominations' => Yii::t('erp.sys', 'Denominations'),
            'iso_4217_alphabetic_code' => Yii::t('erp.sys', 'Iso 4217 Alphabetic Code'),
            'iso_4217_numberic_code' => Yii::t('erp.sys', 'Iso 4217 Numberic Code'),
            'iso_4217_minor_unit' => Yii::t('erp.sys', 'Iso 4217 Minor Unit'),
            'symbol' => Yii::t('erp.sys', 'Symbol'),
            'symbol_name' => Yii::t('erp.sys', 'Symbol Name'),
            'symbol_unicode' => Yii::t('erp.sys', 'Symbol Unicode'),
            'created_at' => Yii::t('erp.sys', 'Created At'),
            'updated_at' => Yii::t('erp.sys', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountryCurrencies()
    {
        return $this->hasMany(CountryCurrency::className(), ['currency_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountries()
    {
        return $this->hasMany(Country::className(), ['id' => 'country_id'])->viaTable('country_currency', ['currency_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExchangeRates()
    {
        return $this->hasMany(ExchangeRate::className(), ['from_currency_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExchangeRates0()
    {
        return $this->hasMany(ExchangeRate::className(), ['to_currency_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function findCurrencyByISO($iso)
    {
        return Currency::find()->where(['iso_4217_alphabetic_code' => $iso])->one();
    }
}
