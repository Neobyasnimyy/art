<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->registerJsFile('/js/admin/adminUserIndex.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo Yii::$app->session->getFlash('success'); ?>
    </div>
<?php endif; ?>

<div class="text-center">
    <h1>Список зарегистрированных пользователей</h1>
</div>

<?php //debug((Yii::$app->user->identity))?>
<div>
    <?php echo GridView::widget([
        'id' => 'GridView-User',
        'dataProvider' => $dataProviderUser,
        'filterModel' => $searchModelUser,
        'layout'=>"{items}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//        'id',
            [
                'attribute' => 'username',
                'label' => 'Ник',
            ],
            'email',
            [
                'attribute' => 'role',
                'label' => 'Права',
                'filter' => ['user'=>'user','admin'=>'admin'],
                'format' => 'raw',
                'value' => function ($data){
                    return $this->render('_updateRoleForm', [
                        'modelUser' => $data,
                    ]);
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                            'class' => '',
                            'data' => [
                                'confirm' => 'Вы точно хотите удалить данного пользователя?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>
</div>


<div class="text-center">
    <?php echo LinkPager::widget([
        'pagination' => $dataProviderUser->pagination,
    ]);?>
</div>
