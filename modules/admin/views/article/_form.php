<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use vova07\imperavi\Widget;
use yii\helpers\Url;
use kartik\file\FileInput;


/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-7">
    <?php $form = ActiveForm::begin([
        'id' => 'article-form',
        'enableClientValidation' => true, // проверка на стороне клиента полностью,
        'method' => 'post',
        'action' => [$modelArticle->isNewRecord ? 'create' : 'update', 'id' => $modelArticle->id],
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>


    <?php
    if (empty($modelArticle->data)) {
        $modelArticle->data = date('Y-m-d');
    }
    echo $form->field($modelArticle, 'data')->widget(DatePicker::className(), [
        'type' => DatePicker::TYPE_INPUT,
        'options' => ['placeholder' => 'Ввод даты ...'],
        'value' => date("yyyy-mm-dd", (integer)$modelArticle->data),
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'autoclose' => true,
            'todayHighlight' => true,// подсвечивает сегодняшнюю дату
//            'startView'=>2, // сначало выбираем год => 2
            'weekStart' => 1, //неделя начинается с понедельника
//            'startDate' => '01.05.2015 00:00', //самая ранняя возможная дата
            'todayBtn' => 'linked', //снизу кнопка "сегодня"
        ]

    ]);
    ?>

    <?= $form->field($modelArticle, 'title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($modelArticle, 'description')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'imageUpload' => Url::to(['article/save-redactor-img']),
            'imageManagerJson' => Url::to(['article/images-get']),
            'plugins' => [
                'clips',
                'fullscreen',
                'imagemanager',
                'fontsize',
                'fontcolor',
            ]
        ]
    ]); ?>



    <?php

    $pluginOptions=[
        'allowedFileExtensions'=>['jpg', 'gif', 'png', 'bmp'],
        'overwriteInitial' => true, // перезаписывает данные которые мы ему передали при инициализации
        'initialCaption'=> $modelArticle->image_name,
        'showPreview' => true,
        'showCaption' => true,
        'showRemove' => false,
        'showUpload' => false,
    ];
    if (!empty($modelArticle->image_name)){
        $pluginOptions['initialPreview']=Html::img($modelArticle->image, ['style' => 'width:auto;height:auto;max-width:100%;max-height:100%;']);
        $pluginOptions['initialCaption']=$modelArticle->image_name;
    }
    echo $form->field($uploadImageArticle, 'image')->label('Обложка')->widget(FileInput::classname(), [
        'language' => 'ru',
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => $pluginOptions
    ]); ?>


    <?= $form->field($modelArticle, 'is_active')->radioList([
        '1' => 'Вкл',
        '0' => 'Выкл',
    ], (empty($modelArticle->isActive)) ? ['value' => '1'] : []) ?>

    <div class="form-group text-right">
        <?= Html::submitButton($modelArticle->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php if (!empty($modelArticle->image_name)): ?>
    <div class="col-md-5">
        <h5 class="text-center"><b>Обложка</b></h5>
        <img src="<?php echo $modelArticle->image; ?>" alt="Изображение отсутствует" style="max-width:450px;">
    </div>
<?php endif; ?>
