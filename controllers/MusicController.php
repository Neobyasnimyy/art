<?php

namespace app\controllers;

use app\models\Music;
use app\models\MusicSearch;

class MusicController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $modelMusic = Music::find()->all();

        return $this->render('index',['modelMusic'=>$modelMusic]);
    }

}
