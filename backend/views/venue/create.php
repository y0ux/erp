<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Venue */

$this->title = Yii::t('sys.company', 'Create Venue');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sys.company', 'Venues'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="venue-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
