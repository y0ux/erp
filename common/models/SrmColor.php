<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "srm_color".
 *
 * @property string $id
 * @property string $color
 * @property int $initial_range
 * @property int $final_range
 * @property string $details
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Beer[] $beers
 */
class SrmColor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'srm_color';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color', 'initial_range', 'final_range'], 'required'],
            [['initial_range', 'final_range'], 'integer'],
            [['details'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['color'], 'string', 'max' => 255],
            [['color'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('eventplanner.company', 'ID'),
            'color' => Yii::t('eventplanner.company', 'Color'),
            'initial_range' => Yii::t('eventplanner.company', 'Initial Range'),
            'final_range' => Yii::t('eventplanner.company', 'Final Range'),
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
        return $this->hasMany(Beer::className(), ['srm_color_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getSrmColorList()
    {
        $colors = [];
        $list = self::find()->all();
        foreach ($list as $item)
            $colors[$item->id] = $item->color;
        return $colors;
    }
}
