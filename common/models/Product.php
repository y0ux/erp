<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product".
 *
 * @property string $id
 * @property string $name
 * @property string $name_desc
 * @property string $details
 * @property string $company_id
 * @property string $brand_id
 * @property string $product_type_id
 * @property string $category_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Beer $beer
 * @property Beer[] $beers
 * @property Category $category
 * @property Brand $brand
 * @property ProductType $productType
 * @property Company $company
 * @property ProductPrice[] $productPrices
 * @property Sales[] $sales
 */
class Product extends \yii\db\ActiveRecord
{

    CONST BEER = 1;
    CONST OTHER = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'company_id', 'product_type_id'], 'required'],
            [['name_desc', 'details'], 'string'],
            [['company_id', 'brand_id', 'product_type_id', 'category_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'id']],
            //[['product_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductType::className(), 'targetAttribute' => ['product_type_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('erp.company', 'ID'),
            'name' => Yii::t('erp.company', 'Name'),
            'name_desc' => Yii::t('erp.company', 'Name Desc'),
            'details' => Yii::t('erp.company', 'Details'),
            'company_id' => Yii::t('erp.company', 'Company ID'),
            'brand_id' => Yii::t('erp.company', 'Brand ID'),
            'product_type_id' => Yii::t('erp.company', 'Product Type ID'),
            'category_id' => Yii::t('erp.company', 'Category ID'),
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
    public function getBeers()
    {
        return $this->hasMany(Beer::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeer()
    {
        return $this->hasOne(Beer::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductType()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'product_type_id']);
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
    public function getProductPrices()
    {
        return $this->hasMany(ProductPrice::className(), ['product_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductPrice()
    {
        return $this->hasOne(ProductPrice::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSales()
    {
        return $this->hasMany(Sales::className(), ['product_id' => 'id']);
    }
}
