<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AddressSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sys.erp', 'Addresses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="address-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('sys.erp', 'Create Address'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'address_line_1',
            'address_line_2',
            'locality_id',
            'administritative_level_area_2',
            //'administritative_level_area_1',
            //'country_id',
            //'latitude',
            //'longitude',
            //'details:ntext',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
