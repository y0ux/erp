<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Country */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="country-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'long_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'long_name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iso3166_1_a2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iso3166_1_a3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iso3166_1_numeric')->textInput() ?>

    <?= $form->field($model, 'itut_e164')->textInput() ?>

    <?= $form->field($model, 'cctld')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'language_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'language_name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'language_iso639')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'latitude')->textInput() ?>

    <?= $form->field($model, 'longitude')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('sys.erp', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
