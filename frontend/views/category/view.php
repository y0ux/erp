<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('erp.company', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(\Yii::t('erp.company', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(\Yii::t('erp.company', 'Delete'), ['delete', 'id' => $model->id], [
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
            //'description:ntext',
            [
              'attribute' => 'description',
              'value' => function ($data) {
                if (empty($data->description))
                  return null;
                return $data->description;
              }
            ],
            //'details:ntext',
            //'created_at',
            //'updated_at',
        ],
        'options' => ['class' => 'table table-striped']
    ]) ?>

</div>
