<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sys.erp', 'Countries');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('sys.erp', 'Create Country'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'short_name',
            'long_name',
            'short_name_en',
            'long_name_en',
            //'iso3166_1_a2',
            //'iso3166_1_a3',
            //'iso3166_1_numeric',
            //'itut_e164',
            //'cctld',
            //'currency_id',
            //'language_name',
            //'language_name_en',
            //'language_iso639',
            //'latitude',
            //'longitude',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
