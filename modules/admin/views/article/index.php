<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\widgets\LinkPager;

$this->registerJsFile('/js/admin/adminArticleIndex.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile("/css/admin/article/index.css");

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статьи';

?>
<div class="article-index">

<!--    <h1>--><?php //echo Html::encode($this->title) ?><!--</h1>-->
<!--    --><?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <p>
        <?php echo Html::submitButton('Добавить статью', ['id' => 'openFormNewArticle', 'class' => 'btn btn-primary']) ?>
    </p>
    <div id="addArticle" style="display: <?php echo ($openFormArticle) ? 'block' : 'none' ;?>" class="row">
        <?= $this->render('_form', [
            'modelArticle' => $modelArticle,
            'uploadImageArticle' =>$uploadImageArticle,
        ]); ?>
    </div>

    <br>

    <div>
        <?php echo $this->render('_gridView', [
            'dataProviderArticle' => $dataProviderArticle,
            'searchModelArticle' => $searchModelArticle,
        ]) ?>
    </div>


</div>