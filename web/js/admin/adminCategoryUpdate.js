/**
 * Created by Andrey on 19.10.2017.
 */
$(document).ready(function(){


    $('#close-form-category').click(function () {
        $('.categories-update').toggle(); //тогл это переключатель, если display block он сделает none  и наоборот
        $('#open-form-category').toggle();
    });
    $('#open-form-category').click(function () {
        $('.categories-update').toggle(); //тогл это переключатель, если display block он сделает none  и наоборот
        $('#open-form-category').toggle();
    });


//     $('#filter-GridView')
//         .on('pjax:end', function() {
//
//         })
//         .on('pjax:complete ',   function() {
//
//         });
//
    $('#filter-GridView').on('click','._div_updateForm select[name="Image[id_category]"],._updateNameForm input[name="Image[name_for_slider]"] ', function(e){
        $(this).css("background", "#fff");
        return false;
    });


    $('#filter-GridView').on('blur','._updateForm select[name="Image[id_category]"]', function(e){
        if (($(this).find('option[selected]').val())!=($(this).val())){
            var div =$(this).parents('._div_updateForm');
            console.log('click');
            var data = $(this).parents('form').serialize();
            $.ajax({
                url: '/admin/image/update-category',
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

    $('#filter-GridView').on('blur','._updateNameForm input[name="Image[name_for_slider]"]', function(e){
        if (($(this).attr('value'))!=($(this).val())){
            var div =$(this).parents('._div_updateNameForm');
            console.log('click');
            var data = $(this).parents('form').serialize();
            $.ajax({
                url: '/admin/image/update-name',
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

    // edit slider click
    $('#filter-GridView').on('click',' span[data-name="slider_up"], span[data-name="slider_down"]',function (e) {
        // console.log($(this).data('name'));
        var slider_name=$(this).attr('data-name');
        var image_id = $(this).attr('data-id');
        var value = $(this).attr('data-value');
        // console.log(value);
        var span = $(this);
        $.post('/admin/image/edit-slider',{name:slider_name,image_id:image_id,value:value},function(data,status){
            if( status=='success' && (data.status==true)){
                if(data.value==1){
                    span.removeClass('glyphicon-remove');
                    span.addClass('glyphicon-ok');
                }else if(data.value==0){
                    span.removeClass('glyphicon-ok');
                    span.addClass('glyphicon-remove');
                }
                // console.log(data.value);
                span.attr('data-value',data.value);
                span.after('<p>save</p>');
                setTimeout(function() { span.parent().find('p').remove(); }, 3000);
            }else{
                span.after('<p>error</p>');
                setTimeout(function() { span.parent().find('p').remove(); }, 5000);            }
        })
        return false;
    })



});