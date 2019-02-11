<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Vehicle */

$this->title = Yii::t('eventplanner.company', 'Create Vehicle');
$this->params['breadcrumbs'][] = ['label' => Yii::t('eventplanner.company', 'Vehicles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
