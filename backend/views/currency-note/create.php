<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CurrencyNote */

$this->title = Yii::t('sys.erp', 'Create Currency Note');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sys.erp', 'Currency Notes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currency-note-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
