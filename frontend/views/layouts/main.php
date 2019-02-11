<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
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
    $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
    $menuItems[] = ['label' => 'Dashboard', 'url' => ['/site/index'], 'options' => ['class' => 'hidden-lg hidden-md hidden-sm']];
    $menuItems[] = ['label' => 'Registro', 'url' => ['/site/register'], 'options' => ['class' => 'hidden-lg hidden-md hidden-sm']];
    $menuItems[] = ['label' => 'Productos', 'url' => ['/product/index'], 'options' => ['class' => 'hidden-lg hidden-md hidden-sm']];
    $menuItems[] = ['label' => 'Personal', 'url' => ['/staff/index'], 'options' => ['class' => 'hidden-lg hidden-md hidden-sm']];
    $menuItems[] = ['label' => 'Vehiculos', 'url' => ['/vehicle/index'], 'options' => ['class' => 'hidden-lg hidden-md hidden-sm']];
    $menuItems[] = ['label' => 'Ventas', 'url' => ['/sales/index'], 'options' => ['class' => 'hidden-lg hidden-md hidden-sm']];
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
        . Html::beginForm(['/site/logout'], 'post')
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
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div id="main-container" class="container-fluid">
      <div class="row">
        <?php if (!Yii::$app->user->isGuest) : ?>
        <div class="col-sm-3 col-md-2 sidebar">
          <?php
            $currentUrl = Url::current();
            $menuItems = [];
            //$menuItems[] = ['label' => 'Inicio', 'url' => ['/site/index']];
            // check if is already registered
            $company = Yii::$app->user->identity->company;
            $menuItems[] = ['label' => 'Dashboard', 'url' => ['/site/index']];
            if (empty($company)) {
              $menuItems[] = ['label' => 'Registro', 'url' => ['/site/register']];
            } else {
              $menuItems[] = ['label' => 'Registro', 'url' => ['/site/view', 'id' => $company->id]];
            }
            $menuItems[] = ['label' => 'Marcas', 'url' => ['/brand/index']];
            $menuItems[] = ['label' => 'Productos', 'url' => ['/product/index']];
            $menuItems[] = ['label' => 'Personal', 'url' => ['/staff/index']];
            $menuItems[] = ['label' => 'Vehiculos', 'url' => ['/vehicle/index','#' => '']];
            $menuItems[] = ['label' => 'Ventas', 'url' => ['/sale/index']];
            $menuItems[] = ['label' => 'Categorias', 'url' => ['/category']];
          ?>
            <div class="list-group">
                <?php
                foreach ($menuItems as $menuitem) {
                    //print_r($menuitem);
                    $label = '<i class="glyphicon glyphicon-chevron-right"></i>' . Html::encode($menuitem['label']);
                    echo Html::a($label, $menuitem['url'], [
                        'class' => Url::to($menuitem['url']) == $currentUrl ? 'list-group-item active' : 'list-group-item',
                    ]);
                }
                ?>
            </div>
          <?php
            /*echo Nav::widget([
                'options' => ['class' => 'nav nav-sidebar'],
                'items' => $menuItems,
            ]);*/
            ?>
        </div>
        <?php endif; ?>
        <div class="<?= (Yii::$app->user->isGuest? "col-sm-12" : "col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2") ?> main">
          <?= Breadcrumbs::widget([
              'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
          ]) ?>
          <?= Alert::widget() ?>
          <?= $content ?>
        </div>
      </div>

      <div class="container">

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
