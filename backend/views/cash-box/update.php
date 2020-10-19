<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CashBox */

$this->title = Yii::t('sys.cashbox', 'Update Cash Box: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('sys.cashbox', 'Cash Boxes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('sys.cashbox', 'Update');
?>
<div class="cash-box-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
