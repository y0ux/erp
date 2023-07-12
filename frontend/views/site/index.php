<?php

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

  <div class="jumbotron">
    <img src="/images/fca-antigua-2023-logo-final-sm.png" alt="FCA 2023 Logo">
    <h1 class="display-4">Festival de Cerveza Artesanal 2023</h1>
    <p class="lead">En esta sección del sistema podras ingresar info de la empresa y staff.</p>
    <hr class="my-4">
    <p>Si no tienes invitación para crear un usuario solicítala con la organización del evento.</p>
    <p class="lead">
      <a class="btn btn-success btn-lg" href="https://wa.me/50249676591" role="button" target="_blank">Contacto</a>
    </p>
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
