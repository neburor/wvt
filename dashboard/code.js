$(document).ready(function () {
	//offcanvas
	$('[data-toggle="offcanvas"]').click(function () {
    	$('.row-offcanvas').toggleClass('active');
  	});
	
	$('.btn-offcanvas').click(function () {
    	$('.row-offcanvas').toggleClass('active');
  	});
	//Menu
	var sidebarA = $('.sidebar').find('a');
	$(sidebarA).each(function(){
		if($(this).attr('data-content')){
			$(this).on('click', function(){
				var content = $(this).attr('data-content');
				
				$('.main').html($(content).html()).wvt();
				$('.row-offcanvas').toggleClass('active');
			});
		}
	});

});
$.fn.wvt = function(){

//Activar funciones de chat
	$('.wvt-chat').wvt_chat();
}