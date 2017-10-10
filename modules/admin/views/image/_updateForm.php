<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>


    <div class="_div_updateForm">

        <?php $form = ActiveForm::begin([
            'id' => "_updateForm-{$modelImage->id}",
        'action' => ['update'],
            'enableClientValidation' => true, // проверка на стороне клиента полностью,
            'method' => 'post',
            'options' => [
                'class'=>'_updateForm',
//            'data-pjax' => 0,
            ],
        ]); ?>


        <?php echo $form->field($modelImage, 'id_category')->dropDownList($categoryList,['style
'=>'background-color: #eee;'])->label(false); ?>

        <?= $form->field($modelImage, 'id')->label(false)->hiddenInput(); ?>

<!--        --><?php //echo Html::submitButton( 'Изменить', [
//            'class' => 'btn btn-success pull-right',
//            'form'=>"_updateForm-{$modelImage->id}",
//        ]) ?>

        <?php ActiveForm::end(); ?>

    </div>



