<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "bank_account".
 *
 * @property string $id
 * @property string $beneficiary
 * @property string $account_number
 * @property string $type
 * @property string $bank_id
 * @property string $created_at
 * @property string $updated_at
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
            [['type', 'bank_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['beneficiary', 'account_number'], 'string', 'max' => 255],
            [['bank_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bank::className(), 'targetAttribute' => ['bank_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('erp.company', 'ID'),
            'beneficiary' => Yii::t('erp.company', 'Beneficiary'),
            'account_number' => Yii::t('erp.company', 'Account Number'),
            'type' => Yii::t('erp.company', 'Account Type'),
            'bank_id' => Yii::t('erp.company', 'Bank ID'),
            'created_at' => Yii::t('erp.company', 'Created At'),
            'updated_at' => Yii::t('erp.company', 'Updated At'),
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
