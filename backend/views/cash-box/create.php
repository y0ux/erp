<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CashBox */

$this->title = Yii::t('sys.cashbox', 'Create Cash Box');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sys.cashbox', 'Cash Boxes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cash-box-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
