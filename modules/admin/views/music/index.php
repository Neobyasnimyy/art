<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->registerJsFile('/js/admin/adminMusicIndex.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]);

/* @var $this yii\web\View */
/* @var $searchModel app\models\MusicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Музыка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="music-index">

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::submitButton('Добавить Композицию', ['id' => 'openFormNewMusic', 'class' => 'btn btn-primary']) ?>

    <div id="addMusic" style="display: <?php echo ($openForm) ? 'block' : 'none' ;?>">
        <?= $this->render('_form', [
            'modelMusic' => $modelMusic,
            'uploadMusic' => $uploadMusic
        ]) ?>
    </div>


    <?= $this->render('_gridView', [
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
    ]) ?>




</div>