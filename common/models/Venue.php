<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "venue".
 *
 * @property string $id
 * @property string $company_id
 * @property string $short_name
 * @property string $legal_name
 * @property string $address_id
 * @property string $details
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CashBox[] $cashBoxes
 * @property CashFlowTransaction[] $cashFlowTransactions
 * @property Company $company
 * @property Address $address
 */
class Venue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'venue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'short_name'], 'required'],
            [['company_id', 'address_id'], 'integer'],
            [['details'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['short_name', 'legal_name'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['address_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sys.company', 'ID'),
            'company_id' => Yii::t('sys.company', 'Company ID'),
            'short_name' => Yii::t('sys.company', 'Short Name'),
            'legal_name' => Yii::t('sys.company', 'Legal Name'),
            'address_id' => Yii::t('sys.company', 'Address ID'),
            'details' => Yii::t('sys.company', 'Details'),
            'created_at' => Yii::t('sys.company', 'Created At'),
            'updated_at' => Yii::t('sys.company', 'Updated At'),
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
    public function getCashBoxes()
    {
        return $this->hasMany(CashBox::className(), ['venue_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCashFlowTransactions()
    {
        return $this->hasMany(CashFlowTransaction::className(), ['venue_id' => 'id']);
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
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }
}
