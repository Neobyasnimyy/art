<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="site-login">

<!--        <h1>--><?php //echo Html::encode($this->title) ?><!--</h1>-->
        <h3>Введите данные для регистрации</h3>

        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
            'method' => 'post',

            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>

        <?php echo $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'email')->input('email'); ?>

        <?= $form->field($model, 'password')->passwordInput() ?>


        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Регистрация', ['class' => 'btn btn-success', 'name' => 'register-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

