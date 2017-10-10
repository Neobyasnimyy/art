/**
 * Created by Andrey on 09.10.2017.
 */


$('#openFormNewImage').click(function () {
    $('#_divAddImage').toggle(); //тогл это переключатель, если display block он сделает none  и наоборот
});



$('#filter-GridView')
    .on('pjax:end', function() {

    })
    .on('pjax:complete ',   function() {

    });

$('#filter-GridView').on('click','._div_updateForm select[name="Image[id_category]"]', function(e){
    $(this).css("background", "#fff");
    return false;
});

//при изменении названиия файла, запиcываем в базу данных
$('#filter-GridView').on('blur','._updateForm select[name="Image[id_category]"]', function(e){
    if (($(this).find('option[selected]').val())!=($(this).val())){
        var div =$(this).parents('._div_updateForm');
        // console.log('click');
        var data = $(this).parents('form').serialize();
        $.ajax({
            url: '/admin/image/update',
            type: 'POST',
            data: data,
            success: function(res){
                div.html(res);
            },
            timeout: 3000, // установка 3-х секундного тайм-аута
            error: function(){
                alert('Ошибка!');
            }
        });
    }else {
        $(this).css("background", "#eee");
    }
    return false;
});


