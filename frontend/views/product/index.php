<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('erp.company','Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php if($sellsBeer) : ?>
          <?= Html::a(\Yii::t('erp.company','create_beer_btn'), ['/beer/create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
        <?= Html::a(\Yii::t('erp.company','Create Product'), ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ///'id',
            //'name',
            [
              'attribute' => 'name',
              'value' => function ($data) {
                return Html::a(
                  $data->name,
                  Url::toRoute((
                    empty($data->beer)?
                    ['product/view','id'=>$data->id] :
                    ['/beer/view','id'=>$data->beer->id]
                  )),
                  ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                );
              },
              'format' => ['raw']
            ],
            /*[
              'label' => \Yii::t('erp.company', 'Is Beer?'),
              'value' => function ($data) {
                return empty($data->beer)? \Yii::t('erp.company', 'No') : \Yii::t('erp.company', 'Yes');

              },
              'format' => ['raw']
            ],*/
            //'name_desc:ntext',
            /*[
              'attribute' => 'name_desc',
              'value' => function ($data) {
                if (empty($data->name_desc))
                  return null;
                return $data->name_desc;
              }
            ],*/
            //'details:ntext',
            //'brand_id',
            /*[
              'attribute' => 'brand_id',
              'label' => \Yii::t('erp.company', 'Brand'),
              'value' => function ($data) {
                if (!empty($data->brand_id)) {
                  return Html::a(
                    $data->brand->name,
                    Url::toRoute(['brand/view','id'=>$data->brand->id]), ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                  );
                }
                return null;
              },
              'format' => ['raw']
            ],*/
            //'product_type_id',
            //'category_id',
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
