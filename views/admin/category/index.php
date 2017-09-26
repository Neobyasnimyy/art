<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории галереи';
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php \yii\widgets\Pjax::begin(['id' => 'some-id-you-like',
        'timeout' => false,
        'enablePushState' => false,
        'clientOptions' => ['method' => 'POST']]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute' => 'genre',
                'value' => 'genre',
                'headerOptions' => ['width' => '200'],
            ],
            'description:ntext',
            [
                'attribute' => 'is_active',
                'value' => 'isActive',
                'filter' => array('' => 'Все', "1" => "Вкл", "0" => "Выкл"),
            ],

            [
                'class' => 'yii\grid\ActionColumn',
//                'header'=>'Действия',
//                'headerOptions' => ['width' => '80'],
                'template' => '{view} {update} {delete}{link}',
            ],
        ],
    ]); ?>

    <?php \yii\widgets\Pjax::end(); ?>

</div>
