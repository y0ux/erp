<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Venue */

$this->title = $model->legal_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('sys.company', 'Venues'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="venue-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('sys.company', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('sys.company', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('sys.company', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'company_id',
            'short_name',
            'legal_name',
            [
              'attribute' => 'company_id',
              'label' => \Yii::t('sys.company','Company'),
              'value' => function ($data) {
                if (!empty($data->company))
                  return Html::a(
                    $data->company->legal_name,
                    Url::toRoute(['company/view','id'=>$data->company->id]),
                    ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                  );
                return null;
              },
              'format' => ['raw']
            ],
            //'address_id',
            //'details:ntext',
            //'created_at',
            //'updated_at',
        ],
    ]) ?>

    <p>
        <?= Html::a(Yii::t('sys.company', '+ Address'), ['address/create', 'model' => 'venue', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('sys.company', '+ Cashbox'), ['cash-box/create', 'venue_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

</div>
