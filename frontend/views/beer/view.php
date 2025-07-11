<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Beer */

$this->title = $model['beer']->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('eventplanner.company', 'Cervezas'), 'url' => ['beer/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="beer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('eventplanner.company', 'Update'), ['update', 'id' => $model['beer']->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('eventplanner.company', 'Delete'), ['delete', 'id' => $model['beer']->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('eventplanner.company', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model['beer'],
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
           /* [
              'attribute' => 'name_desc',
              'value' => function ($data) {
                if (empty($data->name_desc))
                  return null;
                return $data->name_desc;
              }
            ],
            [
              'attribute' => 'brand_id',
              'label' => \Yii::t('eventplanner.company','Brand'),
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
            [ // hide_brand
              'label' => \Yii::t('eventplanner.company','Ocultar mi marca en este estilo'),
              'value' => function ($data) {
                if (!empty($data) && !empty($data->hide_brand))
                  return $data->hide_brand? "si":"no";
                return null;
              },
              'format' => ['raw']
            ],
            [
              'attribute' => 'beer_style_id',
              'value' => function ($data) {
                if (!empty($data) && !empty($data->beerStyle))
                  return $data->beerStyle->name.' - '.$data->beerStyle->number;
                return null;
              },
              'format' => ['raw']
            ],
            [
              'label' => \Yii::t('eventplanner.company','ABV %'),
              'value' => function ($data) {
                if (!empty($data) && !empty($data->abv))
                  return $data->abv.'%';
              }
            ],
            [
              'label' => \Yii::t('eventplanner.company','IBU'),
              'value' => function ($data) {
                if (!empty($data) && !empty($data->ibu))
                  return $data->ibu;
              }
            ],
            [
              'label' => \Yii::t('eventplanner.company','Color SRM'),
              'value' => function ($data) {
                if (!empty($data) && !empty($data->srmColor))
                  return $data->srmColor->color.' <spa class="color-block" style="display: inline-block; width: 30px; height: 15px; vertical-align: middel; background-color: #'.$data->srmColor->color_hex.';"></span>';
                /*Html::a(
                    $data->srmColor->color,
                    Url::toRoute(['beer/view','id' => $data->srmColor->id]),
                    ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                  );*/
                return null;
              },
              'format' => ['raw']
            ],
           /* [
              'label' => \Yii::t('eventplanner.company','Og'),
              'value' => function ($data) {
                if (!empty($data->beer) && !empty($data->beer->og))
                  return $data->beer->og;
              }
            ],
            [
              'label' => \Yii::t('eventplanner.company','Fg'),
              'value' => function ($data) {
                if (!empty($data->beer) && !empty($data->beer->fg))
                  return $data->beer->fg;
              }
            ],*/
            //'aroma',
            'details',
            [
              'label' => \Yii::t('eventplanner.company', 'Aroma'),
              'value' => function ($data) {
                  return !empty($data) && !empty($data->aroma)? $data->aroma : null;
              }
            ],
            //'flavor',
            [
              'label' => \Yii::t('eventplanner.company','Sabor'),
              'value' => function ($data) {
                  return !empty($data) && !empty($data->flavor)? $data->flavor : null;
              }
            ],
            //'details:ntext',
            //'brand_id',

            //'product_type_id',
            //'category_id',
            /*[
              'attribute' => 'category_id',
              'label' => \Yii::t('eventplanner.company','Category'),
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

    <!--h3>Precios</h3>
    <p>
    <?php //= Html::a(\Yii::t('eventplanner.company','Add Price'), ['/product-price/create', 'product_id' => $model['product']->id], ['class' => 'btn btn-success']) ?>
    </p>
    <?php /*= GridView::widget([
        'dataProvider' => $model['dataProvider'],
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'sku',
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
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'update' => false,
                    'view' => false,
                ]
            ],
        ],
        'tableOptions' => ['class' => 'table table-striped']
    ]); */?>

</div>
