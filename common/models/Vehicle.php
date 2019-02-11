<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "vehicle".
 *
 * @property string $id
 * @property string $company_id
 * @property string $plate_number
 * @property string $vehicle_brand
 * @property string $vehicle_type
 * @property string $vehicle_color
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Company $company
 */
class Vehicle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'plate_number', 'vehicle_brand', 'vehicle_type', 'vehicle_color'], 'required'],
            [['company_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['plate_number', 'vehicle_brand', 'vehicle_type', 'vehicle_color'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('eventplanner.company', 'ID'),
            'company_id' => Yii::t('eventplanner.company', 'Company ID'),
            'plate_number' => Yii::t('eventplanner.company', 'Plate Number'),
            'vehicle_brand' => Yii::t('eventplanner.company', 'Vehicle Brand'),
            'vehicle_type' => Yii::t('eventplanner.company', 'Vehicle Type'),
            'vehicle_color' => Yii::t('eventplanner.company', 'Vehicle Color'),
            'created_at' => Yii::t('eventplanner.company', 'Created At'),
            'updated_at' => Yii::t('eventplanner.company', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
              'class' => TimestampBehavior::className(),
              'value' => date('Y-m-d H:i:s',time()),
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
