<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
$menuItems = [
    ['label' => 'Inicio', 'url' => ['/site/index']],
    //['label' => 'About', 'url' => ['/site/about']],
    //['label' => 'Contact', 'url' => ['/site/contact']],
];
if (Yii::$app->user->isGuest) {
    //$menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
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
    $menuItems[] = '<li>'
        . Html::beginForm(
            ['/site/logout'],
            'post',
            ['class' => 'form-inline']
        )
        . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->username . ')',
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
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar sticky-top navbar-light bg-light',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav mr-auto mt-2 mt-lg-0'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div id="main-container" class="container-fluid">
      <div class="row">
        <?php if (!Yii::$app->user->isGuest) : ?>
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <?php
            $currentUrl = Url::current();
            $menuItems = [];
            //$menuItems[] = ['label' => 'Inicio', 'url' => ['/site/index']];
            // check if is already registered
            $company = Yii::$app->user->identity->company;
            $menuItems[] = ['label' => ' Dashboard', 'url' => ['/site/index'], 'icon' => 'dashboard'];

            //$menuItems[] = ['label' => ' Pedidos', 'url' => ['/order/index'], 'icon' => 'shopping-cart'];
            $menuItems[] = ['label' => ' Cierre Diario', 'url' => ['/cashbox/index'], 'icon' => 'off'];
            $menuItems[] = ['label' => ' Facturas', 'url' => ['/factura/index'], 'icon' => 'off'];
            //$menuItems[] = ['label' => ' Inventario', 'url' => ['/inventory/index'], 'icon' => 'barcode'];
            //$menuItems[] = ['label' => ' Staff', 'url' => ['/staff/index'], 'icon' => 'time'];

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
            <ul class="nav flex-column">
                <?php
                foreach ($menuItems as $menuitem) {
                    //print_r($menuitem);
                    //$label = '<i class="glyphicon glyphicon-chevron-right"></i>' . Html::encode($menuitem['label']);
                    $label = (!empty($menuitem['icon'])? '<i class="glyphicon glyphicon-'.$menuitem['icon'].' glyphicon-leftside"></i> ' : '') .
                    '<i class="glyphicon glyphicon-chevron-right"></i>' . Html::encode($menuitem['label']);
                    $active = Url::to($menuitem['url']) == $currentUrl;
                    echo Html::beginTag('li',['class' => 'nav-item']);
                    echo Html::a($label, $menuitem['url'], [
                        'class' => 'nav-link' . ($active ?  ' active': ''),
                    ]);
                    echo Html::endTag('li',['class' => 'nav-item']);
                }
                ?>
            </ul>
          <?php
            /*echo Nav::widget([
                'options' => ['class' => 'nav nav-sidebar'],
                'items' => $menuItems,
            ]);*/
            ?>
        </nav>
        <?php endif; ?>
        <main role="main" class="<?= (Yii::$app->user->isGuest? "col-sm-12" : "col-md-9 ml-sm-auto col-lg-10 px-4") ?> main">
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

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
