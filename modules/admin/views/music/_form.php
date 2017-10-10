<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $modelMusic app\models\Music */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="music-form">

    <?php $form = ActiveForm::begin([
        'id' => 'music-form',
//        'action' => ['index'],
        'enableAjaxValidation' => true,
        'enableClientValidation' => true, // проверка на стороне клиента полностью,
        'method' => 'post',
        'options' => [
            'enctype' => 'multipart/form-data',
//            'class' => 'col-md-4'
        ],
//        'class' => 'fff',
    ]); ?>

    <?= $form->field($modelMusic, 'name')->textInput(['enableAjaxValidation' => true, 'maxlength' => true, 'style' => 'width:300px']) ?>

    <?= $form->field($uploadMusic, 'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
