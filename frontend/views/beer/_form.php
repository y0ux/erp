<?php

use yii\helpers\Html;
//use yii\bootstra4\ActiveForm;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Beer */
/* @var $form yii\bootstra4\ActiveForm */
?>

<style>
  .srm-color {
    display: inline-block;
    width: 10px;
  }
  input  {
    opacity: 1 !important;
  }
  
  <?php
  foreach ($lists['srmColor']['colors'] as $key => $value) {
    //$textColor = (parseInt("0x" + h1, 16) < parseInt("0x" + h2, 16) )? "#fff":
    ?>
    option:has(> i.hexcolor-<?php echo $value ?>) {
      color: #<?php echo (hexdec($value) < hexdec("C06202") )? "FFF": "000"; ?>;
      background-color: #<?php echo $value ?>;
    }
    <?php


  }  
  ?>
  
</style>

<div class="beer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model['beer'], 'name')->textInput(['maxlength' => true])->label(null, ['class' => 'required-field']) ?>

    <!--div class='custom-control custom-radio'>
        <?php //= Html::checkbox($model['beer'], "" , ['class' => '']) ?>
        <?php //= HTML::label('Oculta mi marca en este estilo','Company[first-time]',['class' => 'control-label optional-field']); ?>
      </div-->

    <?= $form->field($model['beer'], 'hide_brand')->checkbox()->label(null, ['class' => ' optional-field']) ?>

    <?= $form->field($model['beer'], 'beer_style_id')
      ->dropDownList($lists['beerStyle'], ['prompt' => \Yii::t('eventplanner.company', 'Select Beer Style...'), 'options' => ['value' => 'none', 'class' =>'prompt']])
      ->label(\Yii::t('eventplanner.company', 'Estilo de Cerveza'), ['class' => 'required-field'])
    ?>

    <?= $form->field($model['beer'], 'abv')->textInput()->label(null, ['class' => 'required-field']) ?>

    <?= $form->field($model['beer'], 'srm_color_id')
      ->dropDownList($lists['srmColor']['values'], [ 'encode' => false, 'prompt' => \Yii::t('eventplanner.company', 'Select Beer Color...'), 'options' => ['value' => 'none', 'class' =>'prompt']])
      ->label(\Yii::t('eventplanner.company', 'Color SRM'), ['class' => 'required-field'])
    ?>
    
    <?= $form->field($model['beer'], 'ibu')->textInput()->label(null, ['class' => ' optional-field']) ?>

    <?= $form->field($model['beer'], 'details')->textarea(['rows' => 4])->label(null, ['class' => ' optional-field']) ?>

    <!--?= $form->field($model, 'brand_id')->textInput(['maxlength' => true]) ?-->
    <?php /*= $form->field($model['product'], 'brand_id')
      ->dropDownList(Yii::$app->user->identity->brandList, ['prompt' => \Yii::t('eventplanner.company', 'Select Brand...'), 'options' => ['value' => 'none', 'class' =>'prompt']])
      ->label(\Yii::t('eventplanner.company', 'Brand'), ['class' => ' optional-field']) */ ?>

    
    
    

   

    <?php //= $form->field($model['beer'], 'og')->textInput()->label(null, ['class' => 'optional-field']) ?>

    <?php //= $form->field($model['beer'], 'fg')->textInput()->label(null, ['class' => 'optional-field']) ?>

    <?= $form->field($model['beer'], 'aroma')->textInput(['maxlength' => true])->label(null, ['class' => 'optional-field']) ?>

    <?= $form->field($model['beer'], 'flavor')->textInput(['maxlength' => true])->label(null, ['class' => 'optional-field']) ?>

    <?php /*= $form->field($model['product'], 'category_id')
      ->dropDownList($lists['category'], ['prompt' => \Yii::t('eventplanner.company', 'Select Category...'), 'options' => ['value' => 'none', 'class' =>'prompt']])
      ->label(\Yii::t('eventplanner.company', 'Category'), ['class' => ' optional-field']) */ ?>

    <?php //= $form->field($model['productPrice'], 'sku')->textInput(['maxlength' => true])->label(null, ['class' => ' optional-field']) ?>

    <?php //= $form->field($model['productPrice'], 'presentation')->textInput()->label(null, ['class' => 'required-field']) ?>

    <?php //= $form->field($model['productPrice'], 'price')->textInput()->label(null, ['class' => 'required-field']) ?>

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('eventplanner.company', $model['beer']->isNewRecord? 'Save' : 'Update'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
