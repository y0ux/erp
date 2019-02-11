<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\BeerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('eventplanner.company', 'Beers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="beer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('eventplanner.company', 'Create Beer'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'product_id',
            'beer_style_id',
            'abv',
            'ibu',
            //'srm_color_id',
            //'og',
            //'fg',
            //'aroma',
            //'flavor',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
