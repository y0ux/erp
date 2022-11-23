<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property string $id
 * @property string $short_name
 * @property string $long_name
 * @property string $short_name_en
 * @property string $long_name_en
 * @property int $type 0 = none, 1 = iso, 2 = non-iso, 3 = unofficial, 4 = crypto
 * @property string $symbol_utf8
 * @property string $symbol_unicode
 * @property string $iso4217_alpha
 * @property int $iso4217_numeric
 * @property int $iso4217_minor_unit
 * @property string $format
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CashBoxDetail[] $cashBoxDetails
 * @property CashFlowTransaction[] $cashFlowTransactions
 * @property Country[] $countries
 * @property CurrencyNote[] $currencyNotes
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
            [['short_name', 'long_name', 'type'], 'required'],
            [['type', 'iso4217_numeric', 'iso4217_minor_unit'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['short_name', 'short_name_en'], 'string', 'max' => 80],
            [['long_name', 'long_name_en', 'format'], 'string', 'max' => 255],
            [['symbol_utf8'], 'string', 'max' => 4],
            [['symbol_unicode'], 'string', 'max' => 6],
            [['iso4217_alpha'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('erp.sys', 'ID'),
            'short_name' => Yii::t('erp.sys', 'Short Name'),
            'long_name' => Yii::t('erp.sys', 'Long Name'),
            'short_name_en' => Yii::t('erp.sys', 'Short Name En'),
            'long_name_en' => Yii::t('erp.sys', 'Long Name En'),
            'type' => Yii::t('erp.sys', 'Type'),
            'symbol_utf8' => Yii::t('erp.sys', 'Symbol Utf8'),
            'symbol_unicode' => Yii::t('erp.sys', 'Symbol Unicode'),
            'iso4217_alpha' => Yii::t('erp.sys', 'Iso4217 Alpha'),
            'iso4217_numeric' => Yii::t('erp.sys', 'Iso4217 Numeric'),
            'iso4217_minor_unit' => Yii::t('erp.sys', 'Iso4217 Minor Unit'),
            'format' => Yii::t('erp.sys', 'Format'),
            'created_at' => Yii::t('erp.sys', 'Created At'),
            'updated_at' => Yii::t('erp.sys', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCashBoxDetails()
    {
        return $this->hasMany(CashBoxDetail::className(), ['currency_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCashFlowTransactions()
    {
        return $this->hasMany(CashFlowTransaction::className(), ['currency_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountries()
    {
        return $this->hasMany(Country::className(), ['currency_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencyNotes()
    {
        return $this->hasMany(CurrencyNote::className(), ['currency_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getCurrencyList($as_object = false)
    {
        $currencies = self::find()->all();
        $list = [];
        foreach($currencies as $currency) {
            if ($as_object)
                $list[$currency->id] = $currency;
            else
                $list[$currency->id] = $currency->short_name;
        }
        return $list;

    }
}
