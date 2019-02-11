<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('eventplanner.company', 'Staff');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('eventplanner.company', 'Create Staff'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'company_id',
            //'name',
            [
              'attribute' => 'name',
              'value' => function ($data) {
                return Html::a(
                  $data->name,
                  Url::toRoute(['staff/view','id'=>$data->id]),
                  ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                );
              },
              'format' => ['raw']
            ],
            //'gender',
            [
              'attribute' => 'gender',
              'value' => function ($data) {
                return $data->gender == 1? Yii::t('eventplanner.company', 'Male') : Yii::t('eventplanner.company', 'Female') ;
              },
              'format' => ['raw']
            ],
            //'document_type',
            [
              'attribute' => 'document_type',
              'value' => function ($data) {
                switch($data->document_type) {
                  case 1:
                    return Yii::t('eventplanner.company', 'DPI o DNI');
                    break;
                  case 2:
                    return Yii::t('eventplanner.company', 'Passport');
                    break;
                  case 3:
                    return Yii::t('eventplanner.company', 'Licenses');
                    break;
                  case 4:
                    return Yii::t('eventplanner.company', 'Other');
                    break;
                  default:
                    return null;
                }
              }
            ],
            'document_number',
            //'created_at',
            //'updated_at',

            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'update' => false,
                    'view' => false,
                ]
            ],
        ],
        'tableOptions' => ['class' => 'table table-striped']
    ]); ?>
    <?php Pjax::end(); ?>
</div>
