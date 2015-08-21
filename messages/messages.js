$.fn.wvt_messages = function(options) {

    var settings = $.extend({
        validate: true,
        api: "local"
        }, options );
	
    //Buscar listas de chat
    list_chat($(this).find('.chatlist'));

    //Buscar formularios
    form_chat($(this).find('form'));
}
function list_chat(list) {

    $($(list).find('.userchat')).each(function(){
        var chatmessage = $(this).find('.chatmessage');
        var chatreply = $(this).find('.chatreply');
        var btnhistory = $(this).find('.btn-chathistory');
        var chathistory = $(this).find('.chathistory');
        var autoresponse = $(this).find('.autoresponse');
        var message = $(this).find('input[name="message"]');

        $(chatmessage).on('click', function(){
            $(chatreply).toggle( "slow" );
        });

         $(btnhistory).on('click', function(){
            $(chathistory).toggle( "slow" );
        });
         
         $(autoresponse).each(function(){
           var responsetarget = $(this).attr('data-target');
        
           var responsecontent = $('#'+responsetarget).html();
           $(this).on('click', function(){
                $(message).val(responsecontent);
           });
         });
    });
}
function form_chat(forms){
    $(forms).each(function(){
        //Agregar novalidate
        $(this).attr('novalidate','novalidate');
        //Buscar y Activar/desactivar opciones adicionales
        form_opc($(this).find('input[name="options"]'));

            //Cuando se envia el formulario
    $(this).on("submit", function(e) {
    event.preventDefault(e);
    btncontrol=$(this).find('button[type="submit"]');
    result=$(this).find('div.result');
    $(result).empty();

    //Verificar los inputs
    if(!verifyInputs($(this).find('input,textarea,select'),result))
    {
    //Se crea el formulario y agregan elementos de ser necesario para enviar
    var chat_messages = new FormData($(this)[0]);   
    //Se procesa el envio
    form_send($(this).parents('.userchat'),chat_messages,$(this).find('input,textarea,select'),result,btncontrol);
    }

    });
    });
}
