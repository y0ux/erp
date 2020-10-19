<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CurrencyNote */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="currency-note-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'note_type')->textInput() ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <?= $form->field($model, 'currency_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('sys.erp', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
