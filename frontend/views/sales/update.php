<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Sales */

$this->title = Yii::t('eventplanner.company', 'Update Sales: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('eventplanner.company', 'Sales'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('eventplanner.company', 'Update');
?>
<div class="sales-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
