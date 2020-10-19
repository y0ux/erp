<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdministrativeLevelArea1 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="administrative-level-area1-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'long_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'long_name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iso3166_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'latitude')->textInput() ?>

    <?= $form->field($model, 'longitude')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('sys.erp', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
