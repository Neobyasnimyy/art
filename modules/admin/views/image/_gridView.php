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
    'layout' => "{items}\n{pager}",

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
        'name_for_slider',
        [
            'attribute' => 'slider_up',
            'format' => 'raw',
            'filter' => Html::dropDownList('ImageSearch[slider_up]', $searchModel->slider_up, [''=>'Все',0=>'Отключен',1=>'Активный',], ['class' => 'form-control']),
            'value' => function ($data) {
                $icon=($data->slider_up==1)?'glyphicon glyphicon-ok':'glyphicon glyphicon-remove';
                return Html::tag('span', '', ['class' => $icon]);
            },
        ],
        [
            'attribute' => 'slider_down',
            'format' => 'raw',
            'filter' => Html::dropDownList('ImageSearch[slider_down]', $searchModel->slider_down, [''=>'Все',0=>'Отключен',1=>'Активный',], ['class' => 'form-control']),
            'value' => function ($data) {
                $icon=($data->slider_down==1)?'glyphicon glyphicon-ok':'glyphicon glyphicon-remove';
                return Html::tag('i', '', ['class' => $icon]);
            },
        ],
        [
            'headerOptions' => ['width' => '160'],
            'label' => 'Картинка',
            'format' => 'raw',
            'value' => function ($data) {
                return Html::a((Html::img('/' . $data->imagePath, [
                    'alt' => 'Изображение отсутствует',
                    'style' => 'width:150px;'
                ])), ['/' . $data->imagePath], ['class' => '', 'data-pjax' => "0"]);

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
