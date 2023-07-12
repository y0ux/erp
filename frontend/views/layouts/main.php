<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\User;


$cashboxMenuItem = ['label' => ' Cajero', 'url' => ['/cashbox/index']];
$receiptMenuItem = ['label' => ' Facturas', 'url' => ['/factura/index']];

AppAsset::register($this);
$menuItems = [
    ['label' => 'Inicio', 'url' => ['/site/index']],
    //['label' => 'About', 'url' => ['/site/about']],
    //['label' => 'Contact', 'url' => ['/site/contact']],
];
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
    if (Yii::$app->user->identity->status == User::STATUS_ACTIVE && !empty(Yii::$app->user->identity->company)) {
      //$menuItems[] = $cashboxMenuItem + ["options" => ["class" => "d-md-none"]];
      //$menuItems[] = $receiptMenuItem + ["options" => ["class" => "d-md-none"]];
      $menuItems[] = ['label' => ' Registro', 'url' => ['/site/register'], "options" => ["class" => "d-md-none"]];
      $menuItems[] = ['label' => ' Staff', 'url' => ['/staff/index'], "options" => ["class" => "d-md-none"]];
      $menuItems[] = ['label' => ' Productos', 'url' => ['/product/index'], "options" => ["class" => "d-md-none"]];

      //$menuItems[] = ['label' => 'Dashboard', 'url' => ['/site/index'], 'options' => ['class' => 'hidden-lg hidden-md hidden-sm']];
      //$menuItems[] = ['label' => ' Cierre de Caja', 'url' => ['/cashbox/index'], 'icon' => 'off'];
      //$menuItems[] = ['label' => 'Registro', 'url' => ['/site/register'], 'options' => ['class' => 'hidden-lg hidden-md hidden-sm']];
      //$menuItems[] = ['label' => 'Marcas', 'url' => ['/brand/index'], 'options' => ['class' => 'hidden-lg hidden-md hidden-sm']];
      //$menuItems[] = ['label' => 'Productos', 'url' => ['/product/index'], 'options' => ['class' => 'hidden-lg hidden-md hidden-sm']];
      //$menuItems[] = ['label' => 'Personal', 'url' => ['/staff/index'], 'options' => ['class' => 'hidden-lg hidden-md hidden-sm']];
      //$menuItems[] = ['label' => 'Vehiculos', 'url' => ['/vehicle/index'], 'options' => ['class' => 'hidden-lg hidden-md hidden-sm']];
      //$menuItems[] = ['label' => 'Ventas', 'url' => ['/sales/index'], 'options' => ['class' => 'hidden-lg hidden-md hidden-sm']];
      //s$menuItems[] = ['label' => 'Categorias', 'url' => ['/category/index'], 'options' => ['class' => 'hidden-lg hidden-md hidden-sm']];
      /*$menuItems[] = [
        'label' => 'Perfil',
        'items' => [
             //'<li class="divider"></li>',
             //'<li class="dropdown-header">Adicionales</li>',
             ['label' => 'Personal', 'url' => ['/staff/index'], 'options' => ['class' => '']],
             ['label' => 'Vehiculos', 'url' => ['/vehicle/index','#' => '']],
             ['label' => 'Ventas', 'url' => ['/sales/index']],
        ],
        'options' => ['class' => 'hidden-lg hidden-md'],
      ];*/
    }
    $logoutName = Yii::$app->user->identity->userProfile? Yii::$app->user->identity->userProfile->first_name : Yii::$app->user->identity->username;
    $menuItems[] = '<li>'
        . Html::beginForm(
            ['/site/logout'],
            'post',
            ['class' => 'form-inline']
        )
        . Html::submitButton(
            'Logout (' . $logoutName . ')',
            ['class' => 'btn btn-link logout']
        )
        . Html::endForm()
        . '</li>';
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-expand-md navbar sticky-top navbar-light bg-light',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ml-auto mt-2 mt-lg-0'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <!--nav class="navbar fixed-bottom navbar-light bg-light" style="margin-bottom: 50px">
      <div class="col-3">
        <a href="#" class="btn btn-info btn-block"><i class="fa-solid fa-cash-register"></i> Venta</a>
      </div>
      <div class="col-3">
        <a href="#" class="btn btn-info btn-block">Venta</a>
      </div>
      <div class="col-3">
        <a href="#" class="btn btn-info btn-block">Venta</a>
      </div>
      <div class="col-3">
        <a href="#" class="btn btn-info btn-block">Venta</a>
      </div>
    </nav-->

    <div id="main-container" class="container-fluid">
      <div class="row">
        <?php if (!Yii::$app->user->isGuest && \Yii::$app->user->identity->status == User::STATUS_ACTIVE && !empty(Yii::$app->user->identity->company)) : ?>
        <!--nav class="col-md-2 d-none d-md-block bg-light sidebar"-->
          <?php
            $currentUrl = Url::current();
            $menuItems = [];
            //$menuItems[] = ['label' => 'Inicio', 'url' => ['/site/index']];
            // check if is already registered
            //$company = Yii::$app->user->identity->company;
            $menuItems[] = [
                'label' => ' Inicio',
                'url' => ['/site/index'],
                'icon' => 'fa-solid fa-gauge'
            ];

            //$menuItems[] = $cashboxMenuItem + ['icon' => 'fa-solid fa-cash-register'];
            //$menuItems[] = $receiptMenuItem + ['icon' => 'fa-solid fa-receipt'];


            //$menuItems[] = ['label' => ' Pedidos', 'url' => ['/order/index'], 'icon' => 'shopping-cart'];

            //$menuItems[] = ['label' => ' Inventario', 'url' => ['/inventory/index'], 'icon' => 'barcode'];

            $menuItems[] = ['label' => ' Registro', 'url' => ['/site/register'], 'icon' => 'fa-solid fa-rocket'];
            $menuItems[] = ['label' => ' Staff', 'url' => ['/staff/index'], 'icon' => 'fa-solid fa-person'];
            $menuItems[] = ['label' => ' Productos', 'url' => ['/product/index'], 'icon' => 'fa-solid fa-tags'];


            //$menuItems[] = ['label' => 'Cash Flow', 'url' => ['/cash/index']];
            //$menuItems[] = ['label' => 'Ventas', 'url' => ['/sales/index']];
            //$menuItems[] = ['label' => 'Categorias', 'url' => ['/category/index']];


            /*if (empty($company)) {
              $menuItems[] = ['label' => 'Registro', 'url' => ['/site/register']];
            } else {
              $menuItems[] = ['label' => 'Registro', 'url' => ['/site/view', 'id' => $company->id]];
            }*/
            //$menuItems[] = ['label' => 'Marcas', 'url' => ['/brand/index']];
            //$menuItems[] = ['label' => 'Productos', 'url' => ['/product/index']];
            //$menuItems[] = ['label' => 'Personal', 'url' => ['/staff/index']];
            //$menuItems[] = ['label' => 'Vehiculos', 'url' => ['/vehicle/index','#' => '']];
            //$menuItems[] = ['label' => 'Ventas', 'url' => ['/sales/index']];

          ?>
            <!--ul class="nav flex-column">
                <?php
                /*foreach ($menuItems as $menuitem) {
                    //print_r($menuitem);
                    //$label = '<i class="glyphicon glyphicon-chevron-right"></i>' . Html::encode($menuitem['label']);
                    $label = (!empty($menuitem['icon'])? '<i class="'.$menuitem['icon'].'"></i> ' : '') .
                    '<i class="fa-solid fa-chevron-right"></i>' . Html::encode($menuitem['label']);
                    $active = Url::to($menuitem['url']) == $currentUrl;
                    echo Html::beginTag('li',['class' => 'nav-item' . ($active ?  ' active': '') ]);
                    echo Html::a($label, $menuitem['url'], [
                        'class' => 'nav-link',
                    ]);
                    echo Html::endTag('li',['class' => 'nav-item']);
                }*/
                ?>
            </ul-->

            <?php
              echo Nav::widget([
                'items' => $menuItems,
                /*[
                    [
                        'label' => 'Home',
                        'url' => ['site/index'],
                        'linkOptions' => [...],
                    ],
                    [
                        'label' => 'Dropdown',
                        'items' => [
                             ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
                             '<div class="dropdown-divider"></div>',
                             '<div class="dropdown-header">Dropdown Header</div>',
                             ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
                        ],
                    ],
                    [
                        'label' => 'Login',
                        'url' => ['site/login'],
                        'visible' => Yii::$app->user->isGuest
                    ],
                ],*/
                'options' => ['class' =>'col-md-2 d-none d-md-block bg-light sidebar'], // set this to nav-tabs to get tab-styled navigation
            ]);
          ?>
          <?php
            /*echo Nav::widget([
                'options' => ['class' => 'nav nav-sidebar'],
                'items' => $menuItems,
            ]);*/
            ?>
        <!--/nav-->
        <?php endif; ?>
        <main role="main" class="<?= (Yii::$app->user->isGuest || Yii::$app->user->identity->status != User::STATUS_ACTIVE || empty(Yii::$app->user->identity->company)? "col-sm-12" : "col-md-10 ml-sm-auto col-lg-10 px-4") ?> main">
          <?= Breadcrumbs::widget([
              'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
          ]) ?>
          <?= Alert::widget() ?>
          <?= $content ?>
        </main>
      </div>
    </div>
</div>

<footer class="footer">
    <div class="container-fluid">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <!--p class="pull-right"><?php //= Yii::powered() ?></p-->
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
