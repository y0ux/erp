<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "beer".
 *
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $beer_style_id
 * @property double $abv
 * @property double $ibu
 * @property double $details
 * @property string $srm_color_id
 * @property double $og
 * @property double $fg
 * @property string $aroma
 * @property string $flavor
 * @property string $hide_brand
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
            [['user_id', 'name', 'beer_style_id', 'abv', 'srm_color_id'], 'required'],
            [['user_id', 'beer_style_id', 'srm_color_id'], 'integer'],
            [['abv', 'ibu', 'og', 'fg'], 'number'],
            [['hide_brand'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'aroma', 'flavor'], 'string', 'max' => 255],
            [['details'], 'filter', 'filter' => 'strip_tags'],
            [['srm_color_id'], 'exist', 'skipOnError' => true, 'targetClass' => SrmColor::className(), 'targetAttribute' => ['srm_color_id' => 'id']],
            [['beer_style_id'], 'exist', 'skipOnError' => true, 'targetClass' => BeerStyle::className(), 'targetAttribute' => ['beer_style_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('eventplanner.company', 'ID'),
            'user_id' => Yii::t('eventplanner.company', 'User ID'),
            'name' => Yii::t('eventplanner.company', 'Nombre'),
            'beer_style_id' => Yii::t('eventplanner.company', 'Estilo'),
            'abv' => Yii::t('eventplanner.company', 'ABV %  '),
            'ibu' => Yii::t('eventplanner.company', 'IBU'),
            'srm_color_id' => Yii::t('eventplanner.company', 'SRM Color ID'),
            'og' => Yii::t('eventplanner.company', 'Og'),
            'fg' => Yii::t('eventplanner.company', 'Fg'),
            'details' => Yii::t('eventplanner.company', 'Descripcion'),
            'aroma' => Yii::t('eventplanner.company', 'Aroma'),
            'flavor' => Yii::t('eventplanner.company', 'Sabor'),
            'hide_brand' => Yii::t('eventplanner.company', 'Ocultar mi marca en este estilo'),
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

    /* *
     * @return \yii\db\ActiveQuery
     * /
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }*/
}
