<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Alert;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $variation common\models\ProductPrice */
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

    <?= $form->field($model['product'], 'name')->textInput(['maxlength' => true])->label("Nombre del Producto", ['class' => 'required-field']) ?>

    <!--?= $form->field($model['product'], 'name_desc')->textarea(['rows' => 6])->label(null, ['class' => ' optional-field']) ?-->

    <!--?= $form->field($model['product_price'], 'sku')->textInput(['maxlength' => true])->label(null, ['class' => ' optional-field']) ?-->
    <!--div class="row">
      <div class="col-md-6 mb-3">
      < ?= $form->field($model['product_price'], 'presentation')->textInput()->label(null, ['class' => 'required-field']) ?>
      </div>
      <div class="col-md-6 mb-3">
      < ?= $form->field($model['product_price'], 'price')->textInput()->label(null, ['class' => 'required-field']) ?>
      </div>
    </div-->

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0–9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 4, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $model['product_price'][0],
        'formId' => 'w0',
        'formFields' => [
          'presentation',
          'price',
        ],

    ]); ?>

    <div class="">
        <div class="d-flex justify-content-between">
          <h5 class="d-inline-block">Variacion de Precio</h5>
          <button type="button" class="add-item btn btn-success btn-sm"><i class="fa fa-plus"></i> Add</button>
        </div>

        <div class="border p-3 mb-3 mt-3 bg-light container-items"><!-- widgetContainer -->
          <?php foreach ($model['product_price'] as $index => $productPrice): ?>
          <div class="item"><!-- widgetBody -->
            <div class="d-flex justify-content-between">
              <b class=""><?= $productPrice->isNewRecord? "Add" : "Update" ?> <?php //= ($index + 1) ?></b>
              <button type="button" class="remove-item btn btn-danger btn-sm"><i class="fa fa-xmark"></i></button>
            </div>
            <hr class="mb-4">
            <div class="">
              <?php
              // necessary for update action.
              if (!$productPrice->isNewRecord) {
                echo Html::activeHiddenInput($productPrice, "[{$index}]id");
              }
              ?>

              <div class="row">
                <div class="col-sm-6">
                  <?= $form->field($productPrice, "[{$index}]presentation")->textInput()->label("Nombre (ej: 4 oz)", ['class' => 'required-field']) ?>
                </div>
                <div class="col-sm-6">
                  <?= $form->field($productPrice, "[{$index}]price")->textInput()->label(null, ['class' => 'required-field']) ?>
                </div>
              </div><!-- end:row -->
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        </div>
        <?php DynamicFormWidget::end(); ?>





    <!--?= $form->field($model, 'brand_id')->textInput(['maxlength' => true]) ?-->
    <!--?= $form->field($model['product'], 'brand_id')
      ->dropDownList(Yii::$app->user->identity->brandList, ['prompt' => \Yii::t('erp.company', 'Select Brand...'), 'options' => ['value' => 'none', 'class' =>'prompt']])
      ->label(\Yii::t('erp.company', 'Brand'), ['class' => ' optional-field'])  ?-->

    <!--?= $form->field($model['product'], 'category_id')
      ->dropDownList($category, ['prompt' => \Yii::t('erp.company', 'Select Category...'), 'options' => ['value' => 'none', 'class' =>'prompt']])
      ->label(\Yii::t('erp.company', 'Category'), ['class' => ' optional-field'])  ?-->

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('erp.company', $model['product']->isNewRecord? 'Crear' : 'Actualizar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
