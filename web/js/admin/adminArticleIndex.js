$(document).ready(function () {

    $('#openFormNewArticle').click(function () {
        $('#addArticle').toggle(); //тогл это переключатель, если display block он сделает none  и наоборот
        return false;
    });



    // // эмулирует нажатие на скрытую кнопку
    // $('body .wrapp-table').on('click','.buttonAddImage',function () {
    //     var but = '.'+$(this).data('buttonClick');
    //     $(but).trigger('click');
    //     return false;
    // });


//при изменении названиия файла, запиcываем в базу данных
//     $('#GridViewMusic').on('click','._div_updateForm input[name="Music[name]"]', function(e){
//         $(this).css("background", "#fff");
//         return false;
//     });

    // var addBtnRes = function () {
    //     $('body #w0-filters  td:last-child')
    //         .html("<button id='form-reset-button' class='btn btn-danger btn-sm' aria-hidden='true'>Reset</button>");
    // };
    //
    //
    // addBtnRes();
    // // добавляет reset после pjax запроса
    // $('#GridViewMusic')
    //     .on('pjax:complete ',   function() {
    //         addBtnRes();
    //     });


    // очищаем поиск в GridView
    // $('body').on('click','#form-reset-button',function()
    // {
    //     $('#w0-filters input').each( function(i,o) {
    //         $(o).val('');
    //     });
    //     $('#w0-filters').find('input').trigger(jQuery.Event('keydown', {keyCode: 13}));
    //     return false;
    // });


});



