<?php

namespace app\controllers;

use app\models\Article;
use app\models\ArticleSearch;

class ArticleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $modelArticle = Article::find()->all();

        return $this->render('index',['modelArticle'=>$modelArticle]);
    }

}