<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AddressSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="address-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'address_line_1') ?>

    <?= $form->field($model, 'address_line_2') ?>

    <?= $form->field($model, 'locality_id') ?>

    <?= $form->field($model, 'administritative_level_area_2') ?>

    <?php // echo $form->field($model, 'administritative_level_area_1') ?>

    <?php // echo $form->field($model, 'country_id') ?>

    <?php // echo $form->field($model, 'latitude') ?>

    <?php // echo $form->field($model, 'longitude') ?>

    <?php // echo $form->field($model, 'details') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('sys.erp', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('sys.erp', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
