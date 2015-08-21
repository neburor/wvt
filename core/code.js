function form_send(form,formdata,inputs,result,btncontrol){
    formdata.append("domain", window.location.host);
    formdata.append("url", window.location.href);
    if (localStorage.getItem("token") === null) {} else {
        formulario.append("token", localStorage.getItem("token")); }
    if (localStorage.getItem("device") === null) {} else {
        formulario.append("device", localStorage.getItem("device")); }
	  //Envio del formulario con AJAX
        $.ajax({
            type: "POST",
            url: "../core/processDATA.php",
            dataType: "json",
            data: formdata,
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
            	successAJAX('correct',form,inputs,result,btncontrol);
            //	errorAJAX(result,btncontrol); 
            }
         });
}

function errorAJAX(result,btncontrol){
    $(result).append('<div class="col-xs-12"><div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><i class="fa fa-warning"></i><b>Error !</b>, sin conexión a internet.</div></div>'); 
    $(btncontrol).removeAttr("disabled");
    $(btncontrol).empty().append('<i class="fa fa-warning"></i> Reintentar');  
}
function beforesendAJAX(inputs,result,btncontrol){
    $(result).empty();
    $(inputs).each(function(){
        $(this).attr('readonly','readonly');
    });
    $(btncontrol).empty().append('<i class="fa fa-cog fa-spin"></i> Enviando');
}
function successAJAX(status,form,inputs,result,btncontrol){
    if(status=="correct"){
        $(form).hide('slow', function(){ $(form).remove(); });
    }
    if(status=="error"){
    $(result).append('<div class="col-xs-12"><div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><i class="fa fa-warning"></i><b>Error !</b>, no se pudo enviar, intente mas tarde.</div></div>'); 
    $(btncontrol).removeAttr("disabled");
    $(btncontrol).empty().append('<i class="fa fa-warning"></i> Reintentar'); 
    }
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
function Messages(type,lng) {
    switch (lng) {
        case 'es' : 
            switch (type){
                case 'offline': return ' <b>Error !</b>, sin conexión a internet.'; break;
            }
        break;
        default : break;
    }
}