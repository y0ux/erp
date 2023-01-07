<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use common\models\CashierRecord;

//use yii\grid\GridView;
//use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = \Yii::t('erp.cashbox','Closure');
$this->title =  \Yii::t('erp.sys','Cashier');
$this->params['breadcrumbs'][] = $this->title;

$template_hor_input = '<div class="row">{label} <div class="col-sm-8">{input}{error}{hint}</div></div>';
$template_cash_input = '<div class="row">{label} <div class="col">{input}{error}{hint}</div></div>';
?>
<div class="cashbox-index">
  <div class="container-fluid">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="product-form">

        <pre>
            <?php //print_r($cashier_record) ?>
        </pre>

        <?php $form = ActiveForm::begin(); ?>

        <h3>Informacion</h3>
        <div class="form-row">
          <div class="form-group col-md">
            Realizado por <h3><span class='badge badge-primary'> <?= \Yii::$app->user->identity->getFullName() ?></span></h3>
          </div>
          <div class="form-group col-md">
            <?= $form->field($model, 'record_type', ['inputOptions' => ['id' => 'record_type', 'class' => 'test-me']])
                ->inline()
                ->radioList(CashierRecord::getRecordTypes())//, ['class' => 'form-check form-check-inline'])
                ->label(\Yii::t('erp.sys', 'Record Type'), ['class' => ' required'])
            ?>
          </div>
        </div>

        <section id="form-income-section" class="collapse-section collapse">
          <h3>Ingresos</h3>
          <div class="row">
            <div class="col-md">
              <div class="">
                <?= $form->field($model, 'cash_gtq', ['template' => $template_hor_input, 'inputOptions' => ['readonly' => true]])
                    ->label(\Yii::t('erp.sys', 'Quetzales (Q)'), ['class' => 'col-sm-4 col-form-label'])
                ?>
                <!--label for="cash-q" class="col-sm-4 col-form-label">Quetzales (Q) </label>
                <div class="col-sm-8">
                  <input name="cash-q" type="number" step="0.01" min="0" placeholder="Suma total" class="form-control form-control-sm">
                </div-->
              </div>
            </div>
            <div class="col-md">
              <div class="">
                <?= $form->field($model, 'cash_usd', ['template' => $template_hor_input, 'inputOptions' => ['readonly' => true]])
                    ->label(\Yii::t('erp.sys', 'Dolares ($)'), ['class' => 'col-sm-4 col-form-label'])
                ?>
                <!--label for="cash-d" class="col-sm-4 col-form-label">Dolares ($) </label>
                <div class="col-sm-8">
                  <input name="cash-d" type="number" step="0.01" min="0" placeholder="Suma total" class="form-control form-control-sm">
                </div-->
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="">
                <?= $form->field($model, 'card', ['template' => $template_hor_input, 'inputOptions' => []])
                    ->label(\Yii::t('erp.sys', 'Tarjetas'), ['class' => 'col-sm-4 col-form-label'])
                ?>
                <!--label for="card" class="col-sm-4 col-form-label">Tarjeta </label>
                <div class="col-sm-8">
                  <input name="card" type="number" step="0.01" min="0" placeholder="Suma total" class="form-control form-control-sm">
                </div-->
              </div>
            </div>
            <div class="col-md">
              <div class="">
                <?= $form->field($model, 'transfer', ['template' => $template_hor_input, 'inputOptions' => []])
                    ->label(\Yii::t('erp.sys', 'Tranferencias'), ['class' => 'col-sm-4 col-form-label'])
                ?>
                <!--label for="transfer" class="col-sm-4 col-form-label">Transferencias </label>
                <div class="col-sm-8">
                  <input name="transfer" type="number" step="0.01" min="0" placeholder="Suma total" class="form-control form-control-sm">
                </div-->
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="">
                <?= $form->field($model, 'gift_card', ['template' => $template_hor_input, 'inputOptions' => []])
                    ->label(\Yii::t('erp.sys', 'Gift Card'), ['class' => 'col-sm-4 col-form-label'])
                ?>
              </div>
            </div>
            <div class="col-md">
              <div class="">
                <?= $form->field($model, 'other', ['template' => $template_hor_input, 'inputOptions' => []])
                    ->label(\Yii::t('erp.sys', 'Other'), ['class' => 'col-sm-4 col-form-label'])
                ?>
                <!--label for="transfer" class="col-sm-4 col-form-label">Transferencias </label>
                <div class="col-sm-8">
                  <input name="transfer" type="number" step="0.01" min="0" placeholder="Suma total" class="form-control form-control-sm">
                </div-->
              </div>
            </div>
          </div>
          <h3>Salidas</h3>
          <div class="row">
          <div class="col-md-6">
            <div class="">
              <?= $form->field($model, 'spent', ['template' => $template_hor_input, 'inputOptions' => []])
                  ->label(\Yii::t('erp.sys', 'Gastos'), ['class' => 'col-sm-4 col-form-label'])
              ?>
              <!--label for="spent" class="col-sm-4 col-form-label">Gastos </label>
              <div class="col-sm-8">
                <input name="spent" type="number" step="0.01" min="0" placeholder="Suma total" class="form-control form-control-sm">
              </div-->
            </div>
          </div>
        </div>
        </section>

        <section id="form-cash-section" class="collapse-section collapse">
          <h3>Efectivo  <small class="badge badge-info"><sup>Q</sup><span id="initial-cash" data-value="<?= $model->base_cashbox ?>"><?= number_format($model->base_cashbox) ?></span></small> - <small class="badge badge-secondary"><sup>Q</sup><span id="total-cash">0</span></small> = <small class="badge"><sup>Q</sup><span id="difference-cash">0</span></small></h3>

          <h4>Quetzales <small class="badge badge-dark"><sup>Q</sup><span id="currency-total-q">0</span></small></h4>
          <div class="row">
            <div class="col-md">
              <div class="row">
                <div class="col-8">
                  <?= $form->field($model, 'q200', ['template' => $template_cash_input, 'inputOptions' => ['placeholder' => 'Cantidad', 'class' => 'form-control cash-needs-total']])
                      ->label(\Yii::t('erp.sys', 'Q200'), ['class' => 'col-3 col-form-label'])
                  ?>
                  <!-- label for="q200" class="col-3 col-form-label">Q200 </label>
                  <div class="col">
                    <input name="q200" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
                  </div-->

                </div>
                <div class="col-4">
                   = <strong name="total-q200" class="currency-quetzal" data-value="200" data-exchangerate="1">0</strong>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <?= $form->field($model, 'q100', ['template' => $template_cash_input, 'inputOptions' => ['placeholder' => 'Cantidad', 'class' => 'form-control cash-needs-total']])
                      ->label(\Yii::t('erp.sys', 'Q100'), ['class' => 'col-3 col-form-label'])
                  ?>
                </div>
                <!--label for="q100" class="col-3 col-form-label">Q100 </label>
                <div class="col">
                  <input name="q100" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
                </div-->
                <div class="col-4">
                  = <strong name="total-q100" class="currency-quetzal" data-value="100" data-exchangerate="1">0</strong>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <?= $form->field($model, 'q50', ['template' => $template_cash_input, 'inputOptions' => ['placeholder' => 'Cantidad', 'class' => 'form-control cash-needs-total']])
                      ->label(\Yii::t('erp.sys', 'Q50'), ['class' => 'col-3 col-form-label'])
                  ?>
                </div>
                <!--label for="q50" class="col-3 col-form-label">Q50 </label>
                <div class="col">
                  <input name="q50" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
                </div-->
                <div class="col-4">
                  = <strong name="total-q50" class="currency-quetzal" data-value="50" data-exchangerate="1">0</strong>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <?= $form->field($model, 'q20', ['template' => $template_cash_input, 'inputOptions' => ['placeholder' => 'Cantidad', 'class' => 'form-control cash-needs-total']])
                      ->label(\Yii::t('erp.sys', 'Q20'), ['class' => 'col-3 col-form-label'])
                  ?>
                </div>
                <!--label for="q20" class="col-3 col-form-label">Q20 </label>
                <div class="col">
                  <input name="q20" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
                </div-->
                <div class="col-4">
                  = <strong name="total-q20" class="currency-quetzal" data-value="20" data-exchangerate="1">0</strong>
                </div>
              </div>
            </div>
            <div class="col-md">
              <div class="row">
                <div class="col-8">
                  <?= $form->field($model, 'q10', ['template' => $template_cash_input, 'inputOptions' => ['placeholder' => 'Cantidad', 'class' => 'form-control cash-needs-total']])
                      ->label(\Yii::t('erp.sys', 'Q10'), ['class' => 'col-3 col-form-label'])
                  ?>
                </div>
                <!--label for="q10" class="col-3 col-form-label">Q10 </label>
                <div class="col">
                  <input name="q10" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
                </div-->
                <div class="col-4">
                  = <strong name="total-q10" class="currency-quetzal" data-value="10" data-exchangerate="1">0</strong>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <?= $form->field($model, 'q5', ['template' => $template_cash_input, 'inputOptions' => ['placeholder' => 'Cantidad', 'class' => 'form-control cash-needs-total']])
                      ->label(\Yii::t('erp.sys', 'Q5'), ['class' => 'col-3 col-form-label'])
                  ?>
                </div>
                <!--label for="q5" class="col-3 col-form-label">Q5 </label>
                <div class="col">
                  <input name="q5" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
                </div-->
                <div class="col-4">
                  = <strong name="total-q5" class="currency-quetzal" data-value="5" data-exchangerate="1">0</strong>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <?= $form->field($model, 'q1', ['template' => $template_cash_input, 'inputOptions' => ['placeholder' => 'Cantidad', 'class' => 'form-control cash-needs-total']])
                      ->label(\Yii::t('erp.sys', 'Q1'), ['class' => 'col-3 col-form-label'])
                  ?>
                </div>
                <!--label for="q1" class="col-3 col-form-label">Q1 </label>
                <div class="col">
                  <input name="q1" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
                </div-->
                <div class="col-4">
                  = <strong name="total-q1" class="currency-quetzal" data-value="1" data-exchangerate="1">0</strong>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <?= $form->field($model, 'q05', ['template' => $template_cash_input, 'inputOptions' => ['placeholder' => 'Cantidad', 'class' => 'form-control cash-needs-total']])
                      ->label(\Yii::t('erp.sys', 'Q0.50'), ['class' => 'col-3 col-form-label'])
                  ?>
                </div>
                <!--label for="q05" class="col-3 col-form-label">Q0.50 </label>
                <div class="col">
                  <input name="q05" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
                </div-->
                <div class="col-4">
                  = <strong name="total-q05" class="currency-quetzal" data-value="0.5" data-exchangerate="1">0</strong>
                </div>
              </div>
            </div>
            <div class="col-md">
              <div class="row">
                <div class="col-8">
                  <?= $form->field($model, 'q025', ['template' => $template_cash_input, 'inputOptions' => ['placeholder' => 'Cantidad', 'class' => 'form-control cash-needs-total']])
                      ->label(\Yii::t('erp.sys', 'Q0.25'), ['class' => 'col-3 col-form-label'])
                  ?>
                </div>
                <!--label for="q025" class="col-3 col-form-label">Q0.25 </label>
                <div class="col">
                  <input name="q025" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
                </div-->
                <div class="col-4">
                  = <strong name="total-q025" class="currency-quetzal" data-value=".25" data-exchangerate="1">0</strong>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <?= $form->field($model, 'q01', ['template' => $template_cash_input, 'inputOptions' => ['placeholder' => 'Cantidad', 'class' => 'form-control cash-needs-total']])
                      ->label(\Yii::t('erp.sys', 'Q0.10'), ['class' => 'col-3 col-form-label'])
                  ?>
                </div>
                <!--label for="q010" class="col-3 col-form-label">Q0.10 </label>
                <div class="col">
                  <input name="q010" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
                </div-->
                <div class="col-4">
                  = <strong name="total-q01" class="currency-quetzal" data-value=".1" data-exchangerate="1">0</strong>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <?= $form->field($model, 'q005', ['template' => $template_cash_input, 'inputOptions' => ['placeholder' => 'Cantidad', 'class' => 'form-control cash-needs-total']])
                      ->label(\Yii::t('erp.sys', 'Q0.05'), ['class' => 'col-3 col-form-label'])
                  ?>
                </div>
                <!--label for="q005" class="col-3 col-form-label">Q0.05 </label>
                <div class="col">
                  <input name="q005" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
                </div-->
                <div class="col-4">
                  = <strong name="total-q005" class="currency-quetzal" data-value=".05" data-exchangerate="1">0</strong>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <?= $form->field($model, 'q001', ['template' => $template_cash_input, 'inputOptions' => ['placeholder' => 'Cantidad', 'class' => 'form-control cash-needs-total']])
                      ->label(\Yii::t('erp.sys', 'Q0.01'), ['class' => 'col-3 col-form-label'])
                  ?>
                </div>
                <!--label for="q001" class="col-3 col-form-label">Q0.01 </label>
                <div class="col">
                  <input name="q001" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
                </div-->
                <div class="col-4">
                  = <strong name="total-q001" class="currency-quetzal" data-value=".01" data-exchangerate="1">0</strong>
                </div>
              </div>
            </div>
          </div>

          <h4>Dolares <small class="text-muted">(<sup>$</sup>1 = <sup>Q</sup>7)</small> <small class="badge badge-secondary"><sup>$</sup><span id="currency-total-usdollar">0</span></small> = <small class="badge badge-dark"><sup>Q</sup><span id="currency-total-dq">0</span></small> </h4>
          <div class="row">
          <div class="col-md">
            <div class="row">
              <div class="col-8">
                <?= $form->field($model, 'd100', ['template' => $template_cash_input, 'inputOptions' => ['placeholder' => 'Cantidad', 'class' => 'form-control cash-needs-total']])
                    ->label(\Yii::t('erp.sys', '$100'), ['class' => 'col-3 col-form-label'])
                ?>
              </div>
              <!--label for="d100" class="col-3 col-form-label">$100 </label>
              <div class="col">
                <input name="d100" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
              </div-->
              <div class="col-4">
                = <strong name="total-d100" class="currency-usdollar" data-value="100" data-exchangerate="7">0</strong>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <?= $form->field($model, 'd50', ['template' => $template_cash_input, 'inputOptions' => ['placeholder' => 'Cantidad', 'class' => 'form-control cash-needs-total']])
                    ->label(\Yii::t('erp.sys', '$50'), ['class' => 'col-3 col-form-label'])
                ?>
              </div>
              <!--label for="d50" class="col-3 col-form-label">$50 </label>
              <div class="col">
                <input name="d50" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
              </div-->
              <div class="col-4">
                = <strong name="total-d50" class="currency-usdollar" data-value="50" data-exchangerate="7">0</strong>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <?= $form->field($model, 'd20', ['template' => $template_cash_input, 'inputOptions' => ['placeholder' => 'Cantidad', 'class' => 'form-control cash-needs-total']])
                    ->label(\Yii::t('erp.sys', '$20'), ['class' => 'col-3 col-form-label'])
                ?>
              </div>
              <!--label for="d20" class="col-3 col-form-label">$20 </label>
              <div class="col">
                <input name="d20" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
              </div-->
              <div class="col-4">
                = <strong name="total-d20" class="currency-usdollar" data-value="20" data-exchangerate="7">0</strong>
              </div>
            </div>
          </div>
          <div class="col-md">
            <div class="row">
              <div class="col-8">
                <?= $form->field($model, 'd10', ['template' => $template_cash_input, 'inputOptions' => ['placeholder' => 'Cantidad', 'class' => 'form-control cash-needs-total']])
                    ->label(\Yii::t('erp.sys', '$10'), ['class' => 'col-3 col-form-label'])
                ?>
              </div>
              <!--label for="d10" class="col-3 col-form-label">$10 </label>
              <div class="col">
                <input name="d10" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
              </div-->
              <div class="col-4">
                = <strong name="total-d10" class="currency-usdollar" data-value="10" data-exchangerate="7">0</strong>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <?= $form->field($model, 'd5', ['template' => $template_cash_input, 'inputOptions' => ['placeholder' => 'Cantidad', 'class' => 'form-control cash-needs-total']])
                    ->label(\Yii::t('erp.sys', '$5'), ['class' => 'col-3 col-form-label'])
                ?>
              </div>
              <!--label for="d5" class="col-3 col-form-label">$5 </label>
              <div class="col">
                <input name="d5" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
              </div-->
              <div class="col-4">
                = <strong name="total-d5" class="currency-usdollar" data-value="5" data-exchangerate="7">0</strong>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-8">
                <?= $form->field($model, 'd1', ['template' => $template_cash_input, 'inputOptions' => ['placeholder' => 'Cantidad', 'class' => 'form-control cash-needs-total']])
                    ->label(\Yii::t('erp.sys', '$1'), ['class' => 'col-3 col-form-label'])
                ?>
              </div>
              <!--label for="d1" class="col-3 col-form-label">$1 </label>
              <div class="col">
                <input name="d1" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
              </div-->
              <div class="col-4">
                = <strong name="total-d1" class="currency-usdollar" data-value="1" data-exchangerate="7">0</strong>
              </div>
            </div>
          </div>
        </div>
      </section>







        <?php //$form->field($cashier_record['record_type'], 'product_type_id')->hiddenInput()->label(false) ?>

        <?php // $form->field($model['product'], 'name')->textInput(['maxlength' => true])->label(null, ['class' => 'required-field']) ?>

        <?php // $form->field($model['product'], 'name_desc')->textarea(['rows' => 6])->label(null, ['class' => ' optional-field']) ?>

        <?php // $form->field($model['product_price'], 'sku')->textInput(['maxlength' => true])->label(null, ['class' => ' optional-field']) ?>

        <?php // $form->field($model['product_price'], 'presentation')->textInput()->label(null, ['class' => 'required-field']) ?>

        <?php // $form->field($model['product_price'], 'price')->textInput()->label(null, ['class' => 'required-field']) ?>

        <!--?= $form->field($model, 'brand_id')->textInput(['maxlength' => true]) ?-->
        <?php // $form->field($model['product'], 'brand_id')
        //  ->dropDownList(Yii::$app->user->identity->brandList, ['prompt' => \Yii::t('eventplanner.company', 'Select Brand...'), 'options' => ['value' => 'none', 'class' =>'prompt']])
        //  ->label(\Yii::t('eventplanner.company', 'Brand'), ['class' => ' optional-field'])  ?>

        <?php // $form->field($model['product'], 'category_id')
        //  ->dropDownList($category, ['prompt' => \Yii::t('eventplanner.company', 'Select Category...'), 'options' => ['value' => 'none', 'class' =>'prompt']])
        //  ->label(\Yii::t('eventplanner.company', 'Category'), ['class' => ' optional-field'])  ?>

        <div class="form-group">
            <?= Html::submitButton(\Yii::t('erp.sys', 'Send'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>





  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

  <script>
    /*const scriptURL = 'https://script.google.com/macros/s/AKfycbyUdMohe81s49hdIUnD3g6nLCKm-NeoJSi176lC-A6ZEdru9r56/exec'
    const form = document.forms['submit-to-google-sheet']

    form.addEventListener('submit', e => {
      e.preventDefault();
      if (confirm("¿Enviar información?")){
        fetch(scriptURL, { method: 'POST', body: new FormData(form)})
          .then(
            response => {
              alert("Ingresado con exito");
              console.log('Success!', response);
              document.getElementById("submit-to-google-sheet").reset();
            }
          )
          .catch(
            error => {
              alert("hubo un error");
              console.error('Error!', error.message);
            }
          );
        }
    })*/

    /*$( ".cash-needs-total" ).change(function() {
      alert( "Handler for .change() called." );
    });*/

    window.onload = function() {
        $( ".cash-needs-total" ).each(function () {
            var input_value = $(this).val();
            console.log("input value: "+input_value);
            if (/^\d+$/.test(input_value)) {// .match(/^\d$/i) )
              updateNoteTotal($(this),input_value);
            }
        });
        $("#cashboxform-record_type input:radio:checked").each(function() {
            var radio_value = $(this).val();
            console.log("radio value: "+radio_value);
            updateCollapse (radio_value);
        });
    }

    $( ".cash-needs-total" )
      .change(function () {
          var input_value = $(this).val();
          console.log("input value: "+input_value);
          if (/^\d+$/.test(input_value)) {// .match(/^\d$/i) )
            updateNoteTotal($(this),input_value);
          }
          else {
            updateNoteTotal($(this), 0, true);
          }
      });
      //.change();

      $("#cashboxform-record_type input:radio").change(function() {
        var radio_value = $(this).val();
        console.log("radio value: "+radio_value );
        updateCollapse (radio_value);
      });

      function updateCollapse(radio_value) {
        if (radio_value == 10) {
          //if (!$("#form-cash-section").hasClass("collapse"))
            $("#form-income-section").removeClass("collapse.show").addClass("collapse");
          //if ($("#form-income-section").hasClass("collapse"))
            $("#form-cash-section").removeClass("collapse").addClass("collapse.show");
        }
        else if (radio_value == 20) {
          $(".collapse-section").each(function() {
            $(this).removeClass("collapse").addClass("collapse.show");
          });
        }
      }

      function updateNoteTotal(element, input_value, reset = false)
      {
          var name = element.attr("name");
          console.log (element);
          name = name.substring(
              name.indexOf("[") + 1,
              name.lastIndexOf("]")
          );
          var output = $( 'strong[name ="total-'+name+'"]' );
          if (reset) {
              output.text(0);
          }
          else {
              var multiplier = output.attr("data-value");
              var text_to_number = multiplier.search(/\./) < 0 ?
                  parseInt(multiplier) * parseInt(input_value) :
                  (parseFloat(multiplier) * input_value ).toFixed(2);
              output.text(text_to_number);
          }

          var totalQ = 0;
          console.log("totalQ: "+totalQ);
          $( ".currency-quetzal" ).each(function(){
            totalQ += parseFloat($(this).text());
            //console.log("totalQ: "+totalQ);
          });
          console.log("totalQ: "+totalQ);
          //$( '#total-cash-q' ).val(totalQ);
          //$( '#currency-total-q' ).text($( '#total-cash-q' ).attr("data-symbol")+totalQ);
          $( '#currency-total-q' ).text(totalQ);

          var totalD = 0;
          $( ".currency-usdollar" ).each(function(){
            console.log("totalD: "+totalD);
            totalD += parseFloat($(this).text());
          });
          $( '#total-cash-d' ).val(totalD);

          console.log($( '#total-cash-d' ));
          //$( '#currency-total-usdollar' ).text($( '#total-cash-d' ).attr("data-symbol")+totalD);
          $( '#currency-total-usdollar' ).text(totalD);

          var totalDQ = totalD * 7;//$( '#total-cash-dq' ).attr("data-exchangerate");
          $( '#total-cash-dq' ).val(totalDQ);
          //$( '#currency-total-dq' ).text($( '#total-cash-dq' ).attr("data-symbol")+totalDQ);
          $( '#currency-total-dq' ).text(totalDQ);

          var total = totalQ;// + totalDQ;

          total = parseFloat(total).toFixed(2);
          $( '#total-cashbox-q' ).val(total);
          $( '#total-cash' ).text(total);


          // CHECK WHEN OPENING VS CLOSING

          var initialCash = $( '#initial-cash' ).attr("data-value");
          var totalDifference = total - initialCash;
          $( "#difference-cash" ).text(totalDifference).parent().removeClass().addClass(function(){
            return totalDifference > 0 ? 'badge badge-success' : (totalDifference < 0? 'badge badge-danger' : 'badge badge-warning');
          });

          $('#cashboxform-cash_gtq').val(totalDifference > 0? totalDifference : 0);
          $('#cashboxform-cash_usd').val(totalD > 0? totalD : 0);

      }

  </script>
</div>
