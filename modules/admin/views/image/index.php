<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Category;
use yii\helpers\Url;
use app\models\Image;
use yii\helpers\ArrayHelper;
// подключаем виджет постраничной разбивки
use yii\widgets\LinkPager;


$this->registerJsFile('/js/admin/adminImageIndex.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]);

/* @var $this yii\web\View */
/* @var $searchModel app\models\ImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Изображения';

?>
<div class="images-index">

    <div>
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo Yii::$app->session->getFlash('success'); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="text-center">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <div>
        <?= Html::submitButton('Добавить Изображение', ['id' => 'openFormNewImage', 'class' => 'btn btn-primary']) ?>
    </div>
    <br>

    <div id="_divAddImage" class="col-md-6" style="display: <?php echo ($openForm) ? 'block' : 'none' ;?> ">
        <?= $this->render('_form', [
            'modelImage' => $modelImage,
            'categoryList' => $categoryList,
            'uploadImage' => $uploadImage
        ]) ?>
        <br>
    </div>


    <div>
        <?php echo $this->render('_gridView', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'categoryListForFilter' => $categoryListForFilter,
            'categoryList' => $categoryList,
        ]) ?>
    </div>




</div>
