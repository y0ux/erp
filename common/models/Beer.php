<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "beer".
 *
 * @property string $id
 * @property string $product_id
 * @property string $beer_style_id
 * @property double $abv
 * @property double $ibu
 * @property string $srm_color_id
 * @property double $og
 * @property double $fg
 * @property string $aroma
 * @property string $flavor
 * @property string $created_at
 * @property string $updated_at
 *
 * @property SrmColor $srmColor
 * @property BeerStyle $beerStyle
 * @property Product $product
 */
class Beer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'beer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'beer_style_id', 'abv', 'ibu', 'srm_color_id'], 'required'],
            [['product_id', 'beer_style_id', 'srm_color_id'], 'integer'],
            [['abv', 'ibu', 'og', 'fg'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['aroma', 'flavor'], 'string', 'max' => 255],
            [['srm_color_id'], 'exist', 'skipOnError' => true, 'targetClass' => SrmColor::className(), 'targetAttribute' => ['srm_color_id' => 'id']],
            [['beer_style_id'], 'exist', 'skipOnError' => true, 'targetClass' => BeerStyle::className(), 'targetAttribute' => ['beer_style_id' => 'id']],
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
            'beer_style_id' => Yii::t('eventplanner.company', 'Beer Style ID'),
            'abv' => Yii::t('eventplanner.company', 'Abv'),
            'ibu' => Yii::t('eventplanner.company', 'Ibu'),
            'srm_color_id' => Yii::t('eventplanner.company', 'Srm Color ID'),
            'og' => Yii::t('eventplanner.company', 'Og'),
            'fg' => Yii::t('eventplanner.company', 'Fg'),
            'aroma' => Yii::t('eventplanner.company', 'Aroma'),
            'flavor' => Yii::t('eventplanner.company', 'Flavor'),
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
    public function getSrmColor()
    {
        return $this->hasOne(SrmColor::className(), ['id' => 'srm_color_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeerStyle()
    {
        return $this->hasOne(BeerStyle::className(), ['id' => 'beer_style_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
