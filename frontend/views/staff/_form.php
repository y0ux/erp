<?php

use yii\helpers\Html;
//use yii\bootstra4\ActiveForm;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Staff */
/* @var $form yii\bootstra4\ActiveForm */
?>

<div class="staff-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
      <div class="col-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(null, ['class' => 'required-field']) ?>
      </div>
      <div class="col-6">
        <?php
          $genders = [
            1 => Yii::t('erp.company', 'Male.'),
            2 => Yii::t('erp.company', 'Female'),
            3 => Yii::t('erp.company', 'Otro'),
          ];
        ?>
        <?= $form->field($model, 'gender')->inline(true)->radioList($genders)->label(null, ['class' => 'required-field']) ?>
      </div>
    </div>

    <?php
      $document_types = [
        1 => Yii::t('erp.company', 'DPI o DNI'),
        2 => Yii::t('erp.company', 'Passport'),
        3 => Yii::t('erp.company', 'License'),
        4 => Yii::t('erp.company', 'Other'),
        //4 => Yii::t('erp.company', ''),
      ];
    ?>
    <div class="row">
      <div class="col-6">
        <?= $form->field($model, 'document_number')->textInput(['maxlength' => true])->label(null, ['class' => 'required-field']) ?>
      </div>
      <div class="col-6">
        <?= $form->field($model, 'document_type')->inline(true)->radioList($document_types)->label(null, ['class' => 'required-field']) ?>
      </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('erp.company', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
