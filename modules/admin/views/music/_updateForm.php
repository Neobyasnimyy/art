<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $modelMusic app\models\Music */
/* @var $form yii\widgets\ActiveForm */


?>

<?php \yii\widgets\Pjax::begin([
    'id' => "PAjax-form-music-{$modelMusic->id}",
    'timeout' => false,
    'enablePushState' => false,
    'clientOptions' => ['method' => 'POST'],
    'options' => [
    'style' => ['display'=>'inline']
    ],])
; ?>


<?php $form = ActiveForm::begin([
    'id' => "music-form-{$modelMusic->id}",
    'action' => ['update'],
    'enableAjaxValidation' => true,
    'enableClientValidation' => true, // проверка на стороне клиента полностью,
    'validationUrl' => ['ajax-validate-name'],
    'method' => 'post',
    'options' => [
        'data' => ['pjax' => true],
        'enctype' => 'multipart/form-data',
            'class' => 'music-name-edit'
    ],
]); ?>

<?= $form->field($modelMusic, 'id')->label(false)->hiddenInput(); ?>

<?= $form->field($modelMusic, 'name')->textInput(['enableAjaxValidation' => true, 'maxlength' => true])->label(false); ?>


<?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success ', 'style' => 'display:none;']); ?>

<?php ActiveForm::end(); ?>

<?php \yii\widgets\Pjax::end(); ?>


