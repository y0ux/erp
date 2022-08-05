<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Staff */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="staff-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(null, ['class' => 'required-field']) ?>

    <?php
      $genders = [
        1 => Yii::t('eventplanner.company', 'Male.'),
        2 => Yii::t('eventplanner.company', 'Female'),
      ];
    ?>
    <?= $form->field($model, 'gender')->inline(true)->radioList($genders)->label(null, ['class' => 'required-field']) ?>

    <?php
      $document_types = [
        1 => Yii::t('eventplanner.company', 'DPI o DNI'),
        2 => Yii::t('eventplanner.company', 'Passport'),
        3 => Yii::t('eventplanner.company', 'License'),
        4 => Yii::t('eventplanner.company', 'Other'),
        //4 => Yii::t('eventplanner.company', ''),
      ];
    ?>

    <?= $form->field($model, 'document_type')->inline(true)->radioList($document_types)->label(null, ['class' => 'required-field']) ?>

    <?= $form->field($model, 'document_number')->textInput(['maxlength' => true])->label(null, ['class' => 'required-field']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('eventplanner.company', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
