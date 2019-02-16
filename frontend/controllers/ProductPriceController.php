<?php

namespace frontend\controllers;

use Yii;
use common\models\ProductPrice;
use common\models\Product;
use frontend\models\ProductPriceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductPriceController implements the CRUD actions for ProductPrice model.
 */
class ProductPriceController extends Controller
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
     * Lists all ProductPrice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductPriceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->redirect(['/product/index']);

        /*return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
    }

    /**
     * Displays a single ProductPrice model.
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
     * Creates a new ProductPrice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param string $product_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCreate($product_id)
    {
        $model = new ProductPrice();

        if (($product = Product::findOne($product_id)) == null) {
            throw new NotFoundHttpException(Yii::t('eventplanner.company', 'The product requested does not exist.'));
        }

        $model->product_id = $product->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/product/view', 'id' => $model->product->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProductPrice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/product/view', 'id' => $model->product->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProductPrice model.
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
     * Finds the ProductPrice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductPrice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductPrice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('eventplanner.company', 'The requested page does not exist.'));
    }
}
