<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use common\models\CashierRecord;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = \Yii::t('erp.cashbox','Closure');
$this->title =  \Yii::t('erp.sys','Cashier');
$this->params['breadcrumbs'][] = $this->title;

$template_hor_input = '<div class="row">{label} <div class="col-sm-8">{input}{error}{hint}</div></div>';
$template_cash_input = '<div class="row">{label} <div class="col">{input}{error}{hint}</div></div>';
$record_list = CashierRecord::getCurrentOpening();
$is_open = count($record_list) > 0;
?>
<div class="cashbox-index">
  <div class="container-fluid">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="product-form">

      <!--pre>
          <?php //print_r($cashier_record) ?>
      </pre-->

      <?php $form = ActiveForm::begin([
          'id' => 'cash-form',
          'options' => [
            'name' => 'cash-form',
            'class' => ''
          ],
      ]); ?>

      <h3>Informacion</h3>
      <div class="form-row">
        <div class="form-group col-md">
          Realizado por <h3><span class='badge badge-primary'> <?= \Yii::$app->user->identity->getFullName() ?></span></h3>
        </div>
        <div class="form-group col-md">
          Tipo de Operación
          <h3><span class="badge badge-<?= $is_open? "danger" : "success" ?>"><?= $is_open? "Cierre" : "Apertura" ?></span></h3>
          <?php
          echo $form->field($model, 'record_type')->hiddenInput(['value'=> $is_open? CashierRecord::RECORD_CLOSING : CashierRecord::RECORD_OPENING ])->label(false);
            //  $form->field($model, 'record_type', ['inputOptions' => ['id' => 'record_type', 'class' => 'test-me']])
            //->inline()
            //->radioList(CashierRecord::getRecordTypes())//, ['class' => 'form-check form-check-inline'])
            //->label(\Yii::t('erp.sys', 'Record Type'), ['class' => ' required'])
          ?>
        </div>
      </div>


      <section id="form-income-section" class="<?= $is_open ? "" : "collapse-section collapse" ?>">
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

      <!--section id="form-cash-section" class="collapse-section collapse"-->
      <section id="form-cash-section" class="">
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

      <div class="form-group">
          <?= Html::submitButton(\Yii::t('erp.sys', 'Send'), ['id' => 'cash-btn-send', 'class' => 'btn btn-success btn-lg']) ?>
      </div>

      <?php ActiveForm::end(); ?>

    </div>

  </div>

  <?php $this->registerJsFile(Yii::$app->request->baseUrl.'/js/cashform.js',['depends' => [\yii\web\JqueryAsset::className()]]); ?>
</div>
