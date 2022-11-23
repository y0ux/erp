<?php

use yii\helpers\Html;
use yii\bootstra4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Brand */
/* @var $form yii\bootstra4\ActiveForm */
?>

<div class="brand-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(\Yii::t('eventplanner.company','Name'), ['class' => 'required-field']) ?>

    <?= $form->field($model, 'company_id')->hiddenInput(['value' => key(Yii::$app->user->identity->companyList)])->label(false) ?>
    <!--?= $form->field($model, 'company_id')->dropDownList(Yii::$app->user->identity->companyList, ['prompt' => 'Select one of your companies...', 'options' => ['value' => 'none', 'class' =>'prompt']])->label('Empresa')  ?-->

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('eventplanner.company', $model->isNewRecord? 'Save' : 'Update'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
