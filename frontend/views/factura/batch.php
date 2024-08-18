<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use common\widgets\Nav;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('erp.sys','Factura FEL');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
  echo Nav::widget([
    'items' =>
    [
        [
            'label' => 'Individual',
            'url' => ['factura/index'],
            //'linkOptions' => [...],
        ],
        [
            'label' => 'Lote',
            'url' => ['factura/batch'],
            //'visible' => Yii::$app->user->isGuest
        ],
    ],
    'options' => ['class' =>'nav justify-content-center nav-pills'], // set this to nav-tabs to get tab-styled navigation
  ]);
?>

<div class="factura-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    if (isset($fel)) {
      ?><h3>Digifact</h3><?php

      echo $fel->getEndpointUrlv3();

      //$NIT = str_pad("96569611", 12, '0', STR_PAD_LEFT);

      echo "NIT: ";
      ?><pre><?php
      print_r($fel->NITInfo("96569611"));
      ?></pre><?php
    }

    if (isset($data) && is_array($data)) {
        ?><h3>File Loaded</h3><?php
        /*$fileHandler = fopen('uploads/' . $model->csvFile->baseName . '.' . $model->csvFile->extension,'r');
        if ($fileHandler) {
            $lines = [];
            while ($line = fgetcsv($fileHandler,1000,",")) {
              if (is_array($line))
                $lines[] = $line;
            }
            if (count($lines) > 0) {
                echo "Loaded ".count($lines)." items.";
                //? ><pre><?php
                //print_r ($lines);
                //? ></pre><?php
                $row = 1;
                foreach ($lines as $i => $line) {

                    $num = count($line);
                    echo "<p> $num fields in line $row: <br /></p>\n";
                    $row++;
                    for ($c=0; $c < $num; $c++) {
                        echo $line[$c] . "<br />\n";
                    }
                }
            }
            fclose($fileHandler);
        } */

        if (count($data) > 0) {
            echo "Loaded ".count($data)." items.";
            //? ><pre><?php
            //print_r ($lines);
            //? ></pre><?php
            $row = 1;
            foreach ($data as $i => $line) {

                $num = count($line);
                echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                for ($c=0; $c < $num; $c++) {
                    echo $line[$c] . "<br />\n";
                }
            }
        }
    }
    ?>


    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'csvFile')->fileInput() ?>

        <button>Enviar</button>

    <?php ActiveForm::end() ?>


    <!--h2>Result</h2>
    <pre-->
      <?php  /* if ($result) {
        $orders = $result->getOrders();
        echo "conteo: ".count($orders)."\n";
        foreach($orders as $order)
          print_r($order);
        } */
      ?>
    <!--/pre-->

    <!--h2>Error</h2>
    <pre>
      <?php // print_r($errors); ?>
    </pre-->

    <!--p-->
        <?php /* if($sellsBeer) : ?>
          <?= Html::a(\Yii::t('erp.company','create_beer_btn'), ['/beer/create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
        <?= Html::a(\Yii::t('erp.company','create_product_btn'), ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ///'id',
            //'name',
            [
              'attribute' => 'name',
              'value' => function ($data) {
                return Html::a(
                  $data->name,
                  Url::toRoute((
                    empty($data->beer)?
                    ['product/view','id'=>$data->id] :
                    ['/beer/view','id'=>$data->beer->id]
                  )),
                  ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                );
              },
              'format' => ['raw']
            ],
            [
              'label' => \Yii::t('erp.company', 'Is Beer?'),
              'value' => function ($data) {
                return empty($data->beer)? \Yii::t('erp.company', 'No') : \Yii::t('erp.company', 'Yes');

              },
              'format' => ['raw']
            ],
            //'name_desc:ntext',
            [
              'attribute' => 'name_desc',
              'value' => function ($data) {
                if (empty($data->name_desc))
                  return null;
                return $data->name_desc;
              }
            ],
            //'details:ntext',
            //'brand_id',
            [
              'attribute' => 'brand_id',
              'label' => \Yii::t('erp.company', 'Brand'),
              'value' => function ($data) {
                if (!empty($data->brand_id)) {
                  return Html::a(
                    $data->brand->name,
                    Url::toRoute(['brand/view','id'=>$data->brand->id]), ['data' => ['pjax' => '0'], 'class' => 'set-class-here']
                  );
                }
                return null;
              },
              'format' => ['raw']
            ],
            //'product_type_id',
            //'category_id',
            //'created_at',
            //'updated_at',

            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'update' => false,
                    'view' => false,
                ]
            ],
        ],
        'tableOptions' => ['class' => 'table table-striped']
    ]); ?>
    <?php Pjax::end(); */ ?>
</div>
