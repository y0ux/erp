<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Locality */

$this->title = Yii::t('sys.erp', 'Create Locality');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sys.erp', 'Localities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="locality-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
