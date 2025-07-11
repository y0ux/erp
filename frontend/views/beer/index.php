<?php

use yii\helpers\Html;
use yii\helpers\Url;
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
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            //'product_id',
            [
              'attribute' => 'beer_style_id',
              'value' => function ($data) {
                if (!empty($data) && !empty($data->beerStyle))
                  return $data->beerStyle->name.' - '.$data->beerStyle->number;
                return null;
              },
              'format' => ['raw']
            ],
            [
              'attribute' => 'srm_color_id',
              'value' => function ($data) {
                if (!empty($data) && !empty($data->srmColor))
                  return $data->srmColor->color.' <spa class="color-block" style="display: inline-block; width: 30px; height: 15px; vertical-align: middel; background-color: #'.$data->srmColor->color_hex.';"></span>';
                /*Html::a(
                    $data->srmColor->color,
                    Url::toRoute(['beer/view','id' => $data->srmColor->id]),
                    ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                  );*/
                return null;
              },
              'format' => ['raw']
            ],
            'abv',
            'ibu',
            //'srm_color_id',
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
