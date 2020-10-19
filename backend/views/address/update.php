<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Address */

$this->title = Yii::t('sys.erp', 'Update Address: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('sys.erp', 'Addresses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('sys.erp', 'Update');
?>
<div class="address-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
