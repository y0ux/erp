<?php

namespace frontend\controllers;

use Yii;
use common\models\Beer;
use common\models\BeerStyle;
use common\models\SrmColor;
use common\models\Product;
use common\models\ProductPrice;
use common\models\Category;
use frontend\models\BeerSearch;
use frontend\models\ProductPriceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BeerController implements the CRUD actions for Beer model.
 */
class BeerController extends Controller
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
     * Lists all Beer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BeerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Beer model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $beer = $this->findModel($id);
        $product = $beer->product;
        $productPrice = $product->productPrice;

        $searchModel = new ProductPriceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['product_id' => $product->id]);

        return $this->render('view', [
            'model' => [
              'beer' => $beer,
              'product' => $product,
              'productPrice' => $productPrice,
              'dataProvider' => $dataProvider,
            ],
        ]);
    }

    /**
     * Creates a new Beer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $product = new Product();
        $product->product_type_id = Product::OTHER;
        $product->company_id = Yii::$app->user->identity->company->id;

        $productPrice = new ProductPrice();
        $beer = new Beer();

        //if ($product->load(Yii::$app->request->post()) && $product->save()) {
        if ($this->save($product, $productPrice, $beer)) {
            return $this->redirect(['view', 'id' => $beer->id]);
        }

        return $this->render('create', [
            'model' => [
              'product' => $product,
              'productPrice' => $productPrice,
              'beer' => $beer,
            ],
            'lists' => [
              'category' => Category::getCategoryList(),
              'beerStyle' => BeerStyle::getBeerStyleList(),
              'srmColor' => SrmColor::getSrmColorList(),
            ],
        ]);
    }

    /**
     * Updates an existing Beer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $beer = $this->findModel($id);
        $product = $beer->product;
        $productPrice = $product->productPrice;

        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($this->save($product, $productPrice, $beer)) {
            return $this->redirect(['view', 'id' => $beer->id]);
        }

        return $this->render('update', [
            'model' => [
              'product' => $product,
              'productPrice' => $productPrice,
              'beer' => $beer,
            ],
            'lists' => [
              'category' => Category::getCategoryList(),
              'beerStyle' => BeerStyle::getBeerStyleList(),
              'srmColor' => SrmColor::getSrmColorList(),
            ],
        ]);
    }

    /**
     * Deletes an existing Beer model.
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
     * Finds the Beer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Beer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Beer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('eventplanner.company', 'The requested page does not exist.'));
    }

    /**
     * Updates o creates a product.
     * @param Product $product
     * @param ProductPrice $productPrice
     * @param Beer $beer
     * @return mixed
     */
    protected function save($product, $productPrice, $beer)
    {
      $flash_id = 'beer-'.($product->isNewRecord? 'create' : 'update');
      Yii::$app->session->addFlash($flash_id, "flash_id: ".print_r($flash_id, true));
      Yii::$app->session->addFlash($flash_id, "model isNewRecord? ".($product->isNewRecord? "yes":"no"));

      $product_transaction = Product::getDb()->beginTransaction();
      try
      {
          if ( $product->load(Yii::$app->request->post()) && $product->save() )
          {
              $beer_transaction = Beer::getDb()->beginTransaction();
              $beer->product_id = $product->id;
              if ( $beer->load(Yii::$app->request->post()) && $beer->save() ) {
                $productPrice->product_id = $product->id;
                if ( $productPrice->load(Yii::$app->request->post()) && $productPrice->save() )
                {
                    Yii::$app->session->addFlash($flash_id, 'saving product price');
                }
                else {
                  return false;
                }
                Yii::$app->session->addFlash($flash_id, 'commiting beer');
                $beer_transaction->commit();
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
