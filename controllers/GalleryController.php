<?php

namespace app\controllers;
use app\models\Category;
use app\models\Image;
use yii\data\Pagination;

class GalleryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $images = Image::find()->select(['id','id_category','image_path'])->groupBy('id_category')->all();
        // выполняем запрос
        $query = Category::find()->select(['categories.id','name','genre'])->with([
            'images' => function (\yii\db\ActiveQuery $queryy) {
                $queryy->select(['id','id_category', 'image_path'])->addGroupBy(['id_category']);
            }
        ])->where('is_active=1');
        // делаем копию выборки
        $countQuery = clone $query;
        // подключаем класс Pagination, выводим по 3 пунктов на страницу
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        // приводим параметры в ссылке к ЧПУ
        $pages->pageSizeParam = false;
        $modelGallery = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        // Передаем данные в представление
        return $this->render('index', [
            'modelGallery' => $modelGallery,
            'pages' => $pages,
            'images'=>$images,
        ]);
    }

    /**
     * Displays a single Gategories model with Images model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (($modelCategory = Category::find()->where("id={$id}")->one()) !== null) {
            $modelImages=Image::find()->where("id_category={$id}")->asArray()->all();

            return $this->render('view', [
                'modelCategory' => $modelCategory,
                'modelImages'=>$modelImages,
            ]);
        }else{
            return $this->redirect('/gallery');
        }


    }

}
