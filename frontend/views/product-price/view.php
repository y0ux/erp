<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProductPrice */

$this->title = $model->presentation;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('eventplanner.company','Products'), 'url' => ['/product/index']];
//$this->params['breadcrumbs'][] = ['label' => Yii::t('eventplanner.company', 'Product Prices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('eventplanner.company', $model->product->name), 'url' => ['/product/view', 'id' => $model->product->id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-price-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('eventplanner.company', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('eventplanner.company', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('eventplanner.company', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'product_id',
            [
              'attribute' => 'product_id',
              'label' => \Yii::t('eventplanner.company','Product'),
              'value' => function ($data) {
                if (!empty($data->product))
                  return Html::a(
                    $data->product->name,
                    Url::toRoute(['product/view','id'=>$data->product->id]),
                    ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                  );
                return null;
              },
              'format' => ['raw']
            ],
            'sku',
            //'presentation',
            'price',
            //'details:ntext',
            //'created_at',
            //'updated_at',
        ],
        'options' => ['class' => 'table table-striped']
    ]) ?>

</div>
