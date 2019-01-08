<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "stand".
 *
 * @property string $id
 * @property string $location_number
 * @property string $status
 * @property string $size
 * @property string $brand_id
 * @property string $description
 * @property string $negotiation_type
 * @property string $amount
 * @property string $created_at
 * @property string $updated_at
 */
class Stand extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stand';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['location_number', 'status', 'size', 'brand_id', 'description', 'negotiation_type', 'amount'], 'required'],
            [['location_number', 'status', 'brand_id', 'negotiation_type', 'amount'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['size'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'location_number' => 'Location Number',
            'status' => 'Status',
            'size' => 'Size',
            'brand_id' => 'Brand ID',
            'description' => 'Description',
            'negotiation_type' => 'Negotiation Type',
            'amount' => 'Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
}
