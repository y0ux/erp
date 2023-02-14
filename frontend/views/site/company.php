<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\bootstrap4\Alert;

/* @var $this yii\web\View */
/* @var $model common\models\BusinessProfile */

$this->title = $model->legal_name;
$this->params['breadcrumbs'][] = ['label' => 'Company', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$flash_messages = Yii::$app->session->getFlash('company-create',[]);
array_merge($flash_messages,Yii::$app->session->getFlash('company-create',[]));?>
<div class="business-profile-view">

    <div>
        <h1 style="display:inline-block"><?= Html::encode($this->title) ?></h1>
        <div class="text-right" style="margin-top: 20px; float: right;">
            <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </div>

    </div>

    <?php
      /*if (!empty($flash_messages)) :
        echo Alert::widget([
           'options' => ['class' => 'alert-info'],
           'body' => "<pre>".implode("<br/>", $flash_messages)."</pre>",
        ]);
      endif;*/
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
              'label' => 'Nombre Legal',
              'attribute' => 'legal_name'
            ],
            /*[
              'label' => \Yii::t('eventplanner.company', 'Company Type'),
              'attribute' => 'company_type_id',
              'value' => function ($data) {
                return \Yii::t('eventplanner.company', $data->company_types[$data->company_type_id]);
              }
            ],*/
            'nit',
            /*[
              'label' => 'Direccion',
              'value' => function ($data) {
                  $details = empty($data->details)? null : json_decode($data->details);
                  $city =  !empty($details) && property_exists($details, 'city')?  $details->city : '' ;
                  return $data->address_1.' '.$data->address_2.', '.$city;
              }
            ],*/
            /*[
              'label' => 'Banco',
              'value' => function ($data) {
                return !empty($data->firstBankAccount)? $data->firstBankAccount->bank->name : null;
              },
            ],*/
            [
              'label' => 'Beneficiario',
              //'attribute' => 'accepted_currency_id',
              'value' => function ($data) {
                return empty($data->firstBankAccount)? null : $data->firstBankAccount->beneficiary;
              }
            ],
            [
              'label' => 'Numero de Cuenta',
              //'attribute' => 'accepted_currency_id',
              'value' => function ($data) {
                return empty($data->firstBankAccount)? null : $data->firstBankAccount->account_number;
              }
            ],
            [
              'label' => 'Tipo de Cuenta',
              //'attribute' => 'accepted_currency_id',
              'value' => function ($data) {
                return empty($data->firstBankAccount)? null : ($data->firstBankAccount->type? 'Ahorro' : 'Monetaria');
              }
            ],
            /*[
              'label' => 'Stand',
              'attribute' => 'stand'
            ],*/
            [
              'label' => 'Primera vez?',
              'value' => function ($data) {
                if (!empty($data->details)) {
                  $details = json_decode($data->details);
                  return isset($details->firstTime)? ($details->firstTime? 'Si' : 'No') : null;
                }
                return null;
              }
            ],
            [
              'label' => 'Compromiso',
              'value' => function ($data) {
                if (!empty($data->details)) {
                  $details = json_decode($data->details);
                  return empty($details->costCompromise)? null : ($details->costCompromise? 'Aceptado' : 'Rechazado');
                }
                return null;
              }
            ],
            //'updated_at',
        ],
        'options' => ['class' => 'table table-striped']
    ]) ?>

</div>
