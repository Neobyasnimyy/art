<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Image;
use app\models\ImageSearch;
use app\models\Category;
use app\models\UploadImage;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ImageController implements the CRUD actions for images model.
 */
class ImageController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all images models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImageSearch();

        $categoryList = Category::getCategoriesList();
        $categoryList=[''=>'Все']+$categoryList;

//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider = $searchModel->search(Yii::$app->request->post()); // Pjax


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categoryList' => $categoryList,
        ]);
    }

    /**
     * Displays a single images model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new images model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($category=null)
    {
        $modelImage = new Image();
        $uploadImage = new UploadImage;
        $categoryList = Category::getCategoriesList();

        if ($modelImage->load(Yii::$app->request->post())) { //
            $uploadImage->image = UploadedFile::getInstance($uploadImage, 'image');
            $uploadImage->upload($modelImage->id_category); // этот метот сохраняет изображение в папке с id категории и занимается валидацией

            $modelImage->image_path = $uploadImage->image->name;
            $modelImage->save();

            Yii::$app->session->setFlash('success', 'Данные приняты'); // созданние одноразовых сообщений для пользователя(хранятся в сессии)
            return $this->redirect(['update', 'id' => $modelImage->id]);
        } else {
            if (!$category==null){
                $modelImage->id_category=$category;
            }
            return $this->render('create', [
                'modelImage' => $modelImage,
                'categoryList' => $categoryList,
                'uploadImage' => $uploadImage,
            ]);
        }
    }


    /**
     * Updates an existing images model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelImage = $this->findModel($id);
        $uploadImage = new UploadImage;
        $categoryList = Category::getCategoriesList();

        if ($modelImage->load(Yii::$app->request->post()) && $modelImage->save()) {
            Yii::$app->session->setFlash('success', 'Данные приняты'); // созданние одноразовых сообщений для пользователя(хранятся в сессии)
//            return $this->redirect(['update', 'id' => $modelImage->id]);
            return $this->redirect(Yii::$app->request->referrer); // перенаправляет на страницу с которой пришли
        } else {
            return $this->render('update', [
                'modelImage' => $modelImage,
                'categoryList' => $categoryList,
                'uploadImage' => $uploadImage,
            ]);
        }
    }

    /**
     * Deletes an existing images model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $item = $this->findModel($id);
        myDelete(Yii::getAlias('@uploads') . '/images/' . $item->id_category . '/' . $item->image_path); // удаляем изображение с сервера
        $item->delete();  // удаляем запись из базы данных
        Yii::$app->session->setFlash('success', 'Удаление прошло успешно'); // созданние одноразовых сообщений для пользователя(хранятся в сессии)
        return $this->redirect(['index']);
    }

    /**
     * Finds the images model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Image the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Image::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
