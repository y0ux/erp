<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Country */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('sys.erp', 'Countries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="country-view">

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
            'short_name',
            'long_name',
            'short_name_en',
            'long_name_en',
            'iso3166_1_a2',
            'iso3166_1_a3',
            'iso3166_1_numeric',
            'itut_e164',
            'cctld',
            'currency_id',
            'language_name',
            'language_name_en',
            'language_iso639',
            'latitude',
            'longitude',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
