<?php


namespace app\modules\admin\controllers;

use yii\base\DynamicModel;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\helpers\FileHelper;
use vova07\imperavi\actions\GetAction;
use yii\image\drivers\Image;

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
                ],
                [
                    'action' => ['save-redactor-img'],
                    'allow' => true,
                    'roles' => ['@']
                ]
            ]
        ];
    }

    // метод для виджета yurkinx/yii2-image, сохраняет картинку
    public function actionSaveRedactorImg($sub = 'imperavi')
    {
        $this->enableCsrfValidation = false;
        if (Yii::$app->request->isPost) {
            $dir = Yii::getAlias('@uploads') . '/' . $sub . '/';
            if (!file_exists($dir)) {
                FileHelper::createDirectory($dir);
            }
            $resultLink = str_replace('admin', '', Url::Home(true) . 'web/uploads/' . $sub . '/');
            $file = UploadedFile::getInstanceByName('file');
            $model = new DynamicModel(compact('file'));
            $model->addRule('file', 'image')->validate();

            if ($model->hasErrors()) {
                $result = [
                    'error' => $model->getFirstError('file')
                ];
            } else {
                $model->file->name = rand(0, 9999) . "-" . date('YmdHi', time()) . '.' . $model->file->extension;
                if ($model->file->saveAs($dir . $model->file->name)) {
                    $image = Yii::$app->image->load($dir.$model->file->name);
                    $image->resize(800,null, Image::PRECISE)
                    ->save($dir.$model->file->name,85);// 800 ширина и как получится по высоте, качество 85 %
                    $result = ['filelink' => $resultLink . $model->file->name,
                        'filename' => $model->file->name];
                } else {
                    $result = [
                        'error' => 'Невозможно загрузить файл'
                    ];
                }
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $result;
        } else {
            throw new BadRequestHttpException('Only Post is allower');
        }
    }


    // необходими решить проблему для удаления картинок из визуального редактора и из сервера

    //для визуального редактора
    public function actions()
    {
        return [
            //для вставки уже загруженных изображений
            'images-get' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url' => '/web/uploads/imperavi/', // URL адрес папки где хранятся изображения.
                'path' => Yii::getAlias('@uploads') . '/imperavi', // Или абсолютный путь к папке с изображениями.
                'type' => GetAction::TYPE_IMAGES,
            ],

        ];
    }

}