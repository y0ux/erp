<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Vehicle */

$this->title = $model->plate_number;
$this->params['breadcrumbs'][] = ['label' => Yii::t('eventplanner.company', 'Vehicles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="vehicle-view">

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
            //'company_id',
            'plate_number',
            'vehicle_brand',
            'vehicle_type',
            'vehicle_color',
            //'created_at',
            //'updated_at',
        ],
        'options' => ['class' => 'table table-striped']
    ]) ?>

</div>
