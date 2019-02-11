<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Brand */

$this->title = \Yii::t('eventplanner.company', 'Update Brand: ') . $model->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('eventplanner.company', 'Brands'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = \Yii::t('eventplanner.company', 'Update');
?>
<div class="brand-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
