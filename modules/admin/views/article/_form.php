<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

<!--    --><?php //echo $form->field($model, 'data')->textInput(); ?>

    <?php
    if($model->data) {
        $model->data = date("yyyy-mm-dd", (integer) $model->data);
    }
    echo $form->field($model, 'data')->widget(DatePicker::className(),[
        'type' => DatePicker::TYPE_INPUT,
        'options' => ['placeholder' => 'Ввод даты ...'],
        'value'=> date("yyyy-mm-dd",(integer) $model->data),
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'autoclose'=>true,
            'todayHighlight'=>true,// подсвечивает сегодняшнюю дату
//            'startView'=>2, // сначало выбираем год => 2
            'weekStart'=>1, //неделя начинается с понедельника
//            'startDate' => '01.05.2015 00:00', //самая ранняя возможная дата
            'todayBtn'=>'linked', //снизу кнопка "сегодня"
        ]

    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
