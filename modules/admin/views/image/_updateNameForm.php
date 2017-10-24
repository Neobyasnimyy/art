<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>


    <div class="_div_updateNameForm">

        <?php $form = ActiveForm::begin([
            'id' => "_updateNameForm-{$modelImage->id}",
//            'action' => ['update-category'],
            'enableClientValidation' => true, // проверка на стороне клиента полностью,
            'method' => 'post',
            'options' => [
                'class'=>'_updateNameForm',
//            'data-pjax' => 0,
            ],
        ]); ?>

        <?= $form->field($modelImage, 'name_for_slider')
            ->label(false)
            ->textInput(['style'=>'background-color: #eee;']); ?>

        <?= $form->field($modelImage, 'id')->label(false)->hiddenInput(); ?>

        <?php ActiveForm::end(); ?>

    </div>



