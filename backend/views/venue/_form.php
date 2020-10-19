<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Venue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="venue-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'company_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_id')
      ->dropDownList(Yii::$app->user->identity->companyList, ['prompt' => \Yii::t('sys.company', 'Select Company...'), 'options' => ['value' => 'none', 'class' =>'prompt']])
      ->label(\Yii::t('sys.company', 'Company'), ['class' => 'required-field'])  ?>

    <?= $form->field($model, 'legal_name')->textInput(['maxlength' => true])->label(\Yii::t('sys.company', 'Nombre Legal'), ['class' => 'required-field']) ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true])->label(\Yii::t('sys.company', 'Nombre'), ['class' => 'optional-field']) ?>

    <?php //= $form->field($model, 'address_id')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'details')->textarea(['rows' => 6]) ?>

    <?php //= $form->field($model, 'created_at')->textInput() ?>

    <?php //?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('sys.company', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
