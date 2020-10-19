<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CashBoxSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cash-box-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'box_type') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'venue_id') ?>

    <?php // echo $form->field($model, 'currency_id') ?>

    <?php // echo $form->field($model, 'initial_amount') ?>

    <?php // echo $form->field($model, 'details') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('sys.cashbox', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('sys.cashbox', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
