<?php

use yii\helpers\Html;
use yii\bootstra4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Vehicle */
/* @var $form yii\bootstra4\ActiveForm */
?>

<div class="vehicle-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'plate_number')->textInput(['maxlength' => true])->label(null, ['class' => 'required-field']) ?>

    <?= $form->field($model, 'vehicle_brand')->textInput(['maxlength' => true])->label(null, ['class' => 'required-field']) ?>

    <?= $form->field($model, 'vehicle_type')->textInput(['maxlength' => true])->label(null, ['class' => 'required-field']) ?>

    <?= $form->field($model, 'vehicle_color')->textInput(['maxlength' => true])->label(null, ['class' => 'required-field']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('eventplanner.company', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
