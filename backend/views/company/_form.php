<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Company */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'legal_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nit')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'details')->textarea(['rows' => 6]) ?>

    <?php //= $form->field($model, 'created_at')->textInput() ?>

    <?php //= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('sys.company', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
