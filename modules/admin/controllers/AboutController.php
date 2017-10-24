<?php


namespace app\modules\admin\controllers;
use app\models\About;
use app\models\UploadImage;
use Yii;
use yii\web\UploadedFile;

class AboutController extends AppAdminController
{
    public function actionIndex()
    {
        $modelAbout=About::findOne(['id'=>1]);
        $uploadImageAbout = new UploadImage();
//        debug($_POST);
//        die();
        if (Yii::$app->request->post('About')==true){
            if ($modelAbout->load(Yii::$app->request->post()) && $modelAbout->validate()) {

                if ($uploadImageAbout->image = UploadedFile::getInstance($uploadImageAbout, 'image')){
                    $oldImageName = $modelAbout->image_name;
                    if ($uploadImageAbout->upload('about')) {
                        $modelAbout->image_name= $uploadImageAbout->image->name;
                        if ($oldImageName!=null){
                            myDelete(Yii::getAlias('@uploads') . '/about/' . $oldImageName); // удаляем изображение с сервера
                        }
                    }
                }

                $modelAbout->update();
                Yii::$app->session->setFlash('success', 'Данные сохранены'); // созданние одноразовых сообщений для пользователя(хранятся в сессии)
//                return $this->redirect(['/admin/about']);
            }
        }

        return $this->render('index',
            [
                'modelAbout' => $modelAbout,
                'uploadImageAbout' =>$uploadImageAbout,
            ]);
    }
}