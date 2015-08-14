$(document).ready(function () {

	//Activar funciones de chat
	$('.wvt-chat form').wvt_chat();
});


$.fn.wvt_chat = function() {
	$(this).each(function (){
	//Agregar novalidate
	$(this).attr('novalidate','novalidate');
	//Buscar y Activar/desactivar opciones adicionales
	form_opc($(this).find('input[name="options"]'));
	});	
	
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
	chat_messages.append("type", $(this).attr('form-type'));	
	
	//Se procesa el envio
	form_send(chat_messages,inputs,result,btncontrol);
	}

	});
}

function form_send(form,inputs,result,btncontrol){
	  //Envio del formulario con AJAX
        $.ajax({
            type: "POST",
            url: "processData.php",
            dataType: "json",
            data: form,
            cache: false,
            contentType: false,
            processData: false, 
            complete: function(data){
            },
            success: function(data){  
            },
            beforeSend: function(){ 
            	beforesendAJAX(inputs,result,btncontrol);
            },
            error: function(){ 
            	beforesendAJAX(inputs,result,btncontrol);
            //	errorAJAX(result,btncontrol); 
            }
         });
}

function errorAJAX(result,btncontrol){
    $(result).append('<div class="col-xs-12"><div class="alert alert-error alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><i class="fa fa-warning"></i> <b>Error !</b>, no se puede conectar al servidor, si persiste intente mas tarde.</div></div>'); 
    $(btncontrol).removeAttr("disabled");
    $(btncontrol).empty().append('<i class="fa fa-warning"> Reintentar');  
}

function form_opc (opciones) {
	
$(opciones).on('click', function() {
    collapse=$(opciones).parents('form').find('div.collapse');
    inputs=$(collapse).find('input,textarea,select');
    
 if($(opciones).is(':checked')){
    $(inputs).each(function(){
        $(this).removeAttr('disabled');
    });
    $(collapse).collapse('toggle');
 }
 else{
    $(inputs).each(function(){
        $(this).attr('disabled','disabled');
    });
    $(collapse).collapse('toggle');
 }
});
}
function verifyInputs (inputs,result){
	var error=0;
	//Comprobar los inputs a enviar y si son correctos
	$(inputs).each(function(){
		if($(this).is(':disabled')){}
        else {
            if($(this).attr('name')!='options' && $(this).attr('name')!='autopass'){
            	var status=checkINPUT($(this));
            	if(!status['error']){
                    $(this).removeClass('inp_error');
            	}
            	else {
            		$(this).addClass('inp_error');
            		$(result).append(status['status']);
            	error++;
            	}
            }
        }

	});
	  return error
}

function checkINPUT(input){
	var minLength = 4;
	var maxLength = 32;
	var status = new Object();
	status['error']=0;

	if($(input).attr('minlength')) { minLength = $(input).attr('minLength'); }
	if($(input).attr('maxlength')) { maxLength = $(input).attr('maxLength'); }

	if($(input).is(':required')){
		if($(input).val()==""){
			status['error']++; 
			status['status']="no data";
		}	
		else {
			if($(input).val().length < minLength || $(input).val().length > maxLength){
				status['error']++; 
        		status['status']="incomplete";
        	}
        	else {
				if($(input).attr("type")=="email"){ 
        			if(!/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$/.test($(input).val())){ 
        				status['error']++; 
        				status['status']="incorrect";
        			}
        			else { status['status']="correct";
        			}
        		}	
        	}
    	}
	}
    return status
}