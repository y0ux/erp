<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Chermol - ERP';
?>
<?php
  if (!empty($flash_messages)) :
    echo Alert::widget([
       'options' => ['class' => 'alert-info'],
       'body' => "<pre>".implode("<br/>", $flash_messages)."</pre>",
    ]);
  endif;
?>
<div class="site-index">

    <div class="text-center">
        <h1 class="lead">Chermol, S.A.<br><small>Sistema de ERP</small></h1>
    </div>

    <p>Hola <?= Yii::$app->user->identity->username ?>!</p>
    <div class=row>
      <div class="col-lg-8 col-md-6">
        LADO AAAA
      </div>
      <div class="col-lg-4 col-md-6">
        LADO BBBB
      </div>
    </div>

</div>
