<?php

namespace frontend\controllers;

use Yii;
use common\models\Staff;
use frontend\models\StaffSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

//require 'vendor/autoload.php';
use Square\SquareClient;
use Square\Environment;
use Square\Exceptions\ApiException;

use common\models\UploadForm;
use yii\web\UploadedFile;

use felgt\Digifact;
use felgt\models\ComplementoItem;
use felgt\models\DatosAnulacion;
use felgt\models\DatosGenerales;
use felgt\models\Direccion;
use felgt\models\Emisor;
use felgt\models\Factura;
use felgt\models\FacturaItem;
use felgt\models\FacturaTotal;
use felgt\models\Frase;
use felgt\models\Impuesto;
use felgt\models\Producto;
use felgt\models\Receptor;


/**
 * StaffController implements the CRUD actions for Staff model.
 */
class FacturaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Staff models.
     * @return mixed
     * @throws NotFoundHttpException if api call fails
     */
    public function actionIndex()
    {

        $client = new SquareClient([
            'accessToken' => Yii::$app->params['SQUARE_ACCESS_TOKEN'],
            'environment' => Environment::PRODUCTION,
        ]);

        /* $client = new SquareClient([
            'accessToken' => Yii::$app->params['SQUARE_ACCESS_TOKEN_SANDBOX'],
            'environment' => Environment::SANDBOX,
            'sslVerification' => false,
        ]);*/

        $result = null;
        $errors = null;


        $location_ids = ['14M2PH4P0XV7W'];
        $created_at = new \Square\Models\TimeRange();
        $created_at->setStartAt('2022-11-28T00:00:01-06:00');
        $created_at->setEndAt('2022-11-28T23:59:59-06:00');

        $date_time_filter = new \Square\Models\SearchOrdersDateTimeFilter();
        $date_time_filter->setCreatedAt($created_at);

        $filter = new \Square\Models\SearchOrdersFilter();
        $filter->setDateTimeFilter($date_time_filter);

        $query = new \Square\Models\SearchOrdersQuery();
        $query->setFilter($filter);

        $body = new \Square\Models\SearchOrdersRequest();
        $body->setLocationIds($location_ids);
        $body->setQuery($query);
        //$body->setLimit(3);
        $body->setReturnEntries(false);



        try {
            $api_response = $client->getOrdersApi()->searchOrders($body);

            if ($api_response->isSuccess()) {
                $result = $api_response->getResult();
            } else {
                $errors = $api_response->getErrors();
            }

            /*$apiResponse = $client->getLocationsApi()->listLocations();
            if ($apiResponse->isSuccess()) {
                $result = $apiResponse->getResult();
                /*foreach ($result->getLocations() as $location) {
                    printf(
                        "%s: %s, %s, %s<p/>",
                        $location->getId(),
                        $location->getName(),
                        $location->getAddress()->getAddressLine1(),
                        $location->getAddress()->getLocality()
                    );
                }* /

            } else {
                $errors = $apiResponse->getErrors();
                /*foreach ($errors as $error) {
                    printf(
                        "%s<br/> %s<br/> %s<p/>",
                        $error->getCategory(),
                        $error->getCode(),
                        $error->getDetail()
                    );
                }* /
            }*/

        } catch (ApiException $e) {
          //  echo "ApiException occurred: <b/>";
            //echo $e->getMessage() . "<p/>";
            throw new NotFoundHttpException(Yii::t('erp.sys', 'ApiException occurred: '.$e->getMessage() ));
        }

        //return $this->redirect(['site/index']);
        /*
        $searchModel = new StaffSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['company_id' => array_keys(Yii::$app->user->identity->companyList)]);
        */
        return $this->render('index', [
            'result' => $result,
            'errors' => $errors,
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists batch FEL generation
     * @return mixed
     * @throws NotFoundHttpException if api call fails
     */
    public function actionBatch()
    {
        $model = new UploadForm();

        // move this inside model validated
        $productionMode = $this->loadProductionMode();
        $accessInfo = $this->loadAccessInfo($productionMode);
        if (empty($accessInfo))
          throw new NotFoundHttpException(Yii::t('erp.sys', 'FELException occurred: connection could not be created'));

        //$digifact = new Digifact("44653948","GT.000044653948.FRANTEST","E8t8rqdq5%"); // sandbox
        //$digifact = new Digifact("96569611","GT.000096569611.96569611","Dy34j9o47o3$",false); // live
        $digifact = new Digifact($accessInfo['nit'],"GT.".str_pad($accessInfo['nit'], 12, '0', STR_PAD_LEFT).".".$accessInfo['username'],$accessInfo['password'], $productionMode == "sandbox");


        // try to make a factura
        //$datosGenerales = new DatosGenerales("");
        //$factura = new

        if (Yii::$app->request->isPost) {
            $model->csvFile = UploadedFile::getInstance($model, 'csvFile');
            if ($model->upload()) {
                //Yii::debug(print_r("file uploaded", true));
                // file is uploaded successfully
                //Yii::$app->session->setFlash('success', 'File "'.($model->csvFile->baseName . '.' . $model->csvFile->extension).'" uploaded');
                if( $data = $this->loadFile($model)) {
                    Yii::$app->session->setFlash('success', 'file data loaded');
                    return $this->render('batch',
                      [
                        'model' => $model,
                        'data' => $data
                      ]
                    );
                }
            }
            else {
                Yii::$app->session->setFlash('error', 'File FAIL to upload');
            }
        }

        return $this->render('batch',
          [
            'model' => $model,
            'fel' => $digifact
          ]
        );
    }


    private function loadAccessInfo($production = "sandbox")
    {
        if (isset(Yii::$app->params['digifact.access']) && isset(Yii::$app->params['digifact.access'][$production]) && is_array(Yii::$app->params['digifact.access'][$production])) {
          if (isset(Yii::$app->params['digifact.access'][$production]['nit']) && isset(Yii::$app->params['digifact.access'][$production]['username']) && isset(Yii::$app->params['digifact.access'][$production]['password'])) {
            return [
              'nit' => Yii::$app->params['digifact.access'][$production]['nit'],
              'username' => Yii::$app->params['digifact.access'][$production]['username'],
              'password' => Yii::$app->params['digifact.access'][$production]['password']
            ];
          }
        }
        return null;
    }

    private function loadProductionMode()
    {
        return isset(Yii::$app->params['digifact.serverProduction']) ? (Yii::$app->params['digifact.serverProduction'] ? 'production' : 'sandbox') : 'sandbox';
    }

    /**
     * Loads file
     * @param UploadForm $loadedForm
     * @return mixed
     */
    private function loadFile($loadedForm)
    {
      if (!empty($loadedForm->csvFile)) {
          $fileHandler = fopen('uploads/' . $loadedForm->csvFile->baseName . '.' . $loadedForm->csvFile->extension,'r');
          if ($fileHandler) {
              $lines = [];
              while ($line = fgetcsv($fileHandler,1000,",")) {
                if (is_array($line))
                  $lines[] = $line;
              }
              fclose($fileHandler);
              return $lines;
          }
      }
      return false;
    }


    /**
     * Displays a single Staff model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Staff model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $event_limits = Yii::$app->user->identity->company->companyLimits;
        $staff = Yii::$app->user->identity->company->staff;
        if (count($staff) >= $event_limits['staff'])
            return $this->redirect(['index']);

        $model = new Staff();
        $model->company_id = Yii::$app->user->identity->company->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Staff model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Staff model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Staff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Staff the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Staff::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('erp.sys', 'The requested page does not exist.'));
    }
}
