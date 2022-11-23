<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "locality".
 *
 * @property string $id
 * @property string $short_name
 * @property string $long_name
 * @property string $short_name_en
 * @property string $long_name_en
 * @property string $administritative_level_area_1_id
 * @property string $administritative_level_area_2_id
 * @property string $type municipality, city, shire, town, village, tribe... etc
 * @property string $postal_code
 * @property double $latitude
 * @property double $longitude
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Address[] $addresses
 * @property AdministrativeLevelArea1 $administritativeLevelArea1
 * @property AdministrativeLevelArea2 $administritativeLevelArea2
 */
class Locality extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'locality';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['short_name', 'long_name', 'short_name_en', 'long_name_en', 'administritative_level_area_1_id'], 'required'],
            [['administritative_level_area_1_id', 'administritative_level_area_2_id'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['short_name', 'long_name', 'short_name_en', 'long_name_en', 'type'], 'string', 'max' => 255],
            [['postal_code'], 'string', 'max' => 10],
            [['administritative_level_area_1_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdministrativeLevelArea1::className(), 'targetAttribute' => ['administritative_level_area_1_id' => 'id']],
            [['administritative_level_area_2_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdministrativeLevelArea2::className(), 'targetAttribute' => ['administritative_level_area_2_id' => 'id']],
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
            'administritative_level_area_1_id' => Yii::t('erp.sys', 'Administritative Level Area 1 ID'),
            'administritative_level_area_2_id' => Yii::t('erp.sys', 'Administritative Level Area 2 ID'),
            'type' => Yii::t('erp.sys', 'Type'),
            'postal_code' => Yii::t('erp.sys', 'Postal Code'),
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
        return $this->hasMany(Address::className(), ['locality_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdministritativeLevelArea1()
    {
        return $this->hasOne(AdministrativeLevelArea1::className(), ['id' => 'administritative_level_area_1_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdministritativeLevelArea2()
    {
        return $this->hasOne(AdministrativeLevelArea2::className(), ['id' => 'administritative_level_area_2_id']);
    }
}
