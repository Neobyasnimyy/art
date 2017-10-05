<?php

use yii\helpers\Html;
use yii\grid\GridView;

use yii\widgets\ActiveForm;

//начало многосточной строки, можно использовать любые кавычки
$script = <<< JS
    $('#openFormNewMusic').click(function () {
        $('#addMusic').toggle(); //тогл это переключатель, если display block он сделает none  и наоборот
    });
        
    
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);

//при изменении названиия файла, запичываем в базу данных
$js = <<< JS
    $('.music-name-edit input[name="Music[name]"]').blur(function () {
         $(this).parents('form').find('button').click();
    });
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($js, yii\web\View::POS_READY);

/* @var $this yii\web\View */
/* @var $searchModel app\models\MusicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Музыка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="music-index">

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= Html::submitButton('Добавить Композицию', ['id' => 'openFormNewMusic', 'class' => 'btn btn-primary']) ?>

    <div id="addMusic" style="display: <?php echo ($openForm) ? 'block' : 'none' ;?>">
        <?= $this->render('_form', [
            'modelMusic' => $modelMusic,
            'uploadMusic' => $uploadMusic
        ]) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
</div>