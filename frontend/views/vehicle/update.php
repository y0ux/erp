<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Vehicle */

$this->title = Yii::t('eventplanner.company', 'Update Vehicle: {name}', [
    'name' => $model->vehicle_brand,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('eventplanner.company', 'Vehicles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->vehicle_brand, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('eventplanner.company', 'Update');
?>
<div class="vehicle-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
