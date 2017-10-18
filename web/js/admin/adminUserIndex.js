/**
 * Created by Andrey on 18.10.2017.
 */

$(document).ready(function(){



    $('#GridView-User').on('click','._div_updateRoleForm select[name="User[role]"]', function(e){
        $(this).css("background", "#fff");
        return false;
    });

//при изменении названиия файла, запиcываем в базу данных
    $('#GridView-User').on('blur','._updateRoleForm select[name="User[role]"]', function(e){
        if (($(this).find('option[selected]').val())!=($(this).val())){
            var div =$(this).parents('._div_updateRoleForm');
            var data = $(this).parents('form').serialize();
            $.ajax({
                url: '/admin/user/update',
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



});