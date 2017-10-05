<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Category;
use yii\helpers\Url;
use app\models\Image;
use yii\helpers\ArrayHelper;
// подключаем виджет постраничной разбивки
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Изображения';
$this->params['breadcrumbs'][] = $this->title;
//debug($categoryList);
?>
<div class="images-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить изображение', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \yii\widgets\Pjax::begin(['id' => 'some-id-you-like',
        'timeout' => false,
        'enablePushState' => false,
        'clientOptions' => ['method' => 'POST']]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
//        'viewParams' => [
//            '$categoryList' => $categoryList,
//        ],
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'value' => 'id',
                'headerOptions' => ['width' => '50'],
            ],
            [
                'attribute' => 'id_category',
                'label' => 'Категория',
                'format' => 'text', // Возможные варианты: raw, html
//                'content' => function($data){
//                    return Html::dropDownList('id_category', $data->id_category, Category::getCategoriesList(),['class' => 'form-control']);
//                },
                'value' => 'category.name',
                'headerOptions' => ['width' => '200'],
                'filter'=>Html::dropDownList('ImageSearch[id_category]', $searchModel->id_category,$categoryList,['class'=>'form-control'] ),
//                'filter' => $categoryList,
            ],
            'image_path',
            [
                'headerOptions' => ['width' => '160'],
                'label' => 'Картинка',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::img('/'.$data->imagePath, [
                        'alt' => 'Изображение отсутствует',
                        'style' => 'width:150px;'
                    ]);
                },
            ],

            ['class' => 'yii\grid\ActionColumn',
                'header' => 'Действия',
                'headerOptions' => ['width' => '80'],
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>


    <?php \yii\widgets\Pjax::end(); ?>

</div>
