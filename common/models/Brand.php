<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Company $company
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
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['stand_size'], 'string', 'max' => 20],
            [['name'], 'unique'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
