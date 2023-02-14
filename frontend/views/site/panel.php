<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

/*
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
*/

$this->title = \Yii::t('erp.sys','FCA - Event System');

/*
$daydiff = round((time() - strtotime($report_date))/ (60 * 60 * 24));
$close_list = \common\models\CashierRecord::getClosingData($report_date);
$is_close = count($close_list) > 0;
$open_list = \common\models\CashierRecord::getOpeningData($report_date);
$is_open = count($open_list) > 0;

$boxStatus = !$is_close && !$is_open ? CBOX_NEW : (!$is_close && $is_open ? CBOX_OPEN : ($is_close && $is_open ? CBOX_CLOSE : CBOX_UNDEFINED ) );
*/

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
  .order-item {
    padding: 10px 0;
    border-top: 1px solid #ccc;
  }
  .order-line-items {
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
  }

</style>
<div class="site-index">

    <!--div class="text-center">
        <h1 class="">Chermol, S.A.<br><small>Sistema de ERP</small></h1>
        <p>Hola <?php // Yii::$app->user->identity->userProfile? Yii::$app->user->identity->userProfile->first_name : Yii::$app->user->identity->username ?>!</p>
    </div-->
    <?php /*
    <nav class="navbar navbar-light justify-content-between mb-4 pb-3 border-bottom">
      <div class="navbar-brand"><?= date("D, F d, Y", strtotime($report_date)) ?></div>
      <form class="form-inline" method="get" action="">
        <div class="form-group mb-2">
          <label for="date-search" class="sr-only">Fecha</label>
          <input type="date" id="date-search" name="date-search" value="<?= $report_date ?>" min="2022-12-07" max="<?= date("Y-m-d") ?>">
        </div>
        <button type="submit" class="btn btn-secondary btn-sm mb-2 ml-3">Buscar</button>
      </form>
    </nav>

    <div class=row>
      <div class="col-lg-6 col-md-6">
        <h3><i class="fas fa-cash-register"></i> Caja Chica <span class="badge badge-<?= $statusTheme[$boxStatus]['color'] ?>"><?= $statusTheme[$boxStatus]['text'] ?></span></h3>
        <div class="card mb-4">
          <div class="flex-column align-items-start card-body pt-4 pb-4">
            <div class="d-flex w-100 justify-content-between">
              <div class="">
                Hora Actual:<br>
                <?php
                echo date('Y-m-d H:i');
                echo '<br>';
                //echo date("Y-m-d H-m-s", strtotime(date("Y-m-d").'T00:00:01-06:00'));
                //echo $report_date;
                /*echo $daydiff;
                echo "<br>";
                echo strtotime($report_date);
                echo "<br>";
                echo time();
                echo "<br>";
                echo time() - strtotime($report_date);
                echo "<br>";
                echo round((time() - strtotime($report_date))/ (60 * 60 * 24));*/

                //echo date_default_timezone_get();
                /*
                ?>
              </div>
              <div class="col-6">
                <?php
                if ($daydiff == 0 && isset($statusTheme[$boxStatus]['next'])) {
                  $nextStep = $statusTheme[$boxStatus]['next'];
                  ?>
                    <?= Html::a($statusTheme[$nextStep]['verb']." ".Html::tag("span", "", ["class" => "fas fa-chevron-right"]), Url::to(['/cashbox/index']), ["class" => "btn btn-".$statusTheme[$nextStep]['color']]) ?>
                  <?php
                }
                ?>
              </div>
            </div>
          </div>
        </div>
        <?php
        if ($is_open > 0 || $is_close) :
          ?>
          <h4><i class="fa-regular fa-rectangle-list"></i> Datos Ingresados</h4>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Fecha y Hora</th>
                <th scope="col">Nombre</th>
                <th scope="col">Tipo</th>
                <th scope="col">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $cashier_arrays = array_merge($is_close? $close_list : [], $is_open? $open_list : []);
              foreach ($cashier_arrays as $i => $record) {
                ?>
                <tr>
                  <td><?= date("Y-m-d g:i a", strtotime($record->created_at)) ?></td>
                  <td><?= $record->created_by_full_name ?></td>
                  <td><?= $record->getRecordTypeText() ?></td>
                  <td class="text-right"><?= Yii::$app->formatter->asDecimal($record->cashbox_total/100,2) ?> <a href="#"><span class="fas fa-chevron-down"></span></a></td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        <?php
          if ($is_close) :
            ?>
          <h4><i class="fa-solid fa-arrows-split-up-and-left"></i> Cierre del Día</h4>
            <?php
            if (!empty($result) && !empty($result->getOrders())) :
              $order_list = $result->getOrders();
              $sum_totals = [
                'third_party_card' => 0,
                'cash' => 0,
                'other' => 0,
                'subtotal' => 0,
                'discount' => [],
                'return' => 0,
                'refund' => 0,
                'tax' => 0,
                'total' => 0
              ];
              foreach ($order_list as $list_item) :

                // TENDERS
                $tender_types = [];
                $tenders = $list_item->getTenders();
                if (!empty($tenders)) {
                  foreach ($tenders as $tender) {
                    $type = strtolower($tender->getType());
                    $value = intval($tender->getAmountMoney()->getAmount());
                    $sum_totals[$type] += $value;
                    $sum_totals['total'] += $value;

                    if (isset($tender_types[$type])) {
                      $tender_types[$type]['sum'] += intval($tender->getAmountMoney()->getAmount());
                      $tender_types[$type]['count'] ++;
                    }
                    else {
                      $tender_types[$type] = [
                        'sum' => intval($tender->getAmountMoney()->getAmount()),
                        'count' => 1,
                        //'theme' => $tenderTheme[strtolower($tender->getType())]
                      ];
                    }
                  }
                }

                //$sum_totals['tax'] += intval($tender->getTaxes()->getAmount());
                // TAXES
                if (!empty($list_item->getTaxes())) :
                  foreach ($list_item->getTaxes() as $index => $tax) {
                    $sum_totals['tax'] += $tax->getAppliedMoney()->getAmount();
                    ?>
                    <!--pre>
                      <?php //print_r(); ?>
                    </pre-->
                    <?php
                  }
                endif;

                // DISCOUNTS
                $discounts = $list_item->getDiscounts();
                if (!empty($discounts)) {
                  foreach ($discounts as $discount) {
                    if (!isset($sum_totals['discount'][$discount->getCatalogObjectId()])) :
                      $sum_totals['discount'][$discount->getCatalogObjectId()] = [
                        'name' => $discount->getName(),
                        'type' => $discount->getType(),
                        'amount' => (
                          $discount->getType() == \Square\Models\OrderLineItemDiscountType::FIXED_PERCENTAGE || $discount->getType() == \Square\Models\OrderLineItemDiscountType::VARIABLE_PERCENTAGE ?
                          $discount->getAppliedMoney()->getAmount() :
                          $discount->getAmountMoney()->getAmount()
                        ),
                      ];
                    else :
                      $sum_totals['discount'][$discount->getCatalogObjectId()]['amount'] +=
                        $discount->getType() == \Square\Models\OrderLineItemDiscountType::FIXED_PERCENTAGE || $discount->getType() == \Square\Models\OrderLineItemDiscountType::VARIABLE_PERCENTAGE ? $discount->getAppliedMoney()->getAmount() : $discount->getAmountMoney()->getAmount();
                    endif;
                  }
                }

                // RETURNS
                $return_list = $list_item->getReturns();
                if (!empty($return_list)) {
                  foreach ($return_list as $return_item) {
                    if (!empty($return_item->getReturnAmounts()))
                      $sum_totals['return'] -= $return_item->getReturnAmounts()->getTotalAmount();
                  }
                }

                // REFUNDS
                $refunds = $list_item->getRefunds();
                if (!empty($refunds)) {
                  foreach ($refunds as $refund) {
                    if (!empty($refund->getAmountMoney()))
                      $sum_totals['refund'] -= $refund->getAmountMoney()->getAmount();
                  }
                }
              endforeach;
              // CONSOLIDATE
              if ($sum_totals['return'] <> 0 || $sum_totals['refund'] <> 0)
                $sum_totals['total'] += $sum_totals['return'] + $sum_totals['refund'];

              if ($is_close && $is_open) :
                $opening = $open_list[0];
                $closing = $close_list[0];

                $box_cash = 0;
                if (!empty($closing->getCashSales())) {
                  foreach ($closing->getCashSales() as $sale) {
                     $box_cash += $sale->total_rated;
                  }
                }
                $box_expenses = !empty($closing->getExpenses()) ? $closing->getExpenses()->total_amount : 0;

                $cash_difference = $box_expenses + $box_cash - $sum_totals['cash'];

                $box_card = !empty($closing->getCardSales()) ? $closing->getCardSales()->total_amount  : 0 ;
                $card_difference = $box_card - $sum_totals['third_party_card'];
              ?>
              <table class="table">
                <thead>
                  <tr style="text-align: right;">
                    <th scope="col" style="text-align: left;">Descripcion</th>
                    <th scope="col"><i class="fa-solid fa-down-long"></i> Ingreso</th>
                    <th scope="col"><i class="fa-solid fa-up-long"></i> Egreso</th>
                    <th scope="col"><i class="fa-solid fa-tablet-screen-button"></i> Sistema</th>
                    <th scope="col">Diferencia</th>
                  </tr>
                </thead>
                <tbody class="text-right">
                  <tr>
                    <td class="text-left">Efectivo</td>
                    <td><?= Yii::$app->formatter->asDecimal($box_cash/100, 2)  ?></td>
                    <td><?= Yii::$app->formatter->asDecimal($box_expenses/100, 2)  ?></td>
                    <td><?= Yii::$app->formatter->asDecimal($sum_totals['cash']/100, 2) ?></td>
                    <td><span class="badge badge-<?= $cash_difference > 0 ? "warning" : ($cash_difference < 0 ? "danger" : "success") ?>" style="font-size: 1em;"><?= Yii::$app->formatter->asDecimal($cash_difference/100, 2) ?></span></td>
                  </tr>
                  <tr>
                    <td class="text-left">Tarjeta</td>
                    <td><?= Yii::$app->formatter->asDecimal($box_card/100, 2) ?></td>
                    <td></td>
                    <td><?= Yii::$app->formatter->asDecimal($sum_totals['third_party_card']/100, 2) ?></td>
                    <td><span class="badge badge-<?= $card_difference > 0 ? "warning" : ($card_difference < 0 ? "danger" : "success") ?>" style="font-size: 1em;"><?= Yii::$app->formatter->asDecimal($card_difference/100, 2) ?></span></td>
                  </tr>
                  <tr>
                    <td class="text-left">Other</td>
                    <td><?php // Yii::$app->formatter->asDecimal($box_card/100, 2) ?></td>
                    <td></td>
                    <td><?= Yii::$app->formatter->asDecimal($sum_totals['other']/100, 2) ?></td>
                    <td><?php // Yii::$app->formatter->asDecimal($card_difference/100, 2) ?></td>
                  </tr>
                  <tr class="font-weight-bold table-<?= $card_difference+$cash_difference > 0 ? "warning" : ($card_difference+$cash_difference < 0 ? "danger" : "success") ?>">
                    <td class="text-left">Total</td>
                    <td><?= Yii::$app->formatter->asDecimal($closing->income_total/100, 2) ?></td>
                    <td><?= Yii::$app->formatter->asDecimal($closing->outcome_total/100, 2) ?></td>
                    <td><?= Yii::$app->formatter->asDecimal($sum_totals['total']/100, 2) ?></td>
                    <td><span class="badge badge-<?= $card_difference > 0 ? "warning" : ($card_difference+$cash_difference < 0 ? "danger" : "success") ?>" style="font-size: 1em;"><?= Yii::$app->formatter->asDecimal(($card_difference+$cash_difference)/100, 2) ?></span></td>
                  </tr>
                </tbody>
              </table>
              <?php
              endif;
              ?>
              <h4><i class="fas fa-chart-simple"></i> Reporte Sistema Square</h4>
              <div class="list-group list-group-flush">
                <div class="list-group-item list-group-item-action flex-column align-items-start">
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Ventas Totales</h5>
                    <b><sup>Q</sup><?= Yii::$app->formatter->asDecimal($sum_totals['total']/100, 2) ?></b>
                  </div>
                </div>
                <div class="list-group-item list-group-item-action flex-column align-items-start">
                  <div class="d-flex w-100 justify-content-between">
                    <p class="mb-1">Efectivo</p>
                    <span><sup>Q</sup><?= Yii::$app->formatter->asDecimal($sum_totals['cash']/100, 2) ?></b>
                  </div>
                </div>
                <div class="list-group-item list-group-item-action flex-column align-items-start">
                  <div class="d-flex w-100 justify-content-between">
                    <p class="mb-1">Tarjeta</p>
                    <span><sup>Q</sup><?= Yii::$app->formatter->asDecimal($sum_totals['third_party_card']/100, 2) ?></span>
                  </div>
                </div>
                <div class="list-group-item list-group-item-action flex-column align-items-start">
                  <div class="d-flex w-100 justify-content-between">
                    <p class="mb-1">Other</p>
                    <span><sup>Q</sup><?= Yii::$app->formatter->asDecimal($sum_totals['other']/100, 2) ?></span>
                  </div>
                </div>
                <div class="list-group-item list-group-item-action flex-column align-items-start">
                  <div class="d-flex w-100 justify-content-between">
                    <p class="mb-1">Refund</p>
                    <span>-<sup>Q</sup><?= Yii::$app->formatter->asDecimal($sum_totals['refund']/100, 2) ?></span>
                  </div>
                </div>
                <div class="list-group-item list-group-item-action flex-column align-items-start">
                  <b class="mb-1">Descuentos Aplicados</b>
                  <?php
                  if (!empty($sum_totals['discount'])) :
                    foreach ($sum_totals['discount'] as $id => $discount_data) : ?>
                    <div class="d-flex w-100 justify-content-between">
                      <p class="mb-1"><?= $discount_data['name'] ?></p>
                      <span>-<sup>Q</sup><?= Yii::$app->formatter->asDecimal($discount_data['amount']/100, 2) ?></span>
                    </div>
                    <?php
                    endforeach;
                endif; ?>
                </div>
              </div>
              <?php /*
              ?><pre><?php
              print_r($sum_totals);
              ?></pre><?php */
              /*
            endif;

          endif;
        endif;
        ?>
      </div>
      <div class="col-lg-6 col-md-6">
        <h3><i class="fas fa-tablet-alt"></i> Sistema Square</h3>
        <?php
        if (!empty($result) && !empty($result->getOrders())) :
          $order_list = $result->getOrders();
          ?>
          <div>
            Ventas: <?= count($order_list); ?> ordenes
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
          foreach ($order_list as $order_item) :
              $tender_types = [];
              $tenders = $order_item->getTenders();
              if (!empty($tenders)) {
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
              }
              ?>
          <div class="order-item">
            <div class="row">
              <div class="col-4">
              <?php foreach ($tender_types as $name => $details) : ?>
                <div style="display: inline-block;">
                  <span class="<?= $details["theme"]["icon"] ?>"></span> <span class="badge badge-<?= $details["theme"]["color"] ?>"><?= $details["count"] ?></span>
                </div>
              <?php endforeach; ?>
              <?php if ($order_item->getDiscounts()) : ?>
                <i class="fa-solid fa-tag"></i>
              <?php endif; ?>
              </div>
              <div class="col-4">
                <b><sup><?= \common\models\Currency::findCurrencyByISO($order_item->getTotalMoney()->getCurrency())->symbol ?></sup> <?= Yii::$app->formatter->asDecimal($order_item->getTotalMoney()->getAmount() / 100,2) ?></b>
              </div>
              <div class="col-4">
                <?= date("g:i a" ,strtotime($order_item->getClosedAt())) ?>
                <a href="#"><span class="fas fa-chevron-down"></span></a>
              </div>
            </div>
            <div class="order-line-items">
              <?php
              $line_items = $order_item->getLineItems();
              $order_items = [];
              if (!empty($line_items)) {
                foreach($line_items as $line_item) {
                  $order_items[$line_item->getName()] = 1;
                }
              }
              $itmeStr = implode(", ", array_keys($order_items));
              ?>
              <?= $itmeStr ?>
            </div>
          </div>
          <?php
          endforeach; ?>

        <?php endif; ?>
      </div>

    </div>
     <?php */ ?>
 </div>
