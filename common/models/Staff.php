<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "staff".
 *
 * @property string $id
 * @property string $company_id
 * @property string $name
 * @property int $gender
 * @property int $document_type
 * @property string $document_number
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Company $company
 */
class Staff extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'staff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'name', 'gender', 'document_type', 'document_number'], 'required'],
            [['company_id', 'gender', 'document_type'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'document_number'], 'string', 'max' => 255],
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
            'company_id' => Yii::t('erp.company', 'Company ID'),
            'name' => Yii::t('erp.company', 'Name'),
            'gender' => Yii::t('erp.company', 'Gender'),
            'document_type' => Yii::t('erp.company', 'Document Type'),
            'document_number' => Yii::t('erp.company', 'Document Number'),
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
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
