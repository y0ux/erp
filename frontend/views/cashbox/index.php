<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = \Yii::t('erp.cashbox','Closure');
$this->title =  \Yii::t('erp.cashbox','Cajero');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-index">
  <div class="container-fluid">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::beginForm('', 'post',['name' => "submit-to-google-sheet", 'id' => 'submit-to-google-sheet'])// ['enctype' => 'multipart/form-data']) ?>

      <h3>Informacion</h3>
      <div class="form-row">
        <div class="form-group col-md">
          <!--label for="name">Nombre </label-->
          <!--select name="name" class="form-control form-control-sm" required>
            <option value="">Nombre...</option>
            <option value="Sandra Argueta">Sandra Argueta</option>
            <option value="Paco Rivera">Paco Rivera</option>
            <option value="Mauri Sul">Mauri Sul</option>
            <option value="Juan Carlor Perez">Juanka Perez</option>
            <option value="Cindy Vasquez">Cindy Vasquez</option>
            <option value="Aura Vasquez">Aury Vasquez</option>
          </select-->
          <input name="name" placeholder="Suma total" value="<?= \Yii::$app->user->identity->userProfile? \Yii::$app->user->identity->userProfile->fullName() : \Yii::$app->user->identity->username ?>" readonly="true" class="form-control form-control-sm">
        </div>
        <div class="form-group col-md">
          <!--label for="type">Tipo de Cierre </label-->
          <select name="type" class="form-control form-control-sm" required>
            <option value="">Tipo de Cierre...</option>
            <option value="Apertura">Apertura</option>
            <option value="Cierre">Cierre</option>
          </select>
        </div>
      </div>
      <h3>Ingresos</h3>
      <div class="row">
        <div class="col-md">
          <div class="form-group row">
            <label for="cash-q" class="col-sm-4 col-form-label">Quetzales (Q) </label>
            <div class="col-sm-8">
              <input name="cash-q" type="number" step="0.01" min="0" placeholder="Suma total" class="form-control form-control-sm">
            </div>
          </div>
        </div>
        <div class="col-md">
          <div class="form-group row">
            <label for="cash-d" class="col-sm-4 col-form-label">Dolares ($) </label>
            <div class="col-sm-8">
              <input name="cash-d" type="number" step="0.01" min="0" placeholder="Suma total" class="form-control form-control-sm">
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md">
          <div class="form-group row">
            <label for="card" class="col-sm-4 col-form-label">Tarjeta </label>
            <div class="col-sm-8">
              <input name="card" type="number" step="0.01" min="0" placeholder="Suma total" class="form-control form-control-sm">
            </div>
          </div>
        </div>
        <div class="col-md">
          <div class="form-group row">
            <label for="transfer" class="col-sm-4 col-form-label">Transferencias </label>
            <div class="col-sm-8">
              <input name="transfer" type="number" step="0.01" min="0" placeholder="Suma total" class="form-control form-control-sm">
            </div>
          </div>
        </div>
      </div>
      <h3>Salidas</h3>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group row">
            <label for="spent" class="col-sm-4 col-form-label">Gastos </label>
            <div class="col-sm-8">
              <input name="spent" type="number" step="0.01" min="0" placeholder="Suma total" class="form-control form-control-sm">
            </div>
          </div>
        </div>
      </div>

      <h3>Efectivo <span id="total-cash" class="badge badge-success">Q0</span></h3>

      <h4>Quetzales <small id="currency-total-q" class="badge badge-dark">Q0</small></h4>
      <div class="row">
        <div class="col-md">
          <div class="form-group row">
            <label for="q200" class="col-3 col-form-label">Q200 </label>
            <div class="col">
              <input name="q200" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
            </div>
            <div class="col-4">
               = <strong name="total-q200" class="currency-quetzal" data-value="200" data-exchangerate="1">0</strong>
            </div>
          </div>
          <div class="form-group row">
            <label for="q100" class="col-3 col-form-label">Q100 </label>
            <div class="col">
              <input name="q100" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
            </div>
            <div class="col-4">
              = <strong name="total-q100" class="currency-quetzal" data-value="100" data-exchangerate="1">0</strong>
            </div>
          </div>
          <div class="form-group row">
            <label for="q50" class="col-3 col-form-label">Q50 </label>
            <div class="col">
              <input name="q50" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
            </div>
            <div class="col-4">
              = <strong name="total-q50" class="currency-quetzal" data-value="50" data-exchangerate="1">0</strong>
            </div>
          </div>
          <div class="form-group row">
            <label for="q20" class="col-3 col-form-label">Q20 </label>
            <div class="col">
              <input name="q20" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
            </div>
            <div class="col-4">
              = <strong name="total-q20" class="currency-quetzal" data-value="20" data-exchangerate="1">0</strong>
            </div>
          </div>
        </div>
        <div class="col-md">
          <div class="form-group row">
            <label for="q10" class="col-3 col-form-label">Q10 </label>
            <div class="col">
              <input name="q10" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
            </div>
            <div class="col-4">
              = <strong name="total-q10" class="currency-quetzal" data-value="10" data-exchangerate="1">0</strong>
            </div>
          </div>
          <div class="form-group row">
            <label for="q5" class="col-3 col-form-label">Q5 </label>
            <div class="col">
              <input name="q5" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
            </div>
            <div class="col-4">
              = <strong name="total-q5" class="currency-quetzal" data-value="5" data-exchangerate="1">0</strong>
            </div>
          </div>
          <div class="form-group row">
            <label for="q1" class="col-3 col-form-label">Q1 </label>
            <div class="col">
              <input name="q1" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
            </div>
            <div class="col-4">
              = <strong name="total-q1" class="currency-quetzal" data-value="1" data-exchangerate="1">0</strong>
            </div>
          </div>
          <div class="form-group row">
            <label for="q05" class="col-3 col-form-label">Q0.50 </label>
            <div class="col">
              <input name="q05" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
            </div>
            <div class="col-4">
              = <strong name="total-q05" class="currency-quetzal" data-value="0.5" data-exchangerate="1">0</strong>
            </div>
          </div>
        </div>
        <div class="col-md">
          <div class="form-group row">
            <label for="q025" class="col-3 col-form-label">Q0.25 </label>
            <div class="col">
              <input name="q025" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
            </div>
            <div class="col-4">
              = <strong name="total-q025" class="currency-quetzal" data-value=".25" data-exchangerate="1">0</strong>
            </div>
          </div>
          <div class="form-group row">
            <label for="q010" class="col-3 col-form-label">Q0.10 </label>
            <div class="col">
              <input name="q010" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
            </div>
            <div class="col-4">
              = <strong name="total-q010" class="currency-quetzal" data-value=".1" data-exchangerate="1">0</strong>
            </div>
          </div>
          <div class="form-group row">
            <label for="q005" class="col-3 col-form-label">Q0.05 </label>
            <div class="col">
              <input name="q005" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
            </div>
            <div class="col-4">
              = <strong name="total-q005" class="currency-quetzal" data-value=".05" data-exchangerate="1">0</strong>
            </div>
          </div>
          <div class="form-group row">
            <label for="q001" class="col-3 col-form-label">Q0.01 </label>
            <div class="col">
              <input name="q001" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
            </div>
            <div class="col-4">
              = <strong name="total-q001" class="currency-quetzal" data-value=".01" data-exchangerate="1">0</strong>
            </div>
          </div>
        </div>
      </div>

      <h4>Dolares <small class="text-muted">($1 = Q7)</small> <small id="currency-total-dq" class="badge badge-dark">Q0</small> <small id="currency-total-usdollar" class="badge badge-secondary">$0</small></h4>
      <div class="row">
        <div class="col-md">
          <div class="form-group row">
            <label for="d100" class="col-3 col-form-label">$100 </label>
            <div class="col">
              <input name="d100" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
            </div>
            <div class="col-4">
              = <strong name="total-d100" class="currency-usdollar" data-value="100" data-exchangerate="7">0</strong>
            </div>
          </div>
          <div class="form-group row">
            <label for="d50" class="col-3 col-form-label">$50 </label>
            <div class="col">
              <input name="d50" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
            </div>
            <div class="col-4">
              = <strong name="total-d50" class="currency-usdollar" data-value="50" data-exchangerate="7">0</strong>
            </div>
          </div>
          <div class="form-group row">
            <label for="d20" class="col-3 col-form-label">$20 </label>
            <div class="col">
              <input name="d20" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
            </div>
            <div class="col-4">
              = <strong name="total-d20" class="currency-usdollar" data-value="20" data-exchangerate="7">0</strong>
            </div>
          </div>
        </div>
        <div class="col-md">
          <div class="form-group row">
            <label for="d10" class="col-3 col-form-label">$10 </label>
            <div class="col">
              <input name="d10" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
            </div>
            <div class="col-4">
              = <strong name="total-d10" class="currency-usdollar" data-value="10" data-exchangerate="7">0</strong>
            </div>
          </div>
          <div class="form-group row">
            <label for="d5" class="col-3 col-form-label">$5 </label>
            <div class="col">
              <input name="d5" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
            </div>
            <div class="col-4">
              = <strong name="total-d5" class="currency-usdollar" data-value="5" data-exchangerate="7">0</strong>
            </div>
          </div>
          <div class="form-group row">
            <label for="d1" class="col-3 col-form-label">$1 </label>
            <div class="col">
              <input name="d1" type="number" placeholder="Cantidad" class="form-control form-control-sm cash-needs-total">
            </div>
            <div class="col-4">
              = <strong name="total-d1" class="currency-usdollar" data-value="1" data-exchangerate="7">0</strong>
            </div>
          </div>
        </div>
      </div>

      <!--p>
        <input name="email" type="email" placeholder="Email" class="form-control form-control-sm" required>
      </p-->

      <input name="venue" type="hidden" value="Chermol">
      <input id="total-cashbox-q" name="total-cashbox-q" type="hidden" value="0">
      <input id="total-cash-q" name="total-cash-q" data-exchangerate="1" data-symbol="Q" type="hidden" value="0">
      <input id="total-cash-dq" name="total-cash-dq" data-exchangerate="7" data-symbol="Q" type="hidden" value="0">
      <input id="total-cash-d" name="total-cash-d" data-exchangerate="1" data-symbol="$" type="hidden" value="0">

      <button type="reset" class="btn btn-secondary">Borrar Todo</button>

      <?= Html::submitButton(\Yii::t('erp.cashbox','Submit'), ['class' => 'btn btn-primary']) ?>
      <!--button type="submit" class="btn btn-primary">Enviar</button-->

    <?= Html::endForm(); ?>
  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

  <script>
    const scriptURL = 'https://script.google.com/macros/s/AKfycbyUdMohe81s49hdIUnD3g6nLCKm-NeoJSi176lC-A6ZEdru9r56/exec'
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
    })

    /*$( ".cash-needs-total" ).change(function() {
      alert( "Handler for .change() called." );
    });*/

    $( ".cash-needs-total" )
      .change(function () {
        var name = $(this).attr("name");
        var output = $( 'strong[name ="total-'+name+'"]' );
        var multi = output.attr("data-value");
        output.text(
           multi.search(/\./) < 0 ?
           parseInt(multi) * parseInt($(this).val()) :
           (parseFloat(multi) * $(this).val() ).toFixed(2)
        );

        var totalQ = 0;
        $( ".currency-quetzal" ).each(function(){
          totalQ += parseFloat($(this).text());
        });
        $( '#total-cash-q' ).val(totalQ);
        $( '#currency-total-q' ).text($( '#total-cash-q' ).attr("data-symbol")+totalQ);

        var totalD = 0;
        $( ".currency-usdollar" ).each(function(){
          totalD += parseFloat($(this).text());
        });
        $( '#total-cash-d' ).val(totalD);
        $( '#currency-total-usdollar' ).text($( '#total-cash-d' ).attr("data-symbol")+totalD);

        var totalDQ = totalD * $( '#total-cash-dq' ).attr("data-exchangerate");
        $( '#total-cash-dq' ).val(totalDQ);
        $( '#currency-total-dq' ).text($( '#total-cash-dq' ).attr("data-symbol")+totalDQ);



        var total = totalQ + totalDQ;

        total = parseFloat(total).toFixed(2);
        $( '#total-cashbox-q' ).val(total);
        $( '#total-cash' ).text("Q"+total);
      });
      //.change();

  </script>















    <?php //= //Html::beginForm('', 'post',['name' => "submit-to-google-sheet"])// ['enctype' => 'multipart/form-data']) ?>

    <!--form name="submit-to-google-sheet"-->
      <!--input name="venue" type="hidden">
      <input name="email" type="email" placeholder="Email" required-->



      <!--button type="submit">Send</button-->
    <!--/form-->

    <!--script>
      const scriptURL = 'https://script.google.com/macros/s/AKfycbyUdMohe81s49hdIUnD3g6nLCKm-NeoJSi176lC-A6ZEdru9r56/exec'
      const form = document.forms['submit-to-google-sheet']

      form.addEventListener('submit', e => {
        e.preventDefault()
        fetch(scriptURL, { method: 'POST', body: new FormData(form)})
          .then(response => console.log('Success!', response))
          .catch(error => console.error('Error!', error.message))
      })
    </script-->



    <?php /* Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(\Yii::t('erp.cashbox', 'Create Brand'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'name',
            [
              'attribute' => 'name',
              'value' => function ($data) {
                return Html::a(
                  $data->name,
                  Url::toRoute(['brand/view','id'=>$data->id]),
                  ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                );
              },
              'format' => ['raw']
            ],
            //'stand_number',
            //'negotiation_type',
            //'stand_size',
            //'status',
            //'amount',
            //'company_id',
            [
              'attribute' => 'company_id',
              'label' => \Yii::t('eventplanner.company', 'Company'),
              'value' => function ($data) {
                return Html::a(
                  $data->company->legal_name,
                  Url::toRoute(['site/view','id'=>$data->company->id]),
                  ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                );
              },
              'format' => ['raw']
            ],
            //'details:ntext',
            //'created_at',
            //'updated_at',

            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'update' => false,
                    'view' => false,
                ]
            ],
        ],
        'tableOptions' => ['class' => 'table table-striped']
    ]); ?>
    <?php Pjax::end(); */ ?>
</div>
