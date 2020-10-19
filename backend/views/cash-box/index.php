<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\CashBox;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CashBoxSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sys.cashbox', 'Cash Boxes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cash-box-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('sys.cashbox', 'Create Cash Box'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

          //  'id',
            [
              'attribute' => 'name',
              'value' => function ($data) {
                return Html::a(
                  $data->name,
                  Url::toRoute(['cash-box/view','id'=>$data->id]),
                  ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                );
              },
              'format' => ['raw']
            ],
            [
              'attribute' => 'box_type',
              'value' => function ($data) {
                return CashBox::getCashBoxTypes()[$data->box_type];
              },
              'format' => ['raw']
            ],
            'code',
            [
              'attribute' => 'venue_id',
              'label' => Yii::t('sys.company', 'Venue'),
              'value' => function ($data) {
                return Html::a(
                  $data->venue->legal_name,
                  Url::toRoute(['venue/view','id'=>$data->venue->id]),
                  ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                );
              },
              'format' => ['raw']
            ],
            'initial_amount',
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
