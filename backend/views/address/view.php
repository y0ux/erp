<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Address */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('sys.erp', 'Addresses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="address-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('sys.erp', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('sys.erp', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('sys.erp', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'address_line_1',
            'address_line_2',
            'locality_id',
            'administritative_level_area_2',
            'administritative_level_area_1',
            'country_id',
            'latitude',
            'longitude',
            'details:ntext',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
