<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property string $id
 * @property string $address_line_1
 * @property string $address_line_2
 * @property string $locality_id muncipality, city, town, village
 * @property string $administritative_level_area_2 county, municipio
 * @property string $administritative_level_area_1 state, departmento
 * @property string $country_id
 * @property double $latitude
 * @property double $longitude
 * @property string $details
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Country $country
 * @property AdministrativeLevelArea1 $administritativeLevelArea1
 * @property AdministrativeLevelArea2 $administritativeLevelArea2
 * @property Locality $locality
 * @property CompanyAddress[] $companyAddresses
 * @property Company[] $companies
 * @property UserAddress[] $userAddresses
 * @property User[] $users
 * @property Venue[] $venues
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address_line_1'], 'required'],
            [['locality_id', 'administritative_level_area_2', 'administritative_level_area_1', 'country_id'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['details'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['address_line_1', 'address_line_2'], 'string', 'max' => 255],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['administritative_level_area_1'], 'exist', 'skipOnError' => true, 'targetClass' => AdministrativeLevelArea1::className(), 'targetAttribute' => ['administritative_level_area_1' => 'id']],
            [['administritative_level_area_2'], 'exist', 'skipOnError' => true, 'targetClass' => AdministrativeLevelArea2::className(), 'targetAttribute' => ['administritative_level_area_2' => 'id']],
            [['locality_id'], 'exist', 'skipOnError' => true, 'targetClass' => Locality::className(), 'targetAttribute' => ['locality_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('erp.sys', 'ID'),
            'address_line_1' => Yii::t('erp.sys', 'Address Line 1'),
            'address_line_2' => Yii::t('erp.sys', 'Address Line 2'),
            'locality_id' => Yii::t('erp.sys', 'Locality ID'),
            'administritative_level_area_2' => Yii::t('erp.sys', 'Administritative Level Area 2'),
            'administritative_level_area_1' => Yii::t('erp.sys', 'Administritative Level Area 1'),
            'country_id' => Yii::t('erp.sys', 'Country ID'),
            'latitude' => Yii::t('erp.sys', 'Latitude'),
            'longitude' => Yii::t('erp.sys', 'Longitude'),
            'details' => Yii::t('erp.sys', 'Details'),
            'created_at' => Yii::t('erp.sys', 'Created At'),
            'updated_at' => Yii::t('erp.sys', 'Updated At'),
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
    public function getAdministritativeLevelArea1()
    {
        return $this->hasOne(AdministrativeLevelArea1::className(), ['id' => 'administritative_level_area_1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdministritativeLevelArea2()
    {
        return $this->hasOne(AdministrativeLevelArea2::className(), ['id' => 'administritative_level_area_2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocality()
    {
        return $this->hasOne(Locality::className(), ['id' => 'locality_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyAddresses()
    {
        return $this->hasMany(CompanyAddress::className(), ['address_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['id' => 'company_id'])->viaTable('company_address', ['address_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAddresses()
    {
        return $this->hasMany(UserAddress::className(), ['address_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_address', ['address_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVenues()
    {
        return $this->hasMany(Venue::className(), ['address_id' => 'id']);
    }
}
