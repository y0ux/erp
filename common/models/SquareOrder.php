<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "square_order".
 *
 * @property string $id
 * @property string $transaction_id
 * @property string $location_id
 * @property string $outside_created_at
 * @property string $outside_updated_at
 * @property string $outside_closed_at
 * @property string $state
 * @property string $amount_money
 * @property string $currency_money
 * @property string $type_money
 * @property string $total_discount
 * @property string $updated_at
 * @property string $created_at
 *
 * @property SquareOrderItem[] $squareOrderItems
 */
class SquareOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'square_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transaction_id', 'location_id', 'outside_created_at', 'state', 'currency_money', 'type_money'], 'required'],
            [['outside_created_at', 'outside_updated_at', 'outside_closed_at', 'updated_at', 'created_at'], 'safe'],
            [['amount_money', 'total_discount'], 'integer'],
            [['transaction_id', 'location_id', 'state', 'type_money'], 'string', 'max' => 32],
            [['currency_money'], 'string', 'max' => 4],
            [['transaction_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('erp', 'ID'),
            'transaction_id' => Yii::t('erp', 'Transaction ID'),
            'location_id' => Yii::t('erp', 'Location ID'),
            'outside_created_at' => Yii::t('erp', 'Outside Created At'),
            'outside_updated_at' => Yii::t('erp', 'Outside Updated At'),
            'outside_closed_at' => Yii::t('erp', 'Outside Closed At'),
            'state' => Yii::t('erp', 'State'),
            'amount_money' => Yii::t('erp', 'Amount Money'),
            'currency_money' => Yii::t('erp', 'Currency Money'),
            'type_money' => Yii::t('erp', 'Type Money'),
            'total_discount' => Yii::t('erp', 'Total Discount'),
            'updated_at' => Yii::t('erp', 'Updated At'),
            'created_at' => Yii::t('erp', 'Created At'),
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
    public function getSquareOrderItems()
    {
        return $this->hasMany(SquareOrderItem::className(), ['square_order_id' => 'id'])->inverseOf('squareOrder');
    }
}
