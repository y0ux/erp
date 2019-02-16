<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductPrice */

$this->title = Yii::t('eventplanner.company', 'Create Price');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('eventplanner.company', 'Product Prices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => \Yii::t('eventplanner.company','Products'), 'url' => ['/product/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('eventplanner.company', $model->product->name), 'url' => ['/product/view', 'id' => $model->product->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-price-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
