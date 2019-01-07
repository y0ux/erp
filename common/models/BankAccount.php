<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bank_account".
 *
 * @property string $id
 * @property string $beneficiary
 * @property string $account_number
 * @property string $type
 * @property string $bank_id
 *
 * @property Bank $bank
 * @property CompanyBankAccount[] $companyBankAccounts
 * @property Company[] $companies
 */
class BankAccount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bank_account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['beneficiary', 'account_number', 'type', 'bank_id'], 'required'],
            [['account_number', 'type', 'bank_id'], 'integer'],
            [['beneficiary'], 'string', 'max' => 255],
            [['bank_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bank::className(), 'targetAttribute' => ['bank_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'beneficiary' => 'Beneficiary',
            'account_number' => 'Account Number',
            'type' => 'Type',
            'bank_id' => 'Bank ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBank()
    {
        return $this->hasOne(Bank::className(), ['id' => 'bank_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyBankAccounts()
    {
        return $this->hasMany(CompanyBankAccount::className(), ['bank_account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['id' => 'company_id'])->viaTable('company_bank_account', ['bank_account_id' => 'id']);
    }
}
