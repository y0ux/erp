<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Locality */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="locality-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'long_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'long_name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'administritative_level_area_1_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'administritative_level_area_2_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'postal_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'latitude')->textInput() ?>

    <?= $form->field($model, 'longitude')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('sys.erp', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
