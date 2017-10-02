<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Image */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="images-form">

    <?php $form = ActiveForm::begin([
        'id' => 'image-form',
        'enableClientValidation' => true, // проверка на стороне клиента полностью,
        'method' => 'post',
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?php

    $params = [
        'prompt' => 'Укажите категорию'
    ];
    echo $form->field($modelImage, 'id_category')->dropDownList($categoryList, $params); ?>

    <?php
    if (isset($modelImage->image_path) and isset($modelImage->id_category)) {
        echo Html::img(Url::toRoute($modelImage->imagePath), [
            'alt' => 'Изображение отсутствует',
            'style' => 'width:300px;',
            'class' => 'img-responsive center-block img-thumbnail',
        ]);
        echo $form->field($uploadImage, 'image')->fileInput([
            'class' => 'filestyle',
            'data-buttonText' => ' Заменить...',
            'data-buttonName' => "btn-primary",
            'data-placeholder' => $modelImage->image_path,
        ]);
    } else {
        echo $form->field($uploadImage, 'image')->fileInput([
            'class' => 'filestyle',
            'data-buttonText' => 'Выберите изображение',
            'data-buttonName' => "btn-primary",
            'data-placeholder' => "Файла нет",
            'required'=>true,
        ]);
    }
    ?>


    <div class="form-group">
        <?= Html::a('Вернутся к списку изображений', ['/admin/image'], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton($modelImage->isNewRecord ? 'Добавить' : 'Изменить', ['class' => 'btn btn-success pull-right']) ?>
        <?php if (isset($modelImage->image_path)) {
            echo Html::a('Delete', ['delete', 'id' => $modelImage->id], [
                'class' => 'btn btn-danger pull-right',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить изображение?',
                    'method' => 'post',
                ],
            ]);
        } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
