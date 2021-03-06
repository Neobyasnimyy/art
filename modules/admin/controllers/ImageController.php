<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Image;
use app\models\ImageSearch;
use app\models\Category;
use app\models\UploadImage;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\Response;
/**
 * ImageController implements the CRUD actions for images model.
 */
class ImageController extends AppAdminController
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
                    'update-category' => ['POST'],
                    'update-name' => ['POST'],
                    'edit-slider' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all images models.
     * @return mixed
     */
//    public function actionIndex()
//    {
//        $searchModel = new ImageSearch();
//        $modelImage = new Image();
//        $uploadImage = new UploadImage();
//        $categoryList = Category::getCategoriesList();
//        $categoryListForFilter = ['' => 'Все'] + $categoryList;
//        $dataProvider = $searchModel->search([]);
//        $openForm = false;
//
////        $dataProvider = $searchModel->search(Yii::$app->request->queryParams); // Get
//
//        // обработка для filter-GridView через pjax
//        if (Yii::$app->request->isPost) {
////
//            if (Yii::$app->request->post('ImageSearch') == true) {
//
//                $dataProvider = $searchModel->search(Yii::$app->request->post()); // Pjax
//                return $this->renderAjax('_gridView', [
//                    'dataProvider' => $dataProvider,
//                    'searchModel' => $searchModel,
//                    'categoryListForFilter' => $categoryListForFilter,
//                    'categoryList' => $categoryList,
//                ]);
//            }
//        }
//
//        return $this->render('index', [
//            'modelImage' => $modelImage,
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//            'categoryList' => $categoryList,
//            'categoryListForFilter' => $categoryListForFilter,
//            'openForm' => $openForm,
//            'uploadImage' => $uploadImage,
//        ]);
//    }

//    /**
//     * Displays a single images model.
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
     * Creates a new images model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($categoryId = null)
    {
        $modelImage = new Image();
        $uploadImage = new UploadImage();
        $categoryList = Category::getCategoriesList();
        $categoryListForFilter = ['' => 'Все'] + $categoryList;
        $searchModel = new ImageSearch();

        if ($modelImage->load(Yii::$app->request->post())) {
            $uploadImage->image = UploadedFile::getInstance($uploadImage, 'image');
//            var_dump($modelImage->slider_down);
//            debug($uploadImage->image);
//            debug($_POST);
//            die();

//             этот метот сохраняет изображение в папке с id категории и занимается валидацией
            if ((!empty($uploadImage->image)) && $uploadImage->upload('image', $modelImage->id_category)) {
                $modelImage->image_path = $uploadImage->image->name;
            }
            if ($modelImage->save()) {
                Yii::$app->session->setFlash('success', 'Данные приняты'); // созданние одноразовых сообщений для пользователя(хранятся в сессии)
                return $this->redirect(['/admin/category/update-category?id=' . $modelImage->id_category]);

            } else {
                Yii::$app->session->setFlash('danger', 'Ошибка записи');
                return $this->render('index', [
                    'modelImage' => $modelImage,
                    'searchModel' => $searchModel,
                    'dataProvider' => $searchModel->search([]),
                    'categoryList' => $categoryList,
                    'uploadImage' => $uploadImage,
                    'openForm' => true,
                    'categoryListForFilter' => $categoryListForFilter,
                ]);
            }

        } else {
            if (!$categoryId == null) {
                $modelImage->id_category = $categoryId;
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
     * @return mixed
     */
    public function actionUpdateCategory()
    {

        $modelImage = new Image();
        $categoryList = Category::getCategoriesList();

        if (Yii::$app->request->isAjax && $modelImage->load(Yii::$app->request->post())) {
            $model = Image::findOne($modelImage->id);

            // обновляет категорию если она изменилась
            if (($modelImage->id_category != $model->id_category)) {
                $old_path = Yii::getAlias('@uploads') . '/images/' . $model->id_category . '/' . $model->image_path;
                $new_path = Yii::getAlias('@uploads') . '/images/' . $modelImage->id_category . '/' . $model->image_path;
                if (!file_exists(Yii::getAlias('@uploads') . '/images/' . $modelImage->id_category . '/')) {
                    mkdir(Yii::getAlias('@uploads') . "/images/{$modelImage->id_category}", 0775, true);
                }
                if (rename($old_path, $new_path)) { // если перемещение прошло успешно, перезаписываем в базе
                    $model->id_category = $modelImage->id_category;
                    $model->update();
                }
//                else {
//                    $modelImage->addError('id_category', 'ошибка записи');
//                }
            }
        }
        // если был ajax запрос то возвращаем форму
        if (Yii::$app->request->isAjax) {
            return $this->renderPartial('_updateForm', [
                'modelImage' => $modelImage,
                'categoryList' => $categoryList,
            ], false, true);
        }
        // если был post просто пост запрос то редирект
        return $this->redirect(['/admin/image']);
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
        return $this->redirect(Yii::$app->request->getReferrer());
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

    public function actionEditSlider()
    {
        if (Yii::$app->request->isAjax){
            $modelImage = Image::findOne(Yii::$app->request->post('image_id'));
            $column=Yii::$app->request->post('name');
            $value=(Yii::$app->request->post('value')==1)? 0:1;
            $modelImage->$column=$value;
            if ($modelImage->update()){
                Yii::$app->response->format = Response::FORMAT_JSON;
                $data = ['value'=>$value,'status'=>true ];
                return $data;
            }
        }
        return false;
    }

    // обновляем name for slider
    public function actionUpdateName()
    {
        $modelImage = new Image();

        if (Yii::$app->request->isAjax && $modelImage->load(Yii::$app->request->post())) {
            $model = Image::findOne($modelImage->id);

            // обновляет категорию если она изменилась
            if (($modelImage->name_for_slider != $model->name_for_slider)) {
                $model->name_for_slider = $modelImage->name_for_slider;
                $model->update();
            }

            return $this->renderPartial('_updateNameForm', [
                'modelImage' => $model
            ], false, true);
        }
        return false;
    }
}
