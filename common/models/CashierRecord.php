<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cashier_record".
 *
 * @property int $id
 * @property int $created_by_user_id
 * @property string $created_by_username
 * @property string $created_by_full_name
 * @property int $record_type
 * @property double $cashbox_total
 * @property double $income_total
 * @property double $outcome_total
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CashboxDetail[] $cashboxDetails
 * @property CashierTransaction[] $cashierTransactions
 */
class CashierRecord extends \yii\db\ActiveRecord
{
    const RECORD_OPENING = 10;
    const RECORD_CLOSING = 20;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cashier_record';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_by_user_id', 'created_by_username', 'created_by_full_name', 'record_type', 'cashbox_total'], 'required'],
            [['created_by_user_id', 'record_type'], 'integer'],
            [['cashbox_total', 'income_total', 'outcome_total'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by_username'], 'string', 'max' => 255],
            [['created_by_full_name'], 'string', 'max' => 91],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('erp.sys', 'ID'),
            'created_by_user_id' => Yii::t('erp.sys', 'Created By User ID'),
            'created_by_username' => Yii::t('erp.sys', 'Created By Username'),
            'created_by_full_name' => Yii::t('erp.sys', 'Created By Full Name'),
            'record_type' => Yii::t('erp.sys', 'Record Type'),
            'cashbox_total' => Yii::t('erp.sys', 'Cashbox Total'),
            'income_total' => Yii::t('erp.sys', 'Income Total'),
            'outcome_total' => Yii::t('erp.sys', 'Outcome Total'),
            'created_at' => Yii::t('erp.sys', 'Created At'),
            'updated_at' => Yii::t('erp.sys', 'Updated At'),
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
    public function getCashboxDetails()
    {
        return $this->hasMany(CashboxDetail::className(), ['cashier_record_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCashierTransactions()
    {
        return $this->hasMany(CashierTransaction::className(), ['cashier_record_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getRecordTypes()
    {
        return [
          self::RECORD_OPENING => Yii::t('erp.sys','Opening'),
          self::RECORD_CLOSING => Yii::t('erp.sys','Closing'),
        ];
    }

    /* *
     * @return \yii\db\ActiveQuery
     * /
    public static function getTodayOpening()
    {
        return self::find()->where(['record_type' => self::RECORD_OPENING, 'created_at' => []])->all();
    }*/
}
