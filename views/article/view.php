<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = $modelArticle->title;

?>
<div class="article-view">


    <p>Заголовок <?php echo $modelArticle['title'];?></p>

    Обложка<img src="<?php echo $modelArticle['image']; ?>" alt="Изображение отсутствует" style="max-width:800px;max-height: 350px"><br>
    <div>
        Описание
        <div>
            <?php echo $modelArticle['description'];?>
        </div>
    </div>

</div>
