<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Staff */

$this->title = Yii::t('eventplanner.company', 'Create Staff');
$this->params['breadcrumbs'][] = ['label' => Yii::t('eventplanner.company', 'Staff'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
