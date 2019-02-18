<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Festival de Cerveza Artesanal 2019 - Antigua Guatemala';
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

    <div class="jumbotron">
        <h1>Hola <?= Yii::$app->user->identity->username ?>!</h1>
        <p class="lead">Bienvenido al sistema de registro del Festival de Cerveza Artesanal 2019 - Antigua</p>
    </div>

    <div class=row>
      <div class="col-lg-8 col-md-6">
        <?= Html::img(Url::to('@web/images/santa-isabel-jardin-espacios-short-final.jpg'),['style' => 'max-width: 95%;']) ?>
      </div>
      <div class="col-lg-4 col-md-6">
        <h3>Cervecerias</h3>
          <ol>
            <li value="2">Cadejo</li>
            <li>Anchor Brewing Co.</li>
            <li>Bilste S.A.</li>
            <li>Pantera</li>
            <li>Sapiens</li>
            <li>Gúin</li>
            <li>El Zapote</li>
            <li>Ave Indiana</li>
            <li>Tajumulco</li>
            <li>El Principe Gris</li>
            <li value="14">Reservado</li>
            <li>Cerveceria 14</li>
            <li>Bodega Cervecera</li>
            <li>Xaman</li>
            <li>Antigua Cerveza</li>
            <?php /* foreach($breweries as $stand => $brewery) : ?>
              <li value="<?= $stand ?>"><?= $brewery->legal_name ?></li>
            <?php endforeach; */ ?>
          </ol>
          <!--pre>
            <?php // print_r($breweries) ?>
          </pre-->
        <h3>Restaurantes</h3>
          <ol>
            <li value="20">Producto Artesanal</li>
            <li>Chez Christophe</li>
            <li>Chermol</li>
            <li>Fruta Madre</li>
            <li>Cafeina</li>
            <li>Pappy's BBQ</li>
            <li>XQ No?</li>
            <li>Chermol</li>
            <li>Fridas</li>
          </ol>
        <h3>Cockteleria</h3>
          <ol>
            <li value="30">Simoneta</li>
            <li value="31">Chermol</li>
          </ol>
        <h3>Otros</h3>
          <ol>
            <li>Alimentos Exclusivos Artesanales</li>
            <li value="21">Los Patojos</li>
          </ol>
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
