<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "square_order_item".
 *
 * @property string $id
 * @property string $square_order_id
 * @property string $uid
 * @property string $catalog_object_id
 * @property int $quantity
 * @property string $name
 * @property string $variation_name
 * @property string $base_price
 * @property string $base_currency
 * @property string $gross_sale
 * @property string $total_discount
 * @property string $total_money
 * @property string $json_object
 * @property string $created_at
 * @property string $updated_at
 *
 * @property SquareOrder $squareOrder
 */
class SquareOrderItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'square_order_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['square_order_id', 'uid', 'catalog_object_id', 'quantity', 'name', 'variation_name', 'base_price', 'base_currency', 'gross_sale', 'total_discount', 'total_money', 'json_object'], 'required'],
            [['square_order_id', 'quantity', 'base_price', 'gross_sale', 'total_discount', 'total_money'], 'integer'],
            [['json_object'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['uid'], 'string', 'max' => 48],
            [['catalog_object_id'], 'string', 'max' => 32],
            [['name', 'variation_name'], 'string', 'max' => 255],
            [['base_currency'], 'string', 'max' => 4],
            [['square_order_id'], 'exist', 'skipOnError' => true, 'targetClass' => SquareOrder::className(), 'targetAttribute' => ['square_order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('erp', 'ID'),
            'square_order_id' => Yii::t('erp', 'Square Order ID'),
            'uid' => Yii::t('erp', 'Uid'),
            'catalog_object_id' => Yii::t('erp', 'Catalog Object ID'),
            'quantity' => Yii::t('erp', 'Quantity'),
            'name' => Yii::t('erp', 'Name'),
            'variation_name' => Yii::t('erp', 'Variation Name'),
            'base_price' => Yii::t('erp', 'Base Price'),
            'base_currency' => Yii::t('erp', 'Base Currency'),
            'gross_sale' => Yii::t('erp', 'Gross Sale'),
            'total_discount' => Yii::t('erp', 'Total Discount'),
            'total_money' => Yii::t('erp', 'Total Money'),
            'json_object' => Yii::t('erp', 'Json Object'),
            'created_at' => Yii::t('erp', 'Created At'),
            'updated_at' => Yii::t('erp', 'Updated At'),
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
    public function getSquareOrder()
    {
        return $this->hasOne(SquareOrder::className(), ['id' => 'square_order_id'])->inverseOf('squareOrderItems');
    }
}
