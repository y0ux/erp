<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('erp.company', 'Staff');
$this->params['breadcrumbs'][] = $this->title;

$event_limits = Yii::$app->user->identity->company->companyLimits;
$staff = Yii::$app->user->identity->company->staff;
?>
<div class="staff-index">

    <div>
      <h1 style="display: inline-block; margin: 0; margin-right: 20px;"><?= Html::encode($this->title) ?></h1>
      <?php if (count($staff) < $event_limits['staff'] ) : ?>
        <?= Html::a(Yii::t('erp.company', 'Create Staff'), ['create'], ['class' => 'btn btn-success', 'style' => 'vertical-align: top;']) ?>
      <?php endif; ?>
    </div>
    <?php if (count($staff) < $event_limits['staff'] ) : ?>

      <div class="alert alert-primary pt-2 pb-2" role="alert">
        <?= 'Dispones de <b>'.($event_limits['staff'] - count($staff)). '</b> espacio(s) para ingresar de <b>'.$event_limits['staff']."</b> permitidas." ?>
      </div>

    <?php elseif (count($staff) == $event_limits['staff']) : ?>
      <div class="alert alert-warning pt-2 pb-2" role="alert">
        <?= 'Has llegado a tu limite de personal a ingresar. Si deseas ingresar a alguien mas, debes borrar a alguien.' ?>
      </div>
    <?php else : ?>
      <div class="alert alert-danger pt-2 pb-2" role="alert">
        <b><?= 'Has excedido el limite de personal que puedes ingresar. Las ultimas <span style="font-size: 1.5em;">'.(count($staff) - $event_limits['staff']).'</span> personas de esta lista NO podran ingresar.' ?></b>
      </div>
    <?php endif; ?>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
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
                switch($data->gender) {
                  case 1:
                    return Yii::t('erp.company', 'Male');
                  case 2:
                    return  Yii::t('erp.company', 'Female');
                  default:
                }
                return Yii::t('erp.company', 'Other');
              },
              'format' => ['raw']
            ],
            //'document_type',
            [
              'attribute' => 'document_type',
              'value' => function ($data) {
                switch($data->document_type) {
                  case 1:
                    return Yii::t('erp.company', 'DPI o DNI');
                    break;
                  case 2:
                    return Yii::t('erp.company', 'Passport');
                    break;
                  case 3:
                    return Yii::t('erp.company', 'Licenses');
                    break;
                  case 4:
                    return Yii::t('erp.company', 'Other');
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
