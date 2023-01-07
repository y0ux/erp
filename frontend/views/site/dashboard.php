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
        <p>Hola <?= Yii::$app->user->identity->userProfile? Yii::$app->user->identity->userProfile->first_name : Yii::$app->user->identity->username ?>!</p>
    </div>

    <div class=row>
      <div class="col-lg-6 col-md-6">
        <h3><i class="fas fa-cash-register"></i> Caja Chica</h3>
        <?php
        echo date('Y-m-d H:i');
        echo '<br>';
        echo date_default_timezone_get();
        $record_list = \common\models\CashierRecord::getCurrentOpening();
        if (count($record_list) > 0) {

          ?>
          <div class="" style="margin: 10px 0"><?= Html::a("Cerrar Caja",Url::to(['/cashbox/index']), ["class" => "btn btn-danger"]) ?></div>

          <h4>Datos Ingresados</h4>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Hora</th>
                <th scope="col">Nombre</th>
                <th scope="col">tipo</th>
                <th scope="col">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($record_list as $i => $record) {
                ?>
                <tr>
                  <td><?= date("g:i a", strtotime($record->created_at)) ?></td>
                  <td><?= $record->created_by_full_name ?></td>
                  <td><?= $record->getRecordTypeText() ?></td>
                  <td><?= Yii::$app->formatter->asDecimal($record->cashbox_total,2) ?></td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        <?php
        }
        else { ?>
          <div class="" style="margin: 10px 0"><?= Html::a("Aperturar Caja",Url::to(['/cashbox/index']), ["class" => "btn btn-success"]) ?></div>
        <?php
        }
        ?>
      </div>
      <div class="col-lg-6 col-md-6">
        LADO Baby
      </div>
    </div>

    <!--div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div-->
</div>
