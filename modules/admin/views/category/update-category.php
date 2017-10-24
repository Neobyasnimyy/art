<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
$this->registerJsFile('/js/admin/adminCategoryUpdate.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->title = $modelCategory->name;

?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo Yii::$app->session->getFlash('success'); ?>
    </div>
<?php endif; ?>


<h1 class="text-center"><?= Html::encode($this->title) ?></h1>

<?php echo Html::Button('Развернуть форму категории', [
    'class' => 'btn btn-success',
    'id' => 'open-form-category',
    'style' => 'display: none']); ?>

<div class="categories-update">

    <?= $this->render('_form-category', [
        'modelCategory' => $modelCategory,
    ]) ?>

</div>
<div style="margin-top: 10px">
    <?php echo Html::a('Добавить Изображение', ['/admin/image/create','categoryId' => $modelCategory->id], ['class' => 'btn btn-success']); ?>
</div>


<div class="text-center">
    <h1>Список изображений</h1>
</div>
<br>

<div>
    <?php echo $this->render('_gridViewImage', [
        'dataProviderImage' => $dataProviderImage,
        'searchModelImage' => $searchModelImage,
        'categoryListForFilter' => $categoryListForFilter,
        'categoryList' => $categoryList,
        'categoryId'=>$modelCategory->id,
    ]) ?>
</div>
