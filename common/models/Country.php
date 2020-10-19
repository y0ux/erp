<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property string $id
 * @property string $short_name
 * @property string $long_name
 * @property string $short_name_en
 * @property string $long_name_en
 * @property string $iso3166_1_a2
 * @property string $iso3166_1_a3
 * @property int $iso3166_1_numeric
 * @property int $itut_e164 phone country code
 * @property string $cctld
 * @property string $currency_id
 * @property string $language_name
 * @property string $language_name_en
 * @property string $language_iso639
 * @property double $latitude
 * @property double $longitude
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Address[] $addresses
 * @property AdministrativeLevelArea1[] $administrativeLevelArea1s
 * @property Currency $currency
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
            [['short_name', 'long_name', 'short_name_en', 'long_name_en'], 'required'],
            [['iso3166_1_numeric', 'itut_e164', 'currency_id'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['short_name', 'long_name', 'long_name_en', 'language_name', 'language_name_en'], 'string', 'max' => 255],
            [['short_name_en'], 'string', 'max' => 80],
            [['iso3166_1_a2', 'cctld', 'language_iso639'], 'string', 'max' => 2],
            [['iso3166_1_a3'], 'string', 'max' => 3],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sys.erp', 'ID'),
            'short_name' => Yii::t('sys.erp', 'Short Name'),
            'long_name' => Yii::t('sys.erp', 'Long Name'),
            'short_name_en' => Yii::t('sys.erp', 'Short Name En'),
            'long_name_en' => Yii::t('sys.erp', 'Long Name En'),
            'iso3166_1_a2' => Yii::t('sys.erp', 'Iso3166 1 A2'),
            'iso3166_1_a3' => Yii::t('sys.erp', 'Iso3166 1 A3'),
            'iso3166_1_numeric' => Yii::t('sys.erp', 'Iso3166 1 Numeric'),
            'itut_e164' => Yii::t('sys.erp', 'Itut E164'),
            'cctld' => Yii::t('sys.erp', 'Cctld'),
            'currency_id' => Yii::t('sys.erp', 'Currency ID'),
            'language_name' => Yii::t('sys.erp', 'Language Name'),
            'language_name_en' => Yii::t('sys.erp', 'Language Name En'),
            'language_iso639' => Yii::t('sys.erp', 'Language Iso639'),
            'latitude' => Yii::t('sys.erp', 'Latitude'),
            'longitude' => Yii::t('sys.erp', 'Longitude'),
            'created_at' => Yii::t('sys.erp', 'Created At'),
            'updated_at' => Yii::t('sys.erp', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdministrativeLevelArea1s()
    {
        return $this->hasMany(AdministrativeLevelArea1::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }
}
