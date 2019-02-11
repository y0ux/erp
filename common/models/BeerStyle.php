<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "beer_style".
 *
 * @property string $id
 * @property string $name
 * @property string $details
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Beer[] $beers
 */
class BeerStyle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'beer_style';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['details'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('eventplanner.company', 'ID'),
            'name' => Yii::t('eventplanner.company', 'Name'),
            'details' => Yii::t('eventplanner.company', 'Details'),
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
    public function getBeers()
    {
        return $this->hasMany(Beer::className(), ['beer_style_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getBeerStyleList()
    {
        $styles = [];
        $list = self::find()->all();
        foreach ($list as $item)
            $styles[$item->id] = $item->name;
        return $styles;
    }
}
