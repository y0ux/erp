<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cashbox_detail".
 *
 * @property int $cashier_record_id
 * @property int $currency_id
 * @property string $currency_name
 * @property string $currency_symbol
 * @property double $currency_value
 * @property int $quantity
 * @property double $total_value
 * @property int $exchange_rate_id
 * @property double $exhange_rate_value
 * @property double $total_rated
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CashierRecord $cashierRecord
 */
class CashboxDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cashbox_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cashier_record_id', 'currency_id', 'currency_name', 'currency_symbol', 'currency_value', 'total_rated'], 'required'],
            [['cashier_record_id', 'currency_id', 'quantity', 'exchange_rate_id'], 'integer'],
            [['currency_value', 'total_value', 'exhange_rate_value', 'total_rated'], 'number'],
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
            'currency_id' => Yii::t('erp.sys', 'Currency ID'),
            'currency_name' => Yii::t('erp.sys', 'Currency Name'),
            'currency_symbol' => Yii::t('erp.sys', 'Currency Symbol'),
            'currency_value' => Yii::t('erp.sys', 'Currency Value'),
            'quantity' => Yii::t('erp.sys', 'Quantity'),
            'total_value' => Yii::t('erp.sys', 'Total Value'),
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
}
