<?php

namespace app\modules\admin\controllers;

use app\models\User;
use app\models\UserSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;


class UserController extends appAdminController
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


    public function actionIndex()
    {


        $searchModelUser = new UserSearch();

        $dataProviderUser = $searchModelUser->search(Yii::$app->request->queryParams);

        $this->view->title = 'Пользователи';
        return $this->render('index', [
            'dataProviderUser' => $dataProviderUser,
            'searchModelUser' => $searchModelUser,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (($model = User::findOne($id)) !== null) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Удаление прошло успешно'); // созданние одноразовых сообщений для пользователя(хранятся в сессии)
        }

        return $this->redirect(['index']);
    }

    // обновляет права у user
    public function actionUpdate()
    {
        $modelUser = new User();
        if (Yii::$app->request->isAjax && $modelUser->load(Yii::$app->request->post())){
            $model = User::findOne($modelUser->id);

            if (!empty($model)&& ($model->role!=$modelUser->role)){
                $model->role=$modelUser->role;
                $model->update();
            }

            return $this->renderPartial('_updateRoleForm', [
                'modelUser' => $modelUser,
            ], false, true);
        }

        $this->redirect(['/admin/user']);
    }

}
