<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

define("CBOX_NEW", 1);
define("CBOX_OPEN", 2);
define("CBOX_CLOSE", 3);
define("CBOX_UNDEFINED", 0);

$statusTheme = [
  CBOX_NEW => [
    'color' => "primary",
    'text' => \Yii::t('erp.sys','Nueva'),
    'next' => CBOX_OPEN
  ],
  CBOX_OPEN => [
    'color' => "success",
    'text' => \Yii::t('erp.sys','Abierta'),
    'verb' => \Yii::t('erp.sys','Abrir Caja'),
    'next' => CBOX_CLOSE
  ],
  CBOX_CLOSE => [
    'color' => "danger",
    'text' => \Yii::t('erp.sys','Cerrada'),
    'verb' => \Yii::t('erp.sys','Cerrar Caja'),
  ],
  CBOX_UNDEFINED => [
    'color' => "warning",
    'text' => \Yii::t('erp.sys','Problema')
  ],
];

$this->title = \Yii::t('erp.sys','Chermol - ERP');
$close_list = \common\models\CashierRecord::getCurrentClosing();
$is_close = count($close_list) > 0;
$open_list = \common\models\CashierRecord::getCurrentOpening();
$is_open = count($open_list) > 0;

$boxStatus = !$is_close && !$is_open ? CBOX_NEW : (!$is_close && $is_open ? CBOX_OPEN : ($is_close && $is_open ? CBOX_CLOSE : CBOX_UNDEFINED ) );
?>
<?php
  if (!empty($flash_messages)) :
    echo Alert::widget([
       'options' => ['class' => 'alert-info'],
       'body' => "<pre>".implode("<br/>", $flash_messages)."</pre>",
    ]);
  endif;
?>
<style>
  .sale-item {
    padding: 10px 0;
    border-top: 1px solid #ccc;
  }

</style>
<div class="site-index">

    <div class="text-center">
        <h1 class="lead">Chermol, S.A.<br><small>Sistema de ERP</small></h1>
        <p>Hola <?= Yii::$app->user->identity->userProfile? Yii::$app->user->identity->userProfile->first_name : Yii::$app->user->identity->username ?>!</p>
    </div>

    <div class=row>
      <div class="col-lg-6 col-md-6">
        <h3><i class="fas fa-cash-register"></i> Caja Chica <span class="badge badge-<?= $statusTheme[$boxStatus]['color'] ?>"><?= $statusTheme[$boxStatus]['text'] ?></span></h3>
        <div class="row" style="padding-top: 20px; padding-bottom: 20px;">
          <div class="col-6">
            <?php
            echo date('Y-m-d H:i');
            echo '<br>';
            echo date_default_timezone_get();
            ?>
          </div>
          <div class="col-6">
            <?php
            if (isset($statusTheme[$boxStatus]['next'])) {
              $nextStep = $statusTheme[$boxStatus]['next'];
              ?>
                <?= Html::a($statusTheme[$nextStep]['verb']." ".Html::tag("span", "", ["class" => "fas fa-chevron-right"]), Url::to(['/cashbox/index']), ["class" => "btn btn-".$statusTheme[$nextStep]['color']]) ?>
              <?php
            }
            ?>
          </div>
        </div>
        <?php
        if (count($open_list) > 0 || count($close_list) > 0) :
          ?>
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
              $cashier_arrays = array_merge($is_close? $close_list : [], $is_open? $open_list : []);
              foreach ($cashier_arrays as $i => $record) {
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
        endif;
        ?>
      </div>
      <div class="col-lg-6 col-md-6">
        <h3><i class="fas fa-tablet-alt"></i> Sistema Square</h3>
        <?php
        if (!empty($result)) :
          $order_list = $result->getOrders();
          ?>
          <div>
            entries <?= count($order_list); ?>
          </div>

          <?php
          $tenderTheme = [
            'cash' => [
              'color' => 'success',
              'icon' => "fas fa-money-bill"
            ],
            'third_party_card' => [
              'color' => 'primary',
              'icon' => "fas fa-credit-card"
            ],
            'no_sale' => [
              'color' => 'light',
              'icon' => "fas fa-money-check"
            ],
            'other' => [
              'color' => 'secondary',
              'icon' => "fas fa-money-check"
            ],
            'default' => [
              'color' => 'warning',
              'icon' => "fas fa-wallet"
            ],
          ];
          $i = 0;
          foreach ($order_list as $order_item) :
              $tender_types = [];
              $tenders = $order_item->getTenders();
              foreach ($tenders as $tender) {
                $type = strtolower($tender->getType());
                if (isset($tender_types[$type]))
                  $tender_types[$type]['count']++;
                else
                  $tender_types[$type] = [
                    'count' => 1,
                    'theme' => $tenderTheme[strtolower($tender->getType())]
                  ];
              }
              ?>
          <div class="row sale-item">
            <div class="col-2">
              <?php foreach ($tender_types as $name => $details) : ?>
              <div class="">
                <span class="<?= $details["theme"]["icon"] ?>"></span> <span class="badge badge-<?= $details["theme"]["color"] ?>"><?= $details["count"] ?></span>
              </div>
              <?php endforeach; ?>
            </div>
            <div class="col-6">
              <div>
                <b><?= $order_item->getTotalMoney()->getAmount() / 100 ?></b>
              </div>
              <div>
                <?= count($order_item->getLineItems()) ?> items
              </div>
            </div>
            <div class="col-4">
              <?= date("g:i a" ,strtotime($order_item->getClosedAt())) ?>
              <a href="#"><span class="fas fa-chevron-right"></span></a>
            </div>
          </div>
          <?php
          $i++;
          //if ($i > 3)
          //break;
          endforeach; ?>


          <!--table class="table">
            <thead>
              <tr>
                <th scope="col">Tipo</th>
                <!- - th scope="col">Creada</th>
                <th scope="col">Actualizada</th - ->
                <th scope="col">Cerrada</th>
                <th scope="col">Estado</th>
                <th scope="col">Tax</th>
                <th scope="col">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php
              /*$i = 0;
              foreach ($order_list as $order_item) :
                $tender_types = [];
                $tenders = $order_item->getTenders();
                foreach ($tenders as $tender) {
                  if (isset($tender_types[$tender->getType()]))
                    $tender_types[$tender->getType()]++;
                  else
                    $tender_types[$tender->getType()] = 1;
                }
                ?>
                <tr>
                  <!- -td><?php // $order_item->getId() ?></td-->
                  <!--td><?php // $order_item->getCreatedAt() ?></td>
                  <td><?php // $order_item->getUpdatedAt() ?></td- ->
                  <td><?= json_encode($tender_types) ?></td>
                  <td><?= $order_item->getClosedAt() ?></td>
                  <td><?= $order_item->getState() ?></td>
                  <td><?= $order_item->getTotalTaxMoney()->getAmount() / 100 ?></td>
                  <td><?= $order_item->getTotalMoney()->getAmount() / 100 ?></td>
                </tr>
              <?php
              $i++;
              if ($i > 3)
              break;
            endforeach; */?>
            </tbody>
          </table-->

          <pre>
          <?php
          /*$j = 0;
          foreach ($order_list as $order_item) :

            echo "<br>Tenders:<br>";
            print_r($order_item->getTenders());
            echo "<br>Metadata:<br>";
            print_r($order_item->getMetadata());
            echo "<br>Discounts<br>";
            print_r($order_item->getDiscounts());
            echo "<br>Fulfillments:<br>";
            print_r($order_item->getFulfillments());



            echo "\n Other:";
            echo "<br>";
            print_r(get_object_vars($order_item));
            if($j++ > 3)
              break;
          endforeach;*/
          ?>

          </pre>
          <pre>
            <?php //print_r($order_list) ?>
          </pre>
        <?php endif; ?>
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
