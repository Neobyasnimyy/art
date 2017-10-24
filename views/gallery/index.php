<?php
//debug($images);
use yii\widgets\LinkPager;
use yii\helpers\Html;

$this->title="Галлерея";

?>



<?php foreach ($modelGallery as $item):?>

    название - <?php echo $item['name']?><br>
   жанр - <?php echo $item['genre']?><br>

    <?php // выводит первую картинку из альбома
        $src= (!empty($images=$item['images']))?
            $item['id'] . '/'.$images[0]->image_path
            : 'default.jpg';
         echo Html::img('/web/uploads/images/'.$src, [
            'alt' => 'Изображение отсутствует',
            'style' => 'width:390px;height:245px',
             'class'=>'',
        ]);
     ?>

    <a href="/gallery/view?id=<?php echo $item['id']?>">Читать дальше </a><br><br>


<?php endforeach;?>

<?php echo LinkPager::widget([
    'pagination' => $pages,
    'registerLinkTags' => true
]);?>