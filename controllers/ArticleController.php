<?php

namespace app\controllers;

use app\models\Article;
use app\models\ArticleSearch;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class ArticleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        // выполняем запрос
        $query = Article::find()->where('is_active=1')->orderBy(['data'=>SORT_DESC]);
        // делаем копию выборки
        $countQuery = clone $query;
        // подключаем класс Pagination, выводим по 3 пунктов на страницу
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 3]);
        // приводим параметры в ссылке к ЧПУ
        $pages->pageSizeParam = false;
        $modelArticle = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        // Передаем данные в представление
        return $this->render('index', [
            'modelArticle' => $modelArticle,
            'pages' => $pages,
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
            'modelArticle' => $this->findModel($id),
        ]);
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