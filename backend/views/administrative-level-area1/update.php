<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AdministrativeLevelArea1 */

$this->title = Yii::t('sys.erp', 'Update Administrative Level Area1: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('sys.erp', 'Administrative Level Area1s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('sys.erp', 'Update');
?>
<div class="administrative-level-area1-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
