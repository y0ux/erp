<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\SignupForm */
/* @var $invitation_token string */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'User Profile';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-userprofile">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= \Yii::t('erp.sys', 'Please finish your profile by filling these fields to continue:') ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-userprofile']); ?>

                <?php //= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'first_name') ?>

                <?= $form->field($model, 'last_name') ?>

                <div class="form-group">
                    <?= Html::submitButton(\Yii::t('erp.sys', 'Send'), ['class' => 'btn btn-primary', 'name' => 'userprofile-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
