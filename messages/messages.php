<?php
#Incluir el manejador de base de datos
 include '../core/dbhandler.php';
#Messages
#Crear formulario
#	Opciones de formulario (Nombre,Email,Notificar)
#Crear lista de mensajes

class Messages
{  

	public static function history($params = array()) {
		 $params = array_merge(array(
        'limit' => 2,
        'icon' => false,
    	), $params);

		#$history=json_decode(API::chat('get',array('domain' => domain, 'id-profile' => profile)));

		echo '<div class="streamchat">';

		if(count($stream)>$params['limit']){

			$hidden_comments=count($stream)-$params['limit'];
		echo '<div class="row"><button class="btn btn-link pull-right" data-toggle="collapse" data-target="#allreply-chat" aria-expanded="false"><i class="fa fa-comment"></i> Todos los mensajes <span class="badge">'.$hidden_comments.'</span></button></div>';
		echo '<div class="collapse" id="allreply-chat">';
		$hidden_limit=count($stream)-$params['limit'];
		for ($i = 0; $i < $hidden_limit; ++$i) {
        	if($stream[$i]->type=="contact"){
				echo '<p class="text-left"><i class="fa fa-user icon"></i> <span class="comment-date pull-right">'.date("d/m/y", strtotime($stream[$i]->date)).'</span><br>'.$stream[$i]->message.'</p>';
			}
			if($stream[$i]->type=="reply"){
				echo '<p class="text-right"><span class="comment-date pull-left">'.date("d/m/y", strtotime($stream[$i]->date)).'</span> ';
				if($params['icon']){ echo '<img src="'.$params['icon'].'" class="icon"/>'; } else { echo '<i class="fa fa-user icon"></i>'; }
				echo '<br>'.$stream[$i]->message.'</p>';
			}
    	}
    	echo '</div>';
		}

		for ($i = $hidden_limit; $i < count($stream); ++$i) {
        	if($stream[$i]->type=="contact"){
				echo '<p class="text-left"><i class="fa fa-user icon"></i> <span class="comment-date pull-right">'.date("d/m/y", strtotime($stream[$i]->date)).'</span><br>'.$stream[$i]->message.'</p>';
			}
			if($stream[$i]->type=="reply"){
				echo '<p class="text-right"><span class="comment-date pull-left">'.date("d/m/y", strtotime($stream[$i]->date)).'</span> ';
				if($params['icon']){ echo '<img src="'.$params['icon'].'" class="icon"/>'; } else { echo '<i class="fa fa-user icon"></i>'; }
				echo '<br>'.$stream[$i]->message.'</p>';
			}
    	}

		echo '</div>';
	}
	#Creacion de formulario para enviar mensajes
	public static function form($params = array()) {
		#Parametros del formulario
		$params = array_merge(array(
		'class' => 'wvt-messages',
        'type' 	=> 'contact',
        'name' 	=> false,
        'email' => false,
        'notif' => true
    	), $params);

		#Inicio del forulario
		echo '<div class="'.$params['class'].'"><form class="form" role="form" method="POST" >';
		#Tipo de formulario
		echo '<input type="hidden" name="type" value="'.$params['type'].'">';
		#Mostrar mensaje si va a ser con opcion de notificacion (solo si nombre y correo no son requeridos)
		if ($params['notif'] && !$params['name'] && !$params['email']){ 
			echo '<div class="result"><div class="col-xs-12"><p><i class="fa fa-info-circle"></i> La respuesta a su mensaje la podra consultar posteriormente ingresando de nuevo a esta pagina.</p></div></div>';
			} 
			#Si no requier de opcion de notificacion
			else {
				echo '<div class="result"></div>';
			}
		#Si requiere nombre y correo
		if($params['name'] && $params['email']){
			echo '<div class="form-group col-xs-6 col-xxs-12"><div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span><input name="name" type="text" placeholder="Su nombre ..." class="form-control" maxlength="32" minlength="4" required></div></div>';
			echo '<div class="form-group col-xs-6 col-xxs-12"><div class="input-group"><span class="input-group-addon"><i class="fa fa-at"></i></span><input name="email" type="email" placeholder="Su correo ..." class="form-control" maxlength="64" minlength="8" required></div></div>';
		}
		#Si requiere nombre o correo
		if(($params['name'] || $params['email']) && !($params['name'] && $params['email'])){
			#Si requiere nombre
			if($params['name']){
			echo '<div class="form-group col-xs-12"><div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span><input name="name" type="text" placeholder="Su nombre ..." class="form-control" maxlength="32" minlength="4" required></div></div>';
			}
			#Si requiere correo
			if($params['email']){
			echo '<div class="form-group col-xs-12"><div class="input-group"><span class="input-group-addon"><i class="fa fa-at"></i></span><input name="email" type="email" placeholder="Su correo ..." class="form-control" maxlength="64" minlength="8" required></div></div>';
			}
		}
		#Si es formulario de contacto (pagina) se muestra una textarea
		if($params['type']=='contact'){
			echo '<div class="form-group col-xs-12"><div class="input-group"><span class="input-group-addon"><i class="fa fa-comment"></i></span>
              <textarea name="message" placeholder="Su mensaje a la administración ..." class="form-control" maxlength="1024" minlength="5" required></textarea></div></div>';
		}
		#Si es formulario de charla (perfil) se muesta un input con boton submit
		if($params['type']=='chat'){
		echo '<div class="form-group col-xs-12"><div class="input-group"><input type="text" name="message" placeholder="Su mensaje a la administración ..." class="form-control" maxlength="1024" minlength="10" required></input><div class="input-group-btn"><button type="submit" class="btn btn-default"><i class="fa fa-share"></i></button></div></div></div>';
		}
		#Opcion de notificar por correo (whatsapp, twitter, facebook)
		if ($params['notif'] && !$params['name'] && !$params['email']){ echo '<label class="col-xs-12"><input type="checkbox" name="options"><span>Notificarme a mi correo.</span></label>';
		echo '<div class="collapse col-xs-12" aria-expanded="false">
            <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-user"></i></span>
              <input type="email" name="email" class="form-control" placeholder="correo@ejemplo.com" disabled="disabled" required>
            </div>
            </div>
          </div>';}
        #Si es formulario de contacto mostrar boton
		if($params['type']=="contact") {
          	echo '<div class="form-group col-xs-12"><button type="submit" class="btn btn-default btn-block">Enviar mensaje <i class="fa fa-share"></i></button></div>';
          }
          
        echo '</form></div>';
	}
}