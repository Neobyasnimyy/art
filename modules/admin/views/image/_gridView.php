<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php \yii\widgets\Pjax::begin(['id' => 'filter-GridView',
    'timeout' => 5000,
    'enablePushState' => false, // подменять ли Url
    'clientOptions' => ['method' => 'POST'],
    'options' => [
//        'data-pjax' => true,
    ],
]); ?>

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
            'format' => 'raw', // Возможные варианты: raw, html

//                'value' => 'category.name',
            'value' => function ($data) use ($categoryList) {
                return $this->render('_updateForm', [
                    'modelImage' => $data,
                    'categoryList' => $categoryList,
                ]);
            },
//                'headerOptions' => ['width' => '200'],
            'filter' => Html::dropDownList('ImageSearch[id_category]', $searchModel->id_category, $categoryListForFilter, ['class' => 'form-control']),
//                'filter' => $categoryList,
        ],
        'image_path',
        [
            'headerOptions' => ['width' => '160'],
            'label' => 'Картинка',
            'format' => 'raw',
            'value' => function ($data) {
                return Html::a((Html::img('/'.$data->imagePath, [
                    'alt' => 'Изображение отсутствует',
                    'style' => 'width:150px;'
                ])), ['/'.$data->imagePath], ['class' => '','data-pjax'=>"0"]);

            },
        ],

        ['class' => 'yii\grid\ActionColumn',
//            'header' => 'Действия',
//            'headerOptions' => ['width' => '80'],
            'template' => '{delete}',
        ],
    ],
]); ?>


<?php \yii\widgets\Pjax::end(); ?>
