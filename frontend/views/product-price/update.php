<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductPrice */

$this->title = Yii::t('eventplanner.company', 'Update {product} Price: {name}', [
    'product' => $model->product->name,
    'name' => $model->presentation,
]);
//$this->params['breadcrumbs'][] = ['label' => Yii::t('eventplanner.company', 'Product Prices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => \Yii::t('eventplanner.company','Products'), 'url' => ['/product/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('eventplanner.company', $model->product->name), 'url' => ['/product/view', 'id' => $model->product->id]];
$this->params['breadcrumbs'][] = ['label' => $model->presentation, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('eventplanner.company', 'Update');
?>
<div class="product-price-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
