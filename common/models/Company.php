<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property string $id
 * @property string $legal_name
 * @property string $NIT
 * @property string $address_1
 * @property string $address_2
 * @property string $details
 *
 * @property Brand $brand
 * @property CompanyBankAccount[] $companyBankAccounts
 * @property BankAccount[] $bankAccounts
 * @property UserCompany[] $userCompanies
 * @property User[] $users
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['legal_name', 'NIT', 'address_1'], 'required'],
            [['NIT'], 'integer'],
            [['details'], 'string'],
            [['legal_name', 'address_1', 'address_2'], 'string', 'max' => 255],
            [['legal_name'], 'unique'],
            [['NIT'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'legal_name' => 'Legal Name',
            'NIT' => 'Nit',
            'address_1' => 'Address 1',
            'address_2' => 'Address 2',
            'details' => 'Details',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyBankAccounts()
    {
        return $this->hasMany(CompanyBankAccount::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBankAccounts()
    {
        return $this->hasMany(BankAccount::className(), ['id' => 'bank_account_id'])->viaTable('company_bank_account', ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCompanies()
    {
        return $this->hasMany(UserCompany::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_company', ['company_id' => 'id']);
    }
}
