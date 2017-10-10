<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Image */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
//$this->registerJs(
//    '$("document").ready(function(){
//            $("#addImagePjax").on("pjax:end", function() {
//            console.log("bybe");
////            $.pjax.reload({container:"#notes"});  //Reload GridView
//        });
//    });'
//);
?>



<?php $form = ActiveForm::begin([
    'id' => 'image-form',
    'enableClientValidation' => true, // проверка на стороне клиента полностью,
    'method' => 'post',
    'action'=>['create'],
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>

<?php

$params = [
    'prompt' => 'Укажите категорию'
];
echo $form->field($modelImage, 'id_category')->dropDownList($categoryList, $params); ?>

<?php

echo $form->field($uploadImage, 'image')->fileInput([
    'class' => 'filestyle',
    'data-buttonText' => 'Выберите изображение',
    'data-buttonName' => "btn-primary",
    'data-placeholder' => "Файла нет",
    'required' => true,
]);
?>


<?= Html::submitButton('Добавить', ['class' => 'btn btn-success pull-right']) ?>


<?php ActiveForm::end(); ?>


