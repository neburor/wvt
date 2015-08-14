<?php

include 'dbhandler.php';

define(domain,$_SERVER['HTTP_HOST']);
define(profile, 1);

#Chat online
class Chat
{  

	public static function Stream($params = array()) {
		 $params = array_merge(array(
        'limit' => 2,
        'icon' => false,
    	), $params);

		$stream=json_decode(API::chat('get',array('domain' => domain, 'id-profile' => profile)));

		echo '<div class="streamchat">';

		if(count($stream)>$params['limit']){

			$hidden_comments=count($stream)-$params['limit'];
		echo '<div class="row"><button class="btn btn-link pull-right" data-toggle="collapse" data-target="#allreply-chat" aria-expanded="false"><i class="fa fa-comment"></i> Todos los mensajes <span class="badge">'.$hidden_comments.'</span></button></div>';
		echo '<div class="collapse" id="allreply-chat">';

		for ($i = 0; $i < $params['limit']; ++$i) {
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

		for ($i = $params['limit']; $i < count($stream); ++$i) {
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

	public static function Form($params = array()) {
		$params = array_merge(array(
        'type' => 'contact',
        'info' => true,
        'opc'  => true
    	), $params);

		echo '<form class="form" role="form" method="POST" form-type="'.$params['type'].'">';
		if ($params['info']){ echo '<div class="result"><div class="col-xs-12"><p><i class="fa fa-info-circle"></i> La respuesta a su mensaje la podra consultar posteriormente ingresando de nuevo a esta pagina.</p></div></div>';} else {echo '<div class="result"></div>';}
		if($params['type']=='contact'){
			echo '<div class="form-group"><div class="input-group"><span class="input-group-addon"><i class="fa fa-comment"></i></span>
              <textarea name="message" placeholder="Su mensaje a la administración ..." class="form-control" maxlength="1024" minlength="5" required></textarea></div></div>';
		}
		if($params['type']=='chat'){
		echo '<div class="form-group"><div class="input-group"><input type="text" name="message" placeholder="Su mensaje a la administración ..." class="form-control" maxlength="1024" minlength="10" required></input><div class="input-group-btn"><button type="submit" class="btn btn-default"><i class="fa fa-share"></i></button></div></div></div>';
		}
		if ($params['opc']){ echo '<label class="col-xs-12"><input type="checkbox" name="options"><span>Notificarme a mi correo.</span></label>';
		echo '<div class="collapse col-xs-12" aria-expanded="false">
            <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-user"></i></span>
              <input type="email" name="email" class="form-control" placeholder="correo@ejemplo.com" disabled="disabled" required>
            </div>
            </div>
          </div>';}
		if($params['type']=="contact") {
          	echo '<div class="form-group"><button type="submit" class="btn btn-default btn-block">Enviar mensaje <i class="fa fa-share"></i></button></div>';
          }
          
        echo '</form>';
	}
}