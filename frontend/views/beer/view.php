<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Beer */

$this->title = $model['product']->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('eventplanner.company', 'Beers'), 'url' => ['index']];
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
        'model' => $model['product'],
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
            [
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
            ],
            [
              'label' => \Yii::t('eventplanner.company','Beer Style'),
              'value' => function ($data) {
                if (!empty($data->beer) && !empty($data->beer->beerStyle))
                  return Html::a(
                    $data->beer->beerStyle->name,
                    Url::toRoute(['beer/view','id'=>$data->beer->beerStyle->id]),
                    ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                  );
                return null;
              },
              'format' => ['raw']
            ],
            [
              'label' => \Yii::t('eventplanner.company','Abv'),
              'value' => function ($data) {
                if (!empty($data->beer) && !empty($data->beer->abv))
                  return $data->beer->abv.'%';
              }
            ],
            [
              'label' => \Yii::t('eventplanner.company','Ibu'),
              'value' => function ($data) {
                if (!empty($data->beer) && !empty($data->beer->ibu))
                  return $data->beer->ibu.'%';
              }
            ],
            [
              'label' => \Yii::t('eventplanner.company','Srm Color'),
              'value' => function ($data) {
                if (!empty($data->beer) && !empty($data->beer->srmColor))
                  return Html::a(
                    $data->beer->srmColor->color,
                    Url::toRoute(['beer/view','id' => $data->beer->srmColor->id]),
                    ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                  );
                return null;
              },
              'format' => ['raw']
            ],
            [
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
            ],
            //'aroma',
            [
              'label' => \Yii::t('eventplanner.company', 'Aroma'),
              'value' => function ($data) {
                  return !empty($data->beer) && !empty($data->beer->aroma)? $data->beer->aroma : null;
              }
            ],
            //'flavor',
            [
              'label' => \Yii::t('eventplanner.company','Flavor'),
              'value' => function ($data) {
                  return !empty($data->beer) && !empty($data->beer->flavor)? $data->beer->flavor : null;
              }
            ],
            //'details:ntext',
            //'brand_id',

            //'product_type_id',
            //'category_id',
            [
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
            ],
            //'created_at',
            //'updated_at',
        ],
        'options' => ['class' => 'table table-striped']
    ]) ?>

    <h3>Precios</h3>
    <?= GridView::widget([
        'dataProvider' => $model['dataProvider'],
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'sku',
            'presentation',
            'price',
        ],
        'tableOptions' => ['class' => 'table table-striped']
    ]); ?>

</div>
