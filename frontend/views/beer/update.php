<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Beer */

$this->title = Yii::t('eventplanner.company', 'Update Beer: {name}', [
    'name' => $model['product']->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('eventplanner.company', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model['product']->name, 'url' => ['view', 'id' => $model['beer']->id]];
$this->params['breadcrumbs'][] = Yii::t('eventplanner.company', 'Update');
?>
<div class="beer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'lists' => $lists,
    ]) ?>

</div>
