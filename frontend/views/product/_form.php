<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Alert;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\bootstra4\ActiveForm */
?>

<?php
  $flash_messages = Yii::$app->session->getFlash('company-create',[]);
  array_merge($flash_messages,Yii::$app->session->getFlash('product-create',[]));
  if (!empty($flash_messages)) :
    echo Alert::widget([
       'options' => ['class' => 'alert-info'],
       'body' => "<pre>".implode("<br/>", $flash_messages)."</pre>",
    ]);
  endif;
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model['product'], 'product_type_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model['product'], 'name')->textInput(['maxlength' => true])->label(null, ['class' => 'required-field']) ?>

    <?= $form->field($model['product'], 'name_desc')->textarea(['rows' => 6])->label(null, ['class' => ' optional-field']) ?>

    <?= $form->field($model['product_price'], 'sku')->textInput(['maxlength' => true])->label(null, ['class' => ' optional-field']) ?>

    <?= $form->field($model['product_price'], 'presentation')->textInput()->label(null, ['class' => 'required-field']) ?>

    <?= $form->field($model['product_price'], 'price')->textInput()->label(null, ['class' => 'required-field']) ?>

    <!--?= $form->field($model, 'brand_id')->textInput(['maxlength' => true]) ?-->
    <?= $form->field($model['product'], 'brand_id')
      ->dropDownList(Yii::$app->user->identity->brandList, ['prompt' => \Yii::t('eventplanner.company', 'Select Brand...'), 'options' => ['value' => 'none', 'class' =>'prompt']])
      ->label(\Yii::t('eventplanner.company', 'Brand'), ['class' => ' optional-field'])  ?>

    <?= $form->field($model['product'], 'category_id')
      ->dropDownList($category, ['prompt' => \Yii::t('eventplanner.company', 'Select Category...'), 'options' => ['value' => 'none', 'class' =>'prompt']])
      ->label(\Yii::t('eventplanner.company', 'Category'), ['class' => ' optional-field'])  ?>

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('eventplanner.company', $model['product']->isNewRecord? 'Save' : 'Update'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
