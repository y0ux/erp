<?php

use yii\helpers\Html;
use yii\bootstra4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\BeerSearch */
/* @var $form yii\bootstra4\ActiveForm */
?>

<div class="beer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'beer_style_id') ?>

    <?= $form->field($model, 'abv') ?>

    <?= $form->field($model, 'ibu') ?>

    <?php // echo $form->field($model, 'srm_color_id') ?>

    <?php // echo $form->field($model, 'og') ?>

    <?php // echo $form->field($model, 'fg') ?>

    <?php // echo $form->field($model, 'aroma') ?>

    <?php // echo $form->field($model, 'flavor') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('eventplanner.company', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('eventplanner.company', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
