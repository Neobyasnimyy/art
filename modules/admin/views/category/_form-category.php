<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $modelCategory app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categories-form">

    <?php $form = ActiveForm::begin(['method' => 'post']); ?>

    <?= $form->field($modelCategory, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelCategory, 'genre')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($modelCategory, 'description')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 100,
            'plugins' => [
                'clips',
                'fullscreen'
            ],
        ]
    ]);?>
    <?= $form->field($modelCategory, 'is_active')->dropDownList(\app\models\Category::getStatusList(), (isset($status))?['value'=>'1']:[]) ?>

    <div class="form-group">
        <?php echo Html::a('Вернутся к списку категорий', ['/admin/category'], ['class' => 'btn btn-primary']) ?>

        <?php if (!$modelCategory->isNewRecord):?>
            <?php echo Html::a('Удалить', ['/admin/category/delete-category','id' => $modelCategory->id], ['class' => 'btn btn-danger']); ?>
            <?php echo Html::Button('Свернуть',['class' =>  'btn btn-success','id'=>'close-form-category']);?>
        <?php endif;?>

        <?php echo Html::submitButton($modelCategory->isNewRecord ? 'Создать' : 'Сохранить', ['class' =>  'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
