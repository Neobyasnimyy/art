<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Image */

$this->title = 'Update Image: ' . $modelImage->id;
$this->params['breadcrumbs'][] = ['label' => 'Изображения', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelImage->image_path, 'url' => ['update', 'id' => $modelImage->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo Yii::$app->session->getFlash('success'); ?>
    </div>
<?php endif; ?>

<div class="images-update">

<!--    <h1>--><?php //echo Html::encode($this->title); ?><!--</h1>-->

    <?= $this->render('_form', [
        'modelImage' => $modelImage,
        'categoryList' => $categoryList,
        'uploadImage'=>$uploadImage,
    ]) ?>

</div>
