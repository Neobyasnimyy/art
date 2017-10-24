<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сообщения';

?>
<div class="message-index">

    <h1><?= Html::encode($this->title) ?></h1>


<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'name',
            'email:email',
            'subject',
            'body:ntext',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}{delete}',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
