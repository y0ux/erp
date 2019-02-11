<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Staff */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('eventplanner.company', 'Staff'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="staff-view">

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
            'name',
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
        ],
        'options' => ['class' => 'table table-striped']
    ]) ?>

</div>
