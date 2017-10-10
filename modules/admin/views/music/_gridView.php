<?php

use yii\grid\GridView;
use yii\helpers\Url;
?>

<?php \yii\widgets\Pjax::begin(['id' => 'GridViewMusic',
    'timeout' => 5000,
    'enablePushState' => false,
    'clientOptions' => ['method' => 'Post']]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'filterUrl'=> ['pjax-index'],

    'columns' => [

        'id',
        'file_name',
//            'name',
        [
            'attribute' => 'name',
            'format' => 'raw',
//                'contentOptions' => ['style' => 'background-color:red; height:50px;'],
            'value'=>function($data){
                return $this->render('_updateForm', [
                    'modelMusic' => $data,
                ]);
            }

        ],
        [
//                'attribute' => 'name',
//                'headerOptions' => ['width' => '160'],
            'label' => 'Прослушать',
            'format' => 'raw',
            'value' => function ($data) {
                return "<audio controls>
                              <source src='/web/uploads/music/{$data->file_name}' type='{$data->type}'>
                            Ваш браузер не поддерживает аудио элемент.
                            </audio>";
            },
        ],
        'type',

        ['class' => 'yii\grid\ActionColumn',
//                'header' => 'Действия',
            'template' => '{delete}',

        ],
    ],
]); ?>

<?php \yii\widgets\Pjax::end(); ?>
