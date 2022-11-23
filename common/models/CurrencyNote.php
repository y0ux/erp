<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "currency_note".
 *
 * @property string $id
 * @property int $note_type 1 = note, 2 = coin
 * @property double $value
 * @property string $currency_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CashBoxDetail[] $cashBoxDetails
 * @property Currency $currency
 */
class CurrencyNote extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency_note';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['note_type', 'value', 'currency_id'], 'required'],
            [['note_type', 'currency_id'], 'integer'],
            [['value'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('erp.sys', 'ID'),
            'note_type' => Yii::t('erp.sys', 'Note Type'),
            'value' => Yii::t('erp.sys', 'Value'),
            'currency_id' => Yii::t('erp.sys', 'Currency ID'),
            'created_at' => Yii::t('erp.sys', 'Created At'),
            'updated_at' => Yii::t('erp.sys', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCashBoxDetails()
    {
        return $this->hasMany(CashBoxDetail::className(), ['currency_note_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }
}
