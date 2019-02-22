<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\VehicleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('eventplanner.company', 'Vehicles');
$this->params['breadcrumbs'][] = $this->title;

$event_limits = Yii::$app->user->identity->company->companyLimits;
$vehicles = Yii::$app->user->identity->company->vehicles;
?>
<div class="vehicle-index">

    <div>
      <h1 style="display: inline-block; margin: 0; margin-right: 20px;"><?= Html::encode($this->title) ?></h1>
      <?php if (count($vehicles) < $event_limits['vehicles'] ) : ?>
        <?= Html::a(Yii::t('eventplanner.company', 'Create Vehicle'), ['create'], ['class' => 'btn btn-success', 'style' => 'vertical-align: top;']) ?>
      <?php endif; ?>
    </div>

    <h4><b><?= "Cantidad maxima permitida de vehiculos a ingresar: ".$event_limits['vehicles'] ?></b></h4>

    <?php if (count($vehicles) < $event_limits['vehicles'] ) : ?>
      <p class='bg-info' style="padding: 20px 10px; margin-top: 10px;">
        <?= 'Dispones de <b>'.($event_limits['vehicles'] - count($vehicles)). '</b> vehiculo(s) para poder ingresar' ?>
      </p>
    <?php elseif (count($vehicles) == $event_limits['vehicles']) : ?>
      <p class='bg-warning' style="padding: 20px 10px;">
        <b><?= 'Has llegado a tu limite de vehiculos a ingresar. Si deseas ingresar mas, debes borrar alguno.' ?></b>
      </p>
    <?php else : ?>
      <p class='bg-danger' style="padding: 20px 10px;">
        <b><?= 'Has excedido el limite de vehiculos que puedes ingresar. Los ultimos <span style="font-size: 1.5em;">'.(count($vehicles) - $event_limits['vehicles']).'</span> vehiculos de esta lista NO podran ingresar.' ?></b>
      </p>
    <?php endif; ?>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'company_id',
            //'plate_number',
            [
              'attribute' => 'plate_number',
              'value' => function ($data) {
                return Html::a(
                  $data->plate_number,
                  Url::toRoute(['vehicle/view','id'=>$data->id]),
                  ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                );
              },
              'format' => ['raw']
            ],
            'vehicle_brand',
            'vehicle_type',
            'vehicle_color',
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
    <?php Pjax::end(); ?>
</div>
