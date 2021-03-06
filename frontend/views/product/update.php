<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = \Yii::t('eventplanner.company','Update Product: '). $model['product']->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('eventplanner.company','Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model['product']->name, 'url' => ['view', 'id' => $model['product']->id]];
$this->params['breadcrumbs'][] = \Yii::t('eventplanner.company','Modificar');
?>
<div class="product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'category' => $category,
    ]) ?>

</div>
