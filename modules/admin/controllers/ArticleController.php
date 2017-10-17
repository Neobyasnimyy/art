<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Article;
use app\models\ArticleSearch;
use yii\base\DynamicModel;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadImage;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\helpers\Url;
/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends AppAdminController
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
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModelArticle = new ArticleSearch();
        $modelArticle = new Article();
        $uploadImageArticle = new UploadImage();
        $dataProviderArticle = $searchModelArticle->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModelArticle' => $searchModelArticle,
            'dataProviderArticle' => $dataProviderArticle,
            'modelArticle'=>$modelArticle,
            'uploadImageArticle' => $uploadImageArticle,
            'openFormArticle' => false,
        ]);
    }

    /**
     * Displays a single Article model.
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
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelArticle = new Article();
        $uploadImageArticle = new UploadImage();
        $searchModelArticle = new ArticleSearch();
        $dataProviderArticle = $searchModelArticle->search(Yii::$app->request->queryParams);


        if ($modelArticle->load(Yii::$app->request->post())) { //
            $uploadImageArticle->image = UploadedFile::getInstance($uploadImageArticle, 'image');

//             этот метот сохраняет изображение в папке с id категории и занимается валидацией
            if ($uploadImageArticle->validate() && $uploadImageArticle->upload('article')) {

                $modelArticle->image_name = $uploadImageArticle->image->name;
                $modelArticle->save();
                Yii::$app->session->setFlash('success', 'Данные приняты'); // созданние одноразовых сообщений для пользователя(хранятся в сессии)
                return $this->redirect(['/admin/article']);
            }
            Yii::$app->session->setFlash('danger', 'Ошибка записи');
            $openFormArticle=true;
            return $this->render('index', [
                'modelArticle' => $modelArticle,
                'searchModelArticle' => $searchModelArticle,
                'dataProviderArticle' => $dataProviderArticle,
                'UploadImageArticle' => $uploadImageArticle,
                'openFormArticle' => $openFormArticle,
            ]);

        } else
            {
                return $this->redirect('/admin/article');
        }

//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $uploadImageArticle = new UploadImage();
        $modelArticle = $this->findModel($id);


        if (Yii::$app->request->post('Article')==true){
            if ($modelArticle->load(Yii::$app->request->post()) && $modelArticle->validate()) {
//        debug($_FILES);
//        die();
                if ($uploadImageArticle->image = UploadedFile::getInstance($uploadImageArticle, 'image')){
                    $oldImageName = $modelArticle->image_name;
                    if ($uploadImageArticle->upload('article')) {
                        $modelArticle->image_name= $uploadImageArticle->image->name;
                        if ($oldImageName!=null){
                            myDelete(Yii::getAlias('@uploads') . '/article/' . $oldImageName); // удаляем изображение с сервера
                        }
                    }
                }

                $modelArticle->update();
                Yii::$app->session->setFlash('success', 'Данные сохранены'); // созданние одноразовых сообщений для пользователя(хранятся в сессии)
                return $this->redirect(['/admin/article']);
            }else{
                // вывод ошибок
            }
        }elseif (Yii::$app->request->post('Image')==true){

        }


        return $this->render('update', [
                'modelArticle' => $modelArticle,
                'uploadImageArticle' =>$uploadImageArticle,
            ]);

//        if ($modelArticle->load(Yii::$app->request->post()) && $modelArticle->save()) {
//
//            return $this->redirect(['view', 'id' => $modelArticle->id]);
//        } else {
//            return $this->render('update', [
//                'modelArticle' => $modelArticle,
//                'uploadImageArticle' =>$uploadImageArticle,
//            ]);
//        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



}
