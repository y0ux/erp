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
?>
<div class="vehicle-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('eventplanner.company', 'Create Vehicle'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
