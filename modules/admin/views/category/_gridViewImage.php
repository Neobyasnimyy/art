<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<?php \yii\widgets\Pjax::begin(['id' => 'filter-GridView',
    'timeout' => 5000,
    'enablePushState' => true, // подменять ли Url
    'options' => [
//        'data-pjax' => true,
    ],
]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProviderImage,
    'filterModel' => $searchModelImage,
    'layout' => "{summary}\n{items}",

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
            'value' => function ($data) use ($categoryList) {
                return $this->render('/image/_updateForm', [
                    'modelImage' => $data,
                    'categoryList' => $categoryList,
                ]);
            },
//                'headerOptions' => ['width' => '200'],
            'filter' => Html::dropDownList('ImageSearch[id_category]', $searchModelImage->id_category, $categoryListForFilter, ['class' => 'form-control']),
//                'filter' => $categoryList,
        ],
        [
            'attribute' => 'name_for_slider',
            'format' => 'raw',
            'value' => function ($data) {
                return $this->render('/image/_updateNameForm', [
                    'modelImage' => $data,
                ]);
            },
        ],
        [
            'attribute' => 'slider_up',
            'format' => 'raw',
            'filter' => Html::dropDownList('ImageSearch[slider_up]', $searchModelImage->slider_up, ['' => 'Все', 0 => 'Отключен', 1 => 'Активный',], ['class' => 'form-control']),
            'value' => function ($data) {
                $icon = ($data->slider_up == 1) ? 'glyphicon glyphicon-ok' : 'glyphicon glyphicon-remove';
                return Html::tag('span', '',
                    ['class' => $icon,
                        'data-name' => 'slider_up',
                        'data-id' => $data->id,
                        'data-value' => $data->slider_up]);
            },
        ],
        [
            'attribute' => 'slider_down',
            'format' => 'raw',
            'filter' => Html::dropDownList('ImageSearch[slider_down]',
                $searchModelImage->slider_down,
                ['' => 'Все',
                    0 => 'Отключен',
                    1 => 'Активный'],
                ['class' => 'form-control']),
            'value' => function ($data) {
                $icon = ($data->slider_down == 1) ? 'glyphicon glyphicon-ok' : 'glyphicon glyphicon-remove';
                return Html::tag('span', '',
                    ['class' => $icon,
                        'data-name' => 'slider_down',
                        'data-id' => $data->id,
                        'data-value' => $data->slider_down]);
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
            'urlCreator' => function ($action, $model, $key, $index) {
                return \yii\helpers\Url::to(['/admin/image/' . $action . '', 'id' => $model->id]);

            }
        ],
    ],
]); ?>

<div class="text-center">
    <?php echo LinkPager::widget([
        'pagination' => $dataProviderImage->pagination,
    ]); ?>
</div>

<?php \yii\widgets\Pjax::end(); ?>
