<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Beer */

$this->title = Yii::t('eventplanner.company', 'Create Beer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('eventplanner.company', 'Beers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="beer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'lists' => $lists,
    ]) ?>

</div>
