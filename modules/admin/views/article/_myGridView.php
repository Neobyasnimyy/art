<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

?>


<div class="container-fluid container-articles  text-center">
    <div class="row table-striped table-bordered">
        <?php $prefix = ((empty(Yii::$app->request->get('sort')) or (Yii::$app->request->get('sort') == 'id')) ? '-' : ''); ?>
        <div class="col-md-1"><a href="/admin/article/index?sort=<?php echo $prefix; ?>id" data-sort="id">ID</a></div>
        <div class="col-md-2"><a href="/admin/article/index?sort=data" data-sort="data">Дата</a></div>
        <div class="col-md-4">Заголовок</div>
        <div class="col-md-2">Изображение</div>
        <div class="col-md-1 action-column">Статус</div>
        <div class="col-md-2 action-column">&nbsp;</div>
    </div>
    <div id="w1-filters" class="filters row table-bordered table-striped">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>
        <div class="col-md-1">&nbsp;</div>
        <div class="col-md-2"><?php echo $form->field($searchModel, 'data')->label(false) ?></div>
        <div class="col-md-4">&nbsp;</div>
        <div class="col-md-2">&nbsp;</div>
        <div class="col-md-1"><?php echo $form->field($searchModel, 'is_active')->dropDownList(\app\models\Article::getStatusList())->label(false) ?></div>
        <div class="col-md-2">
            <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']);
            ActiveForm::end() ?>
        </div>
    </div>


    <?php foreach ($articles as $article):; ?>


        <div class="row table-bordered">
            <?php echo $this->render('_updateForm', [
                'article' => $article,
                'uploadImage' => $uploadImage,
            ]); ?>
        </div>



    <?php endforeach; ?>
</div>



