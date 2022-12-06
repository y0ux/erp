<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property int $id
 * @property string $short_name
 * @property string $spanish_short_name
 * @property string $local_name
 * @property string $full_name
 * @property string $iso_3166_1_alpha_2_code
 * @property string $iso_3166_1_alpha_3_code
 * @property int $iso_3166_1_numeric
 * @property string $phone_code
 * @property string $postal_code_regex
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CountryCurrency[] $countryCurrencies
 * @property Currency[] $currencies
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['short_name', 'spanish_short_name', 'iso_3166_1_alpha_2_code', 'iso_3166_1_alpha_3_code', 'iso_3166_1_numeric', 'created_at'], 'required'],
            [['iso_3166_1_numeric'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['short_name', 'spanish_short_name', 'local_name'], 'string', 'max' => 255],
            [['full_name'], 'string', 'max' => 512],
            [['iso_3166_1_alpha_2_code'], 'string', 'max' => 2],
            [['iso_3166_1_alpha_3_code'], 'string', 'max' => 3],
            [['phone_code', 'postal_code_regex'], 'string', 'max' => 20],
            [['short_name'], 'unique'],
            [['iso_3166_1_alpha_2_code'], 'unique'],
            [['iso_3166_1_alpha_3_code'], 'unique'],
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
            'spanish_short_name' => Yii::t('erp.sys', 'Spanish Short Name'),
            'local_name' => Yii::t('erp.sys', 'Local Name'),
            'full_name' => Yii::t('erp.sys', 'Full Name'),
            'iso_3166_1_alpha_2_code' => Yii::t('erp.sys', 'Iso 3166 1 Alpha 2 Code'),
            'iso_3166_1_alpha_3_code' => Yii::t('erp.sys', 'Iso 3166 1 Alpha 3 Code'),
            'iso_3166_1_numeric' => Yii::t('erp.sys', 'Iso 3166 1 Numeric'),
            'phone_code' => Yii::t('erp.sys', 'Phone Code'),
            'postal_code_regex' => Yii::t('erp.sys', 'Postal Code Regex'),
            'created_at' => Yii::t('erp.sys', 'Created At'),
            'updated_at' => Yii::t('erp.sys', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountryCurrencies()
    {
        return $this->hasMany(CountryCurrency::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencies()
    {
        return $this->hasMany(Currency::className(), ['id' => 'currency_id'])->viaTable('country_currency', ['country_id' => 'id']);
    }
}
