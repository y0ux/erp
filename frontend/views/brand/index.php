<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('eventplanner.company','Brands');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(\Yii::t('eventplanner.company', 'Create Brand'), ['create'], ['class' => 'btn btn-success']) ?>
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
    <?php Pjax::end(); ?>
</div>
