<?php

use yii\helpers\Html;
use yii\bootstra4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\bootstra4\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(null, ['class' => 'required-field']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6])->label(null, ['class' => ' optional-field']) ?>

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('erp.company', $model->isNewRecord? 'Save' : 'Update'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
