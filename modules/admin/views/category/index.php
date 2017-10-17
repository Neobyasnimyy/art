<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории галереи';
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <p>
        <?= Html::a('Добавить категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php \yii\widgets\Pjax::begin(['id' => 'some-id-you-like',
        'timeout' => false,
        'enablePushState' => false,
        'clientOptions' => ['method' => 'POST']]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['attribute' => 'name',
                'format'=> 'html',
                'value' => function($data){
                    return Html::a($data->name,Url::toRoute(['category/view', 'id' => $data->id]));
                },
            ],
            [
                'attribute' => 'genre',
                'filter'=>\app\models\Category::getGenreList(),
                'value' => 'genre',
                'headerOptions' => ['width' => '200'],
            ],

            [
                'attribute' => 'description',
                'format'=> 'raw',
                'contentOptions' => ['class' => 'cell_class', 'style' => [

                ]],
                'content' => function ($data) {
                    $text = $data->description;
                    if (strlen($text) > 200) {
                        return Html::tag('div', substr($text, 0, 200) . '...', ['class' => ['div_class'], 'style' => [
                            // свойства каждого div
                        ]]);
                    } else {
                        return Html::tag('div', $data->description, ['class' => ['div_class'], 'style' => [
                            // свойства каждого div
                        ]]);
                    }

                },

            ],
            [
                'attribute' => 'is_active',
//                'value' => 'isActive',
//                'filter' => array('' => 'Все', "1" => "Вкл", "0" => "Выкл"),
                'filter' =>\app\models\Category::getStatusList(),
                'value'=>'status',
            ],

            [
                'class' => 'yii\grid\ActionColumn',
//                'header'=>'Действия',
//                'headerOptions' => ['width' => '80'],
                'template' => '{view} {update} {delete}{addImage}',
                'buttons' => [
                    'addImage' => function ($url, $model, $key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-plus"><span class="glyphicon glyphicon-picture"></span></span>',
                            Url::toRoute(['image/create', 'category' => $key]));
                    },
                ],
            ],
        ],
    ]); ?>

    <?php \yii\widgets\Pjax::end(); ?>

</div>
