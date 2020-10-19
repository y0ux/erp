<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sys.company', 'Venues');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="venue-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('sys.company', 'Create Venue'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'company_id',
            [
              'attribute' => 'legal_name',
              'value' => function ($data) {
                return Html::a(
                  $data->legal_name,
                  Url::toRoute(['venue/view','id'=>$data->id]),
                  ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                );
              },
              'format' => ['raw']
            ],
            //'short_name',
            [
              'attribute' => 'company_id',
              'value' => function ($data) {
                return Html::a(
                  $data->company->legal_name,
                  Url::toRoute(['company/view','id'=>$data->company_id]),
                  ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                );
              },
              'format' => ['raw']
            ],

            //'legal_name',
            //'address_id',
            //'details:ntext',
            //'created_at',
            //'updated_at',
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
