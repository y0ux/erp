<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\models\CashBox;

/* @var $this yii\web\View */
/* @var $model common\models\CashBox */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('sys.cashbox', 'Cash Boxes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cash-box-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('sys.cashbox', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('sys.cashbox', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('sys.cashbox', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'name',
            [
              'attribute' => 'box_type',
              'value' => function ($data) {
                return CashBox::getCashBoxTypes()[$data->box_type];
              },
              'format' => ['raw']
            ],
            'code',
            //'venue_id',
            [
              'attribute' => 'venue_id',
              'label' => Yii::t('sys.company', 'Venue'),
              'value' => function ($data) {
                return Html::a(
                  $data->venue->legal_name,
                  Url::toRoute(['venue/view','id'=>$data->venue->id]),
                  ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                );
              },
              'format' => ['raw']
            ],
            [
              'attribute' => 'initial_amount',
              'value' => function ($data) {
                return $data->currency->symbol_utf8." ".$data->initial_amount;
              },
              'format' => ['raw']
            ],
            //'initial_amount',
            //'details:ntext',
            //'created_at',
            //'updated_at',
        ],
    ]) ?>

</div>
