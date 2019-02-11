<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Brand */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('eventplanner.company', 'Brands'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="brand-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(\Yii::t('eventplanner.company', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(\Yii::t('eventplanner.company', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            //'stand_number',
            //'negotiation_type',
            //'stand_size',
            //'status',
            //'amount',
            //'company_id',
            [
              'attribute' => 'company_id',
              'label' => \Yii::t('eventplanner.company', 'Company'),
              'value' => function ($data) {
                return Html::a(
                  $data->company->legal_name,
                  Url::toRoute(['site/view','id'=>$data->company->id]),
                  ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                );
              },
              'format' => ['raw']

            ],
            //'details:ntext',
            //'created_at',
            //'updated_at',
        ],
        'options' => ['class' => 'table table-striped']
    ]) ?>

</div>
