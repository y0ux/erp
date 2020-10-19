<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AdministrativeLevelArea2 */

$this->title = Yii::t('sys.erp', 'Create Administrative Level Area2');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sys.erp', 'Administrative Level Area2s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="administrative-level-area2-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
