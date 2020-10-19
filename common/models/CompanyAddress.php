<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_address".
 *
 * @property string $company_id
 * @property string $address_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Address $address
 * @property Company $company
 */
class CompanyAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'address_id'], 'required'],
            [['company_id', 'address_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['company_id', 'address_id'], 'unique', 'targetAttribute' => ['company_id', 'address_id']],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['address_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'company_id' => Yii::t('sys.company', 'Company ID'),
            'address_id' => Yii::t('sys.company', 'Address ID'),
            'created_at' => Yii::t('sys.company', 'Created At'),
            'updated_at' => Yii::t('sys.company', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
