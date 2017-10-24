<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Image */
/* @var $form yii\widgets\ActiveForm */
?>



    <?php $form = ActiveForm::begin([
        'id' => 'image-form',
        'enableClientValidation' => true, // проверка на стороне клиента полностью,
        'method' => 'post',
        'action' => ['create'],
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?php
    $params = [
        'prompt' => 'Укажите категорию'
    ];
    echo $form->field($modelImage, 'id_category')->dropDownList($categoryList, $params); ?>

    <?php echo $form->field($modelImage, 'name_for_slider')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-md-3">
            <b >Добавить в:</b>
        </div>
        <div class="col-md-4">
            <?php echo $form->field($modelImage, 'slider_up')->checkbox(['uncheck' => 0, 'checked' => 1], true) ?>

            <?php echo $form->field($modelImage, 'slider_down')->checkbox(['uncheck' => 0, 'checked' => 1], true) ?>

        </div>

    </div>

    <?php

    $pluginOptions=[
        'allowedFileExtensions'=>['jpg', 'gif', 'png', 'bmp'],
        'overwriteInitial' => true, // перезаписывает данные которые мы ему передали при инициализации
        'showPreview' => true,
        'showCaption' => true,
        'showRemove' => false,
        'showUpload' => false,
    ];


    echo $form->field($uploadImage, 'image')->label('Изображение')->widget(FileInput::classname(), [
        'language' => 'ru',
        'options' => [
            'accept' => 'image/*',
            'required'=>'required',
        ],
        'pluginOptions' => $pluginOptions
    ]); ?>

<!--    --><?php
//    echo $form->field($uploadImage, 'image')->fileInput([
//        'class' => 'filestyle',
//        'data-buttonText' => 'Выберите изображение',
//        'data-buttonName' => "btn-primary",
//        'data-placeholder' => "Файла нет",
//        'required' => true,
//    ]);?>

    <div class="form-group text-right">
    <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>


