<?php


namespace app\modules\admin\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

class appAdminController extends Controller
{
    public function beforeAction($action)
    {
        if (Yii::$app->user->identity['role'] == 'user') {
            return $this->goHome();
        }
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    'allow' => true,
                    'roles' => ['@']
                ]
            ]
        ];
    }

}