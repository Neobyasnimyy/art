<?php

use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Html;

?>


<?php \yii\widgets\Pjax::begin(['id' => "pjax-id-$article->id",
    'timeout' => 5000,
//            'enablePushState' => true,
    'clientOptions' => ['method' => 'post'],
    'options' => [
        'data-pjax' => true,
    ]]); ?>

<?php $form = ActiveForm::begin([
    'id' => "article-form-id-$article->id",
    'enableAjaxValidation' => true,
    'enableClientValidation' => true, // проверка на стороне клиента полностью,
    'method' => 'post',
    'action' => ['update', 'id' => $article->id],
    'options' => [
        'class' => 'form-article _div_updateForm',
        'data-id' => $article->id,
    ],
]); ?>


<div class="col-md-1">
    <div class="form-control-static"><?php echo $article->id ?></div>
</div>

<div class="col-md-2" style=""><?php
    //                    if($article->data) {
    //                        $article->data = date("yyyy-mm-dd", (integer) $article->data);
    //                    }
    echo $form->field($article, 'data')->label(false)->widget(DatePicker::className(), [
        'type' => 2,
//            'options' => ['placeholder' => 'Ввод даты ...'],
        'value' => date("yyyy-mm-dd", (integer)$article->data),
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'autoclose' => true,
            'todayHighlight' => true,// подсвечивает сегодняшнюю дату
//            'startView'=>2, // сначало выбираем год => 2
            'weekStart' => 1, //неделя начинается с понедельника
//            'startDate' => '01.05.2015 00:00', //самая ранняя возможная дата
            'todayBtn' => 'linked', //снизу кнопка "сегодня"
        ]

    ]); ?>

</div>

<div class="col-md-4">
    <?= $form->field($article, 'title')->textInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($article, 'description')->textarea(['rows' => 6, 'cols' => 70]) ?>
</div>

<div class="col-md-2"><?php
    echo Html::img('/' . $article->image, [
        'alt' => 'Изображение отсутствует',
//            'style' => 'width:200px;',
        'class' => 'img-responsive center-block img-thumbnail',
    ]); ?>

</div>


<div class="col-md-1">
    <?= $form->field($article, 'is_active')->radioList([
        '0' => 'off',
        '1' => 'on',
    ])->label(false);

     ActiveForm::end();
     \yii\widgets\Pjax::end(); ?>
    </div>

<div class="col-md-2">
    <div class="form-group">
<!--        --><?php //echo Html::submitButton('Сохранить', ['class' => 'btn btn-success',]) ?>
        <?php $formUp = ActiveForm::begin([
            'id' => "formUp-id-$article->id",
//            'enableAjaxValidation' => true,
//            'enableClientValidation' => true, // проверка на стороне клиента полностью,
            'method' => 'post',
            'action' => ['update', 'id' => $article->id],
            'options' => [
                'enctype' => 'multipart/form-data',
                'class' => 'form-article _div_updateImage',
                'data-id' => $article->id,
                'data-pjax'=>0,
            ],
        ]);
        echo $formUp->field($uploadImage, 'image')->fileInput([
            'data-pjax'=>0,
            'class' => "button-$article->id filestyle",
            'style' => 'display: block;',
            'data-buttonText' => 'New Image',
            'data-buttonName' => "btn-primary",
//                        'data-placeholder' => $modelImage->image_path,
        ])->label(false);


        echo Html::submitButton('Загрузить', ['class' => 'buttonAddImage btn btn-success ',
            'for'=>'formUp-id-$article->id',
//            'data-button-click' => "button-$article->id",
            'style' => '']);
        ActiveForm::end();  ?>

    </div>
</div>




