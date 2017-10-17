<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\widgets\LinkPager;
?>


<?php Pjax::begin(); ?>



<?= GridView::widget([
    'dataProvider' => $dataProviderArticle,
    'filterModel' => $searchModelArticle,
    'layout'=>"{summary}\n{items}",
    'columns' => [

        [
            'attribute' => 'id',
            'headerOptions' => ['width' => '40'],

        ],
        [
            'attribute' => 'data',
            'contentOptions'=>[
                'style'=>'min-width:100px;'
            ],
            'filter' => DatePicker::widget([
                'type' => DatePicker::TYPE_INPUT,
                'model'=>$searchModelArticle,
                'attribute'=>'data',
                'language' => 'ru',
                'pluginOptions' => [
                    'autoclose' => true,
                    'minViewMode'=>'months',
                    'todayHighlight' => true,// подсвечивает сегодняшнюю дату
                    'startView'=>1, // сначало выбираем год => 2
                    'format' => 'yyyy-mm',
                    'clearBtn'=>true,
                ],
            ]),

        ],

        [
            'attribute' => 'title',
            'contentOptions'=>[
                'style'=>'min-width:250px;'
            ]
        ],
        [
            'attribute' => 'description',
            'format' => 'raw',
//            'contentOptions' => ['class' => 'cell_class', 'style' => [
//            ]],
            'content' => function ($data) {
                $text = $data->description;
                if (strlen($text) > 300) {
                    return Html::tag('div', substr($text, 0, strpos ($text,' ',300)) . ' ...', ['class' => ['div_class'], 'style' => [
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
//            'headerOptions' => ['width' => '160'],
            'label' => 'Обложка',
            'format' => 'raw',
            'value' => function ($data) {
                return Html::a((Html::img( $data->image, [
                    'alt' => 'Изображение отсутствует',
                    'style' => 'width:150px;'
                ])), [ $data->image], ['class' => '', 'data-pjax' => "0"]);

            },
        ],

        [
            'attribute' => 'is_active',
            'filter' => \app\models\Article::getStatusList(),
            'value' => 'status',
        ],

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>

<div class="text-center">
    <?php echo LinkPager::widget([
        'pagination' => $dataProviderArticle->pagination,
    ]);?>
</div>


<?php Pjax::end(); ?>