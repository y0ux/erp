<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "administrative_level_area_2".
 *
 * @property string $id
 * @property string $short_name
 * @property string $long_name
 * @property string $short_name_en
 * @property string $long_name_en
 * @property string $administrative_level_area_1_id
 * @property string $type state, area, region, province, department... etc
 * @property double $latitude
 * @property double $longitude
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Address[] $addresses
 * @property AdministrativeLevelArea1 $administrativeLevelArea1
 * @property Locality[] $localities
 */
class AdministrativeLevelArea2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'administrative_level_area_2';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['short_name', 'long_name', 'short_name_en', 'long_name_en', 'administrative_level_area_1_id'], 'required'],
            [['administrative_level_area_1_id'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['short_name', 'long_name', 'short_name_en', 'long_name_en', 'type'], 'string', 'max' => 255],
            [['administrative_level_area_1_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdministrativeLevelArea1::className(), 'targetAttribute' => ['administrative_level_area_1_id' => 'id']],
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
            'administrative_level_area_1_id' => Yii::t('erp.sys', 'Administrative Level Area 1 ID'),
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
        return $this->hasMany(Address::className(), ['administritative_level_area_2' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdministrativeLevelArea1()
    {
        return $this->hasOne(AdministrativeLevelArea1::className(), ['id' => 'administrative_level_area_1_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalities()
    {
        return $this->hasMany(Locality::className(), ['administritative_level_area_2_id' => 'id']);
    }
}
