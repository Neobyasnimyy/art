<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $modelMusic app\models\Music */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="_div_updateForm">

    <?php $form = ActiveForm::begin([
        'id' => "music-form-{$modelMusic->id}",
        'action' => ['update'],
//    'enableAjaxValidation' => true,
        'enableClientValidation' => true, // проверка на стороне клиента полностью,
//    'validationUrl' => ['ajax-validate-name'],
        'method' => 'post',
        'options' => [
            'class' => '_updateForm',
        ],
    ]); ?>


    <?= $form->field($modelMusic, 'name')->textInput([
        'enableAjaxValidation' => true,
        'maxlength' => true,
        'style' => 'background-color: #eee;'
    ])->label(false); ?>

    <?= $form->field($modelMusic, 'id')->label(false)->hiddenInput(); ?>

    <?php //echo Html::submitButton('Сохранить', ['class' => 'btn btn-success ', 'style' => 'display:none;']); ?>

    <?php ActiveForm::end(); ?>

</div>

