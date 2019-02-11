<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('eventplanner.company', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(\Yii::t('eventplanner.company', 'Create Category'), ['create'], ['class' => 'btn btn-success']) ?>
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
                  Url::toRoute(['category/view','id'=>$data->id]),
                  ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                );
              },
              'format' => ['raw']
            ],
            //':ntext',
            [
              'attribute' => 'description',
              'value' => function ($data) {
                if (empty($data->description))
                  return null;
                return $data->description;
              }
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
