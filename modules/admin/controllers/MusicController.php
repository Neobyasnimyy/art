<?php


namespace app\modules\admin\controllers;

use app\models\UploadMusic;
use Yii;
use app\models\Music;
use app\models\MusicSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;


/**
 * MusicController implements the CRUD actions for Music model.
 */
class MusicController extends AppAdminController
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
     * Lists all Music models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MusicSearch();
        $modelMusic = new Music();
        $uploadMusic = new UploadMusic();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $openForm = false;

        if (Yii::$app->request->isAjax && $modelMusic->Load(Yii::$app->request->post())) {
            Yii::$app->response->format = 'json';
            return ActiveForm::validate($modelMusic);
        }

        if ($modelMusic->load(Yii::$app->request->post()) and $modelMusic->validate(['name'])) {
            $uploadMusic->file = UploadedFile::getInstance($uploadMusic, 'file');
            $newFileName = translit($modelMusic->name);
            $uploadMusic->upload($newFileName); // этот метот сохраняет музыку на сервере и занимается валидацией

            $modelMusic->file_name = $newFileName . '.' . $uploadMusic->file->extension;
            $modelMusic->type = $uploadMusic->file->type;
            if ($modelMusic->save()) {
                Yii::$app->session->setFlash('success', 'Данные сохранены'); // созданние одноразовых сообщений для пользователя(хранятся в сессии)
                return $this->redirect(['index']);
            }
//            return $this->redirect(['view', 'id' => $model->id]);
        }
        if (empty(!$modelMusic->errors)) {
            $openForm = true; // оставляем открытую форму
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelMusic' => $modelMusic,
            'uploadMusic' => $uploadMusic,
            'openForm' => $openForm,
        ]);
    }


    /**
     * Updates an existing Music model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $modelMusic = new Music();

        if (Yii::$app->request->isAjax && $modelMusic->load(Yii::$app->request->post())) {

            $model = Music::findOne($modelMusic->id);
            // обновляет имя если оно изменилось
            if (($modelMusic->name != $model->name)) {
                $model->name = $modelMusic->name;
                $model->update();
            }
            return $this->render('_updateForm', [
                'modelMusic' => $modelMusic,
            ]);
        }
    }

    public function actionAjaxValidateName()
    {
        $modelMusic = new Music();

        if (Yii::$app->request->isAjax && $modelMusic->Load(Yii::$app->request->post())) {
            Yii::$app->response->format = 'json';
            $model = $this->findModel($modelMusic->id);
            if ($modelMusic->name != $model->name) {
                return ActiveForm::validate($modelMusic);
            }
        }
    }

    /**
     * Deletes an existing Music model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $item = $this->findModel($id);
        myDelete(Yii::getAlias('@uploads') . '/music/' . $item->file_name); // удаляем изображение с сервера
        $item->delete();  // удаляем запись из базы данных
        Yii::$app->session->setFlash('success', 'Удаление прошло успешно'); // созданние одноразовых сообщений для пользователя(хранятся в сессии)

        return $this->redirect(['index']);
    }

    /**
     * Finds the Music model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Music the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Music::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}