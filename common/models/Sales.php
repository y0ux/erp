<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sales".
 *
 * @property string $id
 * @property string $product_id
 * @property string $presentation
 * @property int $quantity
 * @property double $price
 * @property string $year
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Product $product
 */
class Sales extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'presentation', 'year'], 'required'],
            [['product_id', 'quantity'], 'integer'],
            [['price'], 'number'],
            [['year', 'created_at', 'updated_at'], 'safe'],
            [['presentation'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('eventplanner.company', 'ID'),
            'product_id' => Yii::t('eventplanner.company', 'Product ID'),
            'presentation' => Yii::t('eventplanner.company', 'Presentation'),
            'quantity' => Yii::t('eventplanner.company', 'Quantity'),
            'price' => Yii::t('eventplanner.company', 'Price'),
            'year' => Yii::t('eventplanner.company', 'Year'),
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
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
