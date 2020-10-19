<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Currency */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="currency-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'long_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'long_name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'symbol_utf8')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'symbol_unicode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iso4217_alpha')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iso4217_numeric')->textInput() ?>

    <?= $form->field($model, 'iso4217_minor_unit')->textInput() ?>

    <?= $form->field($model, 'format')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('sys.erp', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
