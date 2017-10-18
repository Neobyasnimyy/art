<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>


<div class="_div_updateRoleForm">

    <?php $form = ActiveForm::begin([
        'id' => "_updateRoleForm-{$modelUser->id}",
        'action' => ['update'],
        'fieldConfig' => [
            'template' => "{input}",
        ],
//        'enableClientValidation' => true, // проверка на стороне клиента полностью,
        'method' => 'post',
        'options' => [
            'class'=>'_updateRoleForm',
//            'data-pjax' => 0,
        ],
    ]); ?>


<!--    --><?php //echo $form->field($modelUser, 'role')->dropDownList(['user'=>'user','admin'=>'admin'],['style
//'=>'background-color: #eee;'])->label(false); ?>

    <?php echo Html::activeDropDownList($modelUser, 'role',['user'=>'user','admin'=>'admin'],['class'=>'form-control','style
'=>'background-color: #eee;'])?>

    <?php echo Html::input('number','User[id]',$modelUser->id,['style'=>'display: none;'])?>


    <?php ActiveForm::end(); ?>

</div>