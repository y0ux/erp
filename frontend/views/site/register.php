<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;

$this->title = 'Registro';
$this->params['breadcrumbs'][] = $this->title;
$companyDetails = $model['company']->isNewRecord && !empty($model['company']->details)? [] : json_decode($model['company']->details);
$flash_messages = Yii::$app->session->getFlash('company-create',[]);
array_merge($flash_messages,Yii::$app->session->getFlash('company-create',[]));
?>

<div class="site-register">
    <?php
      /*if (!empty($flash_messages)) :
        echo Alert::widget([
           'options' => ['class' => 'alert-info'],
           'body' => "<pre>".implode("<br/>", $flash_messages)."</pre>",
        ]);
      endif;*/
    ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Por favor, llena estos datos para poder registrarte:</p>

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <h3>Datos de la Empresa</h3>
                <?= $form->field($model['company'], 'legal_name')->textInput(['autofocus' => true])->label(null, ['class' => 'required-field']) ?>

                <?= $form->field($model['company'], 'company_type_id')->inline(true)->radioList($lists['company_types'])->label('Tipo de Empresa', ['class' => 'required-field']); ?>

            <h3>Datos de Conciliacion</h3>
                <?= $form->field($model['company'], 'nit')->label(null, ['class' => 'required-field']) ?>
                <?= $form->field($model['company'], 'address_1')->label(null, ['class' => 'required-field']) ?>
                <?= $form->field($model['company'], 'address_2')->label(null, ['class' => 'optional-field']) ?>
                <div class='form-group'>
                  <label class="control-label required-field" for="Company[city]">Ciudad</label>
                  <?= Html::input('text', 'Company[city]', !empty($companyDetails) && property_exists($companyDetails,'city')? $companyDetails->city : null ,['class' => 'form-control', 'required' => true]) ?>
                </div>
                <!--div class='form-group'>
                  <label class="control-label" for="country">Pais</label>
                  <!--?= Html::dropDownList('country', null ,[502 => 'Guatemala', 503 => 'El Salvador', 504 => 'Honduras', 505 => 'Nicaragua', 506 => 'Costa Rica', 52 => 'Mexico', 1 => 'USA'] ,['class' => 'form-control']) ?>
                </div-->
                <?php
                $bank_list = [
                    1 => 'Industrial',
                    2 => 'G&T Continental',
                    3 => 'Banrural',
                    4 => 'BAM',
                    5 => 'Inter',
                    6 => 'BAC',
                    7 => 'Inmobiliario',
                    8 => 'Promerica',
                    9 => 'Azteca',
                    10 => 'Bantrab'];
                 ?>

                <?= $form->field($model['bank_account'], 'bank_id')
                  ->dropDownList($bank_list,['prompt' => 'Selecciona...', 'options' => ['value' => 'none', 'class' => 'prompt', 'label' => 'Select']])
                  ->label(\Yii::t('eventplanner.company', 'Bank Name'), ['class' => 'required-field']) ?>
                <?= $form->field($model['bank_account'], 'beneficiary')->label(null, ['class' => 'required-field']) ?>
                <?= $form->field($model['bank_account'], 'account_number')->label(null, ['class' => 'required-field']) ?>
                <?= $form->field($model['bank_account'], 'type')->dropDownList([0 => 'Monetaria', 1 => 'Ahorro'])->label(null, ['class' => 'required-field']) ?>
                <h3>Marca</h3>
                <?= $form->field($model['brand'], 'name')->label('Nombre de la Marca', ['class' => 'required-field']) ?>
                <h3>Participacion</h3>
                <div class='form-group'>
                  <?= Html::checkbox('Company[first-time]', !empty($companyDetails) && property_exists($companyDetails,'firstTime')? $companyDetails->firstTime : false , ['class' => '']) ?>
                  <?= HTML::label('Primera vez','Company[first-time]',['class' => 'control-label optional-field']); ?>
                </div>
                <div class='form-group'>
                  <?= Html::radio('Company[cost-compromise]', !empty($companyDetails) && property_exists($companyDetails,'costCompromise')? $companyDetails->costCompromise : false, ['class' => '', 'required'=>true]) ?>
                  <label class="control-label required-field" for="Company[cost-compromise]">Me comprometo con el costo de participacion</label>
                </div>
                <?php
                  $stands = [
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                    6 => '6',
                    7 => '7',
                    8 => '8',
                    9 => '9',
                    10 => '10',
                    11 => '11',
                    12 => '12',
                    13 => '13',
                    14 => '14',
                    15 => '15',
                    16 => '16',
                    17 => '17',
                    18 => '18',
                    //19 => '19',
                  ];
                  foreach ($lists['stands_taken'] as $key => $taken) {
                    if ($key <> $model['company']->stand && in_array($key, $stands))
                      unset($stands[$key]);
                  }
                ?>

                <?= $form->field($model['company'], 'stand')->label('Stand',['class' => 'required-field'])->dropDownList($stands, ['class' => 'form-control', 'required'=>true,  'prompt' => 'Selecciona...', 'options' => ['value' => 'none', 'class' => 'prompt', 'label' => 'Select']]) ?>
                <div class='row'>
                  <div class='col-sm-6 col-md-6 '>
                    <div class='form-group'>
                      <br>
                      <?= Html::img(Url::to('@web/images/santa-isabel-jardin-espacios-short.jpg'),['style' => 'max-width: 95%;']) ?>
                    </div>
                  </div>
                  <?php

                  ?>
                  <div class='col-sm-6 col-md-6 '>
                    <ol>
                      <h4>Cervecerias</h4>
                      <?php
                      $keys = array_keys($lists['stands_taken']);
                      for ($i = 1; $i < 19; $i++) {
                        if (in_array($i, $keys)) {
                          if ($i == $model['company']->stand)
                            echo '<li style="color: #2ecc71; font-weight: bold;">'.$lists['stands_taken'][$i].'</li>';
                          else
                            echo '<li style="color: #ccc;">'.($i == 1 || $i == 13 || $i == 18? 'Reservado' : $lists['stands_taken'][$i]).'</li>';
                        }
                        else
                          echo '<li>Disponible</li>';
                      }
                      ?>
                    </ol>
                  </div>
                </div>

                <div class="form-group">
                    <?= Html::submitButton($model['company']->isNewRecord? 'Registrar' : 'Actualizar', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>


            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
