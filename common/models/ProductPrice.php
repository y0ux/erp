<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product_price".
 *
 * @property string $id
 * @property string $sku
 * @property string $presentation
 * @property double $price
 * @property string $product_id
 * @property string $details
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Product $product
 */
class ProductPrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['presentation', 'price', 'product_id'], 'required'],
            [['price'], 'number'],
            [['product_id'], 'integer'],
            [['details'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['sku', 'presentation'], 'string', 'max' => 255],
            //[['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('erp.company', 'ID'),
            'sku' => Yii::t('erp.company', 'Sku'),
            'presentation' => Yii::t('erp.company', 'Variacion'),
            'price' => Yii::t('erp.company', 'Precio'),
            'product_id' => Yii::t('erp.company', 'Product ID'),
            'details' => Yii::t('erp.company', 'Details'),
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
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
