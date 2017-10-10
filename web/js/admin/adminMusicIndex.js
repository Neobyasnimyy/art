
$('#openFormNewMusic').click(function () {
    $('#addMusic').toggle(); //тогл это переключатель, если display block он сделает none  и наоборот
});

// $('.music-name-edit input[name="Music[name]"]').dblclick(function () {
//     $(this).removeAttr('readonly');
// });



//при изменении названиия файла, запиcываем в базу данных
$('#GridViewMusic').on('click','._div_updateForm input[name="Music[name]"]', function(e){
    $(this).css("background", "#fff");
    return false;
});

// при изменении названиия файла, запиcываем в базу данных
$('#GridViewMusic').on('blur','._updateForm input[name="Music[name]"]', function(e){
    if (($(this).attr('value'))!=$(this).val()){
        var div =$(this).parents('._div_updateForm');
        // console.log(($(this).attr('value')));
        // console.log($(this).val());
        // console.log(div);
        var data = $(this).parents('form').serialize();
        $.ajax({
            url: '/admin/music/update',
            type: 'POST',
            data: data,
            success: function(res){
                div.html(res);
                // $.pjax.reload({container:"#GridViewMusic"});
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

