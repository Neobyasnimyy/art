<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categories-form">

    <?php $form = ActiveForm::begin(['method' => 'post']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'genre')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'description')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'plugins' => [
                'clips',
                'fullscreen'
            ],
        ]
    ]);?>
    <?= $form->field($model, 'is_active')->dropDownList(\app\models\Category::getStatusList(), (isset($status))?['value'=>'1']:[]) ?>

    <div class="form-group">
        <?= Html::a('Вернутся к списку категорий', ['/admin/category'], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' =>  'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
