<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property string $id
 * @property string $name
 * @property string $stand_number
 * @property string $negotiation_type
 * @property string $stand_size
 * @property string $status
 * @property double $amount
 * @property string $company_id
 * @property string $details
 *
 * @property Company $id0
 */
class Brand extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'company_id'], 'required'],
            [['stand_number', 'negotiation_type', 'status', 'company_id'], 'integer'],
            [['amount'], 'number'],
            [['details'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['stand_size'], 'string', 'max' => 20],
            [['name'], 'unique'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'stand_number' => 'Stand Number',
            'negotiation_type' => 'Negotiation Type',
            'stand_size' => 'Stand Size',
            'status' => 'Status',
            'amount' => 'Amount',
            'company_id' => 'Company ID',
            'details' => 'Details',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Company::className(), ['id' => 'id']);
    }
}
