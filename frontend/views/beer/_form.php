<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Beer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="beer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model['product'], 'name')->textInput(['maxlength' => true])->label(null, ['class' => 'required-field']) ?>

    <?= $form->field($model['product'], 'name_desc')->textarea(['rows' => 6])->label(null, ['class' => ' optional-field']) ?>

    <!--?= $form->field($model, 'brand_id')->textInput(['maxlength' => true]) ?-->
    <?= $form->field($model['product'], 'brand_id')
      ->dropDownList(Yii::$app->user->identity->brandList, ['prompt' => \Yii::t('eventplanner.company', 'Select Brand...'), 'options' => ['value' => 'none', 'class' =>'prompt']])
      ->label(\Yii::t('eventplanner.company', 'Brand'), ['class' => ' optional-field'])  ?>

    <?= $form->field($model['beer'], 'beer_style_id')
      ->dropDownList($lists['beerStyle'], ['prompt' => \Yii::t('eventplanner.company', 'Select Beer Style...'), 'options' => ['value' => 'none', 'class' =>'prompt']])
      ->label(\Yii::t('eventplanner.company', 'Beer Style'), ['class' => 'required-field'])
     ?>

    <?= $form->field($model['beer'], 'abv')->textInput()->label(null, ['class' => 'required-field']) ?>

    <?= $form->field($model['beer'], 'ibu')->textInput()->label(null, ['class' => 'required-field']) ?>

    <?= $form->field($model['beer'], 'srm_color_id')
      ->dropDownList($lists['srmColor'], ['prompt' => \Yii::t('eventplanner.company', 'Select Beer Color...'), 'options' => ['value' => 'none', 'class' =>'prompt']])
      ->label(\Yii::t('eventplanner.company', 'Beer Color'), ['class' => 'required-field'])
    ?>

    <?= $form->field($model['beer'], 'og')->textInput()->label(null, ['class' => 'optional-field']) ?>

    <?= $form->field($model['beer'], 'fg')->textInput()->label(null, ['class' => 'optional-field']) ?>

    <?= $form->field($model['beer'], 'aroma')->textInput(['maxlength' => true])->label(null, ['class' => 'optional-field']) ?>

    <?= $form->field($model['beer'], 'flavor')->textInput(['maxlength' => true])->label(null, ['class' => 'optional-field']) ?>

    <?= $form->field($model['product'], 'category_id')
      ->dropDownList($lists['category'], ['prompt' => \Yii::t('eventplanner.company', 'Select Category...'), 'options' => ['value' => 'none', 'class' =>'prompt']])
      ->label(\Yii::t('eventplanner.company', 'Category'), ['class' => ' optional-field'])  ?>

    <?= $form->field($model['productPrice'], 'sku')->textInput(['maxlength' => true])->label(null, ['class' => ' optional-field']) ?>

    <?= $form->field($model['productPrice'], 'presentation')->textInput()->label(null, ['class' => 'required-field']) ?>

    <?= $form->field($model['productPrice'], 'price')->textInput()->label(null, ['class' => 'required-field']) ?>

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('eventplanner.company', $model['product']->isNewRecord? 'Save' : 'Update'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
