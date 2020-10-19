<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\CashBox;
use common\models\Currency;

/* @var $this yii\web\View */
/* @var $model common\models\CashBox */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cash-box-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(\Yii::t('sys.cashbox', 'Name'), ['class' => 'required-field']) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'box_type')->textInput() ?>

    <?= $form->field($model, 'box_type')
      ->radioList(CashBox::getCashBoxTypes(), ['prompt' => \Yii::t('sys.company', 'Select Type...'), 'options' => ['value' => 'none', 'class' =>'prompt']])
      ->label(\Yii::t('sys.cashbox', 'Box Type'), ['class' => 'required-field'])  ?>

    <?php //= $form->field($model, 'venue_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'venue_id')
      ->dropDownList(Yii::$app->user->identity->venueList, ['prompt' => \Yii::t('sys.company', 'Select Venue...'), 'options' => ['value' => 'none', 'class' =>'prompt']])
      ->label(\Yii::t('sys.cashbox', 'Venue'), ['class' => 'required-field'])  ?>

    <?= $form->field($model, 'currency_id')
      ->dropDownList(Currency::getCurrencyList(), ['prompt' => \Yii::t('sys.erp', 'Select Currrency...'), 'options' => ['value' => 'none', 'class' =>'prompt']])
      ->label(\Yii::t('sys.erp', 'Currency'), ['class' => 'required-field'])  ?>

    <?php //= $form->field($model, 'initial_amount')->textInput()->label(\Yii::t('sys.cashbox', 'Initial Ammount'), ['class' => 'required-field']) ?>

    <?php //= $form->field($model, 'details')->textarea(['rows' => 6]) ?>

    <?php //= $form->field($model, 'created_at')->textInput() ?>

    <?php //= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('sys.cashbox', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
