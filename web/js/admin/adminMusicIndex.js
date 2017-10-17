

$(document).ready(function(){

    $('#openFormNewMusic').click(function () {
        $('#addMusic').toggle(); //тогл это переключатель, если display block он сделает none  и наоборот
    });


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

    var addBtnRes = function () {
        $('body #w0-filters  td:first-child')
            .html("<span id='form-reset-button' class='glyphicon glyphicon-remove btn btn-danger btn-sm' aria-hidden='true'></span>");
    }
    addBtnRes();
    // добавляет reset после pjax запроса
    $('#GridViewMusic')
        .on('pjax:complete ',   function() {
            addBtnRes();
        });


    // очищаем поиск в GridView
    $('body').on('click','#form-reset-button',function()
    {
        $('#w0-filters input').each( function(i,o) {
            $(o).val('');
        });
        $('#w0-filters').find('input[name="MusicSearch[file_name]"]').trigger(jQuery.Event('keydown', {keyCode: 13}));
        return false;
    });
});



