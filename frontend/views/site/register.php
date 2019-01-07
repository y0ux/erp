<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;

$this->title = 'Registro';
$this->params['breadcrumbs'][] = $this->title;
$flash_messages = Yii::$app->session->getFlash('company-create',[]);
array_merge($flash_messages,Yii::$app->session->getFlash('company-create',[]));
?>

<div class="site-register">
    <?php
      if (!empty($flash_messages)) :
        echo Alert::widget([
           'options' => ['class' => 'alert-info'],
           'body' => "<pre>".implode("<br/>", $flash_messages)."</pre>",
        ]);
      endif;
    ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to register:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <h3>Datos de la Empresa</h3>
                <?= $form->field($model['company'], 'legal_name')->textInput(['autofocus' => true])->label('Nombre Legal') ?>
                <!--?= $form->field($model, 'venue_id')->dropDownList([0 => 'Monetaria', 1 => 'Ahorro'])->label('otro') ?-->

            <h3>Datos de Conciliacion</h3>
                <?= $form->field($model['company'], 'NIT')->label('NIT') ?>
                <?= $form->field($model['company'], 'address_1')->label('Direccion') ?>
                <?= $form->field($model['company'], 'address_2')->label('Direccion (Apto, Edificio, etc)') ?>
                <div class='form-group'>
                  <label class="control-label" for="city">Ciudad</label>
                  <?= Html::input('text', 'city', null ,['class' => 'form-control']) ?>
                </div>
                <!--div class='form-group'>
                  <label class="control-label" for="country">Pais</label>
                  <!--?= Html::dropDownList('country', null ,[502 => 'Guatemala', 503 => 'El Salvador', 504 => 'Honduras', 505 => 'Nicaragua', 506 => 'Costa Rica', 52 => 'Mexico', 1 => 'USA'] ,['class' => 'form-control']) ?>
                </div-->
                <?php
                $bank_list = [
                    1 => 'Industrial',
                    2 => 'G&T Continental',
                    3 => 'Banrural',
                    4 => 'BAM',
                    5 => 'Inter',
                    6 => 'BAC',
                    7 => 'Inmobiliario',
                    8 => 'Promerica',
                    9 => 'Azteca',
                    10 => 'Bantrab'];
                 ?>

                <?= $form->field($model['bank_account'], 'bank_id')->dropDownList($bank_list)->label('Nombre del Banco') ?>
                <?= $form->field($model['bank_account'], 'beneficiary')->label('Beneficiario') ?>
                <?= $form->field($model['bank_account'], 'account_number')->label('Numero de Cuenta') ?>
                <?= $form->field($model['bank_account'], 'type')->dropDownList([0 => 'Monetaria', 1 => 'Ahorro'])->label('Tipo de Cuenta') ?>
                <h3>Marca</h3>
                <?= $form->field($model['brand'], 'name')->label('Nombre de la Marca') ?>
                <h3>Participacion</h3>
                <div class='form-group'>
                  <label class="control-label" for="first-time">Participacion</label>
                  <?= Html::radioList('first-time', null ,[1 => 'Primerizo', 2 => 'Experimentado'], ['class' => 'form-control'/*, 'aria-required' => 'true'*/]) ?>
                </div>
                <div class='form-group'>
                  <?= Html::radio('cost-compromise', false, ['class' => '']) ?>
                  <label class="control-label" for="cost-compromise">Me comprometo con el costo de participacion</label>
                </div>
                <?php
                  $stands = [
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                    6 => '6',
                    7 => '7',
                    8 => '8',
                    9 => '9',
                    10 => '10',
                    11 => '11',
                    12 => '12',
                    13 => '13',
                    14 => '14',
                    15 => '15',
                    16 => '16',
                    17 => '17',
                    18 => '18',
                    19 => '19',
                  ];
                ?>
                <div class='form-group'>
                  <label class="control-label" for="stand">Stand</label>
                  <?= Html::dropDownList('stand', null, $stands, ['class' => 'form-control', 'prompt' => 'Selecciona...', 'options' => ['value' => 'none', 'class' => 'prompt', 'label' => 'Select']]) ?>
                  <br>
                  <br>
                  <?= Html::img(Url::to('@web/images/santa-isabel-jardin-espacios-short.png'),['style' => 'max-width: 600px;']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Registrar', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>


            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
