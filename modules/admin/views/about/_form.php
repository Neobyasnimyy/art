<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Url;
use kartik\file\FileInput;

?>


<div class="col-md-7">
    <?php $form = ActiveForm::begin([
        'id' => 'about-form',
        'enableClientValidation' => true, // проверка на стороне клиента полностью,
        'method' => 'post',
        'action' => ['index'],
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>



    <?php echo $form->field($modelAbout, 'text')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 100,
            'plugins' => [
                'clips',
                'fullscreen',
                'fontsize',
                'fontcolor',
            ]
        ]
    ]); ?>



    <?php

    $pluginOptions=[
        'allowedFileExtensions'=>['jpg', 'gif', 'png', 'bmp'],
        'overwriteInitial' => true, // перезаписывает данные которые мы ему передали при инициализации
        'initialCaption'=> $modelAbout->image_name,
        'showPreview' => true,
        'showCaption' => true,
        'showRemove' => false,
        'showUpload' => false,
    ];
    if (!empty($modelAbout->image_name)){
        $pluginOptions['initialPreview']=Html::img($modelAbout->image, ['style' => 'width:auto;height:auto;max-width:100%;max-height:100%;']);
        $pluginOptions['initialCaption']=$modelAbout->image_name;
    }
    echo $form->field($uploadImageAbout, 'image')->label('Фото')->widget(FileInput::classname(), [
        'language' => 'ru',
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => $pluginOptions
    ]); ?>



    <div class="form-group text-right">
        <?= Html::submitButton( 'Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php if (!empty($modelAbout->image)): ?>
    <div class="col-md-5">
        <h5 class="text-center"><b>Фото</b></h5>
        <img src="<?php echo $modelAbout->image; ?>" alt="Изображение отсутствует" style="max-width:450px;">
    </div>
<?php endif; ?>

