<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Sales */

$this->title = Yii::t('eventplanner.company', 'Create Sales');
$this->params['breadcrumbs'][] = ['label' => Yii::t('eventplanner.company', 'Sales'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
