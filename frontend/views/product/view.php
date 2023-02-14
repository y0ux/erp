<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('erp.company','Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(\Yii::t('erp.company','Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(\Yii::t('erp.company','Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'sku',
            /*[
              'attribute' => 'sku',
              'value' => function ($data) {
                if (empty($data->sku))
                  return null;
                return $data->sku;
              }
            ],*/
            'name',
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
              'label' => \Yii::t('erp.company','Brand'),
              'value' => function ($data) {
                if (!empty($data->brand))
                  return Html::a(
                    $data->brand->name,
                    Url::toRoute(['brand/view','id'=>$data->brand->id]),
                    ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                  );
                return null;
              },
              'format' => ['raw']
            ],*/
            //'product_type_id',
            //'category_id',
            /*[
              'attribute' => 'category_id',
              'label' => \Yii::t('erp.company','Category'),
              'value' => function ($data) {
                if (!empty($data->category))
                  return Html::a(
                    $data->category->name,
                    Url::toRoute(['category/view','id'=>$data->category->id]),
                    ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                  );
                return null;
              },
              'format' => ['raw']
            ],*/
            //'created_at',
            //'updated_at',
        ],
        'options' => ['class' => 'table table-striped']
    ]) ?>

    <h3>Precios</h3>
    <p>
    <?php //= Html::a(\Yii::t('erp.company','Add Price'), ['/product-price/create', 'product_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //'sku',
            //'presentation',
            [
              'attribute' => 'presentation',
              'value' => function ($data) {
                return Html::a(
                  $data->presentation,
                  Url::toRoute((['/product-price/view','id'=>$data->id])), ['data' => ['pjax' => '0'], 'class' => 'item-update']
                );
              },
              'format' => ['raw']
            ],
            'price',
            ///'id',
            //'name',
            /*[
              'attribute' => 'sku',
              'value' => function ($data) {
                return Html::a(
                  $data->name,
                  Url::toRoute(['product/view','id'=>$data->id]),
                  ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                );
              },
              'format' => ['raw']
            ],
            //'name_desc:ntext',
            [
              'attribute' => 'name_desc',
              'value' => function ($data) {
                if (empty($data->name_desc))
                  return null;
                return $data->name_desc;
              }
            ],
            //'details:ntext',
            //'brand_id',
            [
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
            ],
            //'product_type_id',
            //'category_id',
            //'created_at',
            //'updated_at',


            //['class' => 'yii\grid\ActionColumn'],*/
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'update' => false,
                    'view' => false,
                    'delete' => false,
                ]
            ],
        ],
        'tableOptions' => ['class' => 'table table-striped']
    ]); ?>


</div>
