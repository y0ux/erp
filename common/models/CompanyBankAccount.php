<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_bank_account".
 *
 * @property string $company_id
 * @property string $bank_account_id
 *
 * @property Company $company
 * @property BankAccount $bankAccount
 */
class CompanyBankAccount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_bank_account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'bank_account_id'], 'required'],
            [['company_id', 'bank_account_id'], 'integer'],
            [['company_id', 'bank_account_id'], 'unique', 'targetAttribute' => ['company_id', 'bank_account_id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['bank_account_id'], 'exist', 'skipOnError' => true, 'targetClass' => BankAccount::className(), 'targetAttribute' => ['bank_account_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'company_id' => 'Company ID',
            'bank_account_id' => 'Bank Account ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBankAccount()
    {
        return $this->hasOne(BankAccount::className(), ['id' => 'bank_account_id']);
    }
}
