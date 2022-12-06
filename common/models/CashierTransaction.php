<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cashier_transaction".
 *
 * @property int $cashier_record_id
 * @property int $transaction_flow
 * @property int $transaction_type
 * @property int $currency_id
 * @property string $currency_name
 * @property string $currency_symbol
 * @property double $total_amount
 * @property int $exchange_rate_id
 * @property double $exhange_rate_value
 * @property double $total_rated
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CashierRecord $cashierRecord
 */
class CashierTransaction extends \yii\db\ActiveRecord
{
    const FLOW_IN = 10;
    const FLOW_OUT = 20;

    const TYPE_CASH_GTQ = 90;
    const TYPE_CASH_USD = 91;
    const TYPE_CARD = 92;
    const TYPE_TRANSFER = 93;
    const TYPE_GIFT = 94;
    const TYPE_OTHER = 99;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cashier_transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cashier_record_id', 'transaction_flow', 'transaction_type', 'currency_id', 'currency_name', 'currency_symbol', 'total_amount', 'total_rated'], 'required'],
            [['cashier_record_id', 'transaction_flow', 'transaction_type', 'currency_id', 'exchange_rate_id'], 'integer'],
            [['total_amount', 'exhange_rate_value', 'total_rated'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['currency_name'], 'string', 'max' => 91],
            [['currency_symbol'], 'string', 'max' => 5],
            [['cashier_record_id'], 'exist', 'skipOnError' => true, 'targetClass' => CashierRecord::className(), 'targetAttribute' => ['cashier_record_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cashier_record_id' => Yii::t('erp.sys', 'Cashier Record ID'),
            'transaction_flow' => Yii::t('erp.sys', 'Transaction Flow'),
            'transaction_type' => Yii::t('erp.sys', 'Transaction Type'),
            'currency_id' => Yii::t('erp.sys', 'Currency ID'),
            'currency_name' => Yii::t('erp.sys', 'Currency Name'),
            'currency_symbol' => Yii::t('erp.sys', 'Currency Symbol'),
            'total_amount' => Yii::t('erp.sys', 'Total Amount'),
            'exchange_rate_id' => Yii::t('erp.sys', 'Exchange Rate ID'),
            'exhange_rate_value' => Yii::t('erp.sys', 'Exhange Rate Value'),
            'total_rated' => Yii::t('erp.sys', 'Total Rated'),
            'created_at' => Yii::t('erp.sys', 'Created At'),
            'updated_at' => Yii::t('erp.sys', 'Updated At'),
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
    public function getCashierRecord()
    {
        return $this->hasOne(CashierRecord::className(), ['id' => 'cashier_record_id']);
    }

    public static function getTransactionTypes() {
        return [
          $self::TYPE_CASH_GTQ => Yii::t('erp.sys', 'Cash Q'),
          $self::TYPE_CASH_USD => Yii::t('erp.sys', 'Cash $'),
          $self::TYPE_CARD => Yii::t('erp.sys', 'Card'),
          $self::TYPE_TRANSFER => Yii::t('erp.sys', 'Transfer'),
          $self::TYPE_GIFT => Yii::t('erp.sys', 'Gift Cards'),
          $self::TYPE_OTHER => Yii::t('erp.sys', 'Other')
        ];
    }
}
