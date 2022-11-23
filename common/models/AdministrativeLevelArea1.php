<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "administrative_level_area_1".
 *
 * @property string $id
 * @property string $short_name
 * @property string $long_name
 * @property string $short_name_en
 * @property string $long_name_en
 * @property string $iso3166_2 country code<hyphen>alpha code
 * @property string $country_id
 * @property string $type state, area, region, province, department... etc
 * @property double $latitude
 * @property double $longitude
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Address[] $addresses
 * @property Country $country
 * @property AdministrativeLevelArea2[] $administrativeLevelArea2s
 * @property Locality[] $localities
 */
class AdministrativeLevelArea1 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'administrative_level_area_1';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['short_name', 'long_name', 'short_name_en', 'long_name_en', 'country_id'], 'required'],
            [['country_id'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['short_name', 'long_name', 'short_name_en', 'long_name_en', 'type'], 'string', 'max' => 255],
            [['iso3166_2'], 'string', 'max' => 10],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
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
            'iso3166_2' => Yii::t('erp.sys', 'Iso3166 2'),
            'country_id' => Yii::t('erp.sys', 'Country ID'),
            'type' => Yii::t('erp.sys', 'Type'),
            'latitude' => Yii::t('erp.sys', 'Latitude'),
            'longitude' => Yii::t('erp.sys', 'Longitude'),
            'created_at' => Yii::t('erp.sys', 'Created At'),
            'updated_at' => Yii::t('erp.sys', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['administritative_level_area_1' => 'id']);
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
    public function getAdministrativeLevelArea2s()
    {
        return $this->hasMany(AdministrativeLevelArea2::className(), ['administrative_level_area_1_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalities()
    {
        return $this->hasMany(Locality::className(), ['administritative_level_area_1_id' => 'id']);
    }
}
