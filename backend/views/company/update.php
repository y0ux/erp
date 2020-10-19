<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Company */

$this->title = Yii::t('sys.company', 'Update Company: {name}', [
    'name' => $model->legal_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('sys.company', 'Companies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->legal_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('sys.company', 'Update');
?>
<div class="company-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
