<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Category;
use app\models\CategorySearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use app\models\Image;
use app\models\ImageSearch;
use app\models\UploadImage;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends AppAdminController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete-category' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();

//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider = $searchModel->search(Yii::$app->request->post()); // Pjax

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

//    /**
//     * Displays a single Category model.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateCategory()
    {
        $modelCategory = new Category();

        if ($modelCategory->load(Yii::$app->request->post()) && $modelCategory->save()) {
            mkdir(Yii::getAlias('@app') . '/web/uploads/images/' . $modelCategory->id, 0775, true);
            Yii::$app->session->setFlash('success', "Данные сохранены. Вернутся к <a href='/admin/category'>списку категорий</a>!"); // созданние одноразовых сообщений для пользователя(хранятся в сессии)
            return $this->redirect(['update-category', 'id' => $modelCategory->id]);
        } else {
            return $this->render('create-category', [
                'modelCategory' => $modelCategory,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateCategory($id)
    {
        $modelCategory = $this->findModel($id);
        $searchModelImage = new ImageSearch();
        $searchModelImage->id_category = $id;
        $categoryList = Category::getCategoriesList();
        $categoryListForFilter = ['' => 'Все'] + $categoryList;
        $dataProviderImage = $searchModelImage->search(Yii::$app->request->queryParams);// Pjax



        if ($modelCategory->load(Yii::$app->request->post()) && $modelCategory->save()) {
            Yii::$app->session->setFlash('success', "Данные сохранены. Вернутся к <a href='/admin/category'>списку категорий</a>!"); // созданние одноразовых сообщений для пользователя(хранятся в сессии)
            return $this->refresh();
        }

        return $this->render('update-category', [
            'modelCategory' => $modelCategory,
            'searchModelImage' => $searchModelImage,
            'dataProviderImage' => $dataProviderImage,
            'categoryList' => $categoryList,
            'categoryListForFilter' => $categoryListForFilter,
        ]);

    }


    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteCategory($id)
    {
        $this->findModel($id)->delete();
        myDelete(Yii::getAlias('@app') . '/web/uploads/images/' . $id);
        Yii::$app->session->setFlash('success', 'Данные успешно удалены'); // созданние одноразовых сообщений для пользователя(хранятся в сессии)
        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
