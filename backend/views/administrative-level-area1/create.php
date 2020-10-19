<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AdministrativeLevelArea1 */

$this->title = Yii::t('sys.erp', 'Create Administrative Level Area1');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sys.erp', 'Administrative Level Area1s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="administrative-level-area1-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
