<?php

namespace frontend\controllers;

use Yii;
use common\models\Product;
use common\models\ProductPrice;
use common\models\Category;
use common\models\Company;
use frontend\models\ProductSearch;
use frontend\models\ProductPriceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['company_id' => array_keys(Yii::$app->user->identity->companyList)]);

        $company_type = \Yii::$app->user->identity->company->company_type_id;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sellsBeer' => $company_type == Company::BREWERY || $company_type == Company::SUPPLIER,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        /** CHECK ACCESS ONLY TO HIS PRODUCTS **/
        $model = $this->findModel($id);

        $searchModel = new ProductPriceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['product_id' => $model->id]);

        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $product = new Product();
        $product->product_type_id = Product::OTHER;
        $product->company_id = Yii::$app->user->identity->company->id;

        $product_price = new ProductPrice();

        if($this->save($product, $product_price)) {
        //if ($product->load(Yii::$app->request->post()) && $product->save()) {
            return $this->redirect(['view', 'id' => $product->id]);
        }

        return $this->render('create', [
            'model' =>[
              'product' => $product,
              'product_price' => $product_price,
            ],
            'category' => Category::getCategoryList(),
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $product = $this->findModel($id);
        $product_price = $product->productPrice;

        if($this->save($product, $product_price)) {
        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $product->id]);
        }

        return $this->render('update', [
            'model' =>[
              'product' => $product,
              'product_price' => $product_price,
            ],
            'category' => Category::getCategoryList(),
        ]);
    }

    /**
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Updates o creates a product.
     * @param Product $product
     * @param ProductPrice $product_price
     * @return mixed
     */
    protected function save($product, $product_price)
    {
      $flash_id = 'product-'.($product->isNewRecord? 'create' : 'update');
      Yii::$app->session->addFlash($flash_id, "flash_id: ".print_r($flash_id, true));
      Yii::$app->session->addFlash($flash_id, "model isNewRecord? ".($product->isNewRecord? "yes":"no"));

      $product_transaction = Product::getDb()->beginTransaction();
      try
      {
          if ( $product->load(Yii::$app->request->post()) && $product->save() )
          {
              // save brand info
              Yii::$app->session->addFlash($flash_id,'checking product_price.. isNewRecord? '.($product_price->isNewRecord? "yes" : "no"));
              $product_price->product_id = $product->id;
              if ( $product_price->load(Yii::$app->request->post()) && $product_price->save() )
              {
                  Yii::$app->session->addFlash($flash_id, 'saving product price');
              }
              else {
                return false;
              }

              Yii::$app->session->addFlash($flash_id, 'commiting product');
              $product_transaction->commit();
              return true;
          }
      }
      catch (Exception $e)
      {
          $product_transaction->rollBack();
          Yii::$app->session->addFlash($flash_id,"There was an error trying to save the Product information: [".$e->getMessage()."]");
      }
      return false;
    }
}
