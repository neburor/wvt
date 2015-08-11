<?php
#Conexion a Mysql DB
 include 'mysql_db.php';
MysqlConnect();
#Chat online
class Chat
{    
	public static function Stream($a,$b) {
		$limit_comments = (!empty($a) ? $a : 2);
		$icon_logo = (!empty($b) ? $b : false);
		$stream_comments=mysql_query("SELECT * FROM `chat` WHERE `id_profile` = '1' ORDER BY `id`");
		echo '<div class="streamchat">';

		if(mysql_num_rows($stream_comments)>$limit_comments){
			$hidden_comments=mysql_num_rows($stream_comments)-$limit_comments;
		echo '<div class="row"><button class="btn btn-link pull-right" data-toggle="collapse" data-target="#allreply-chat" aria-expanded="false"><i class="fa fa-comment"></i> Todos los mensajes <span class="badge">'.$hidden_comments.'</span></button></div>';
		echo '<div class="collapse" id="allreply-chat">';
		for ($i=$limit_comments; $i < mysql_num_rows($stream_comments) ; $i++) { 
		$arreglo=mysql_fetch_row($stream_comments);
		$time = strtotime($arreglo[3]); 
		$date = date("d/m/y", $time);
			if($arreglo[1]=="contact"){
				echo '<p class="text-left"><i class="fa fa-user icon"></i> <span class="comment-date pull-right">'.$date.'</span><br>'.$arreglo[4].'</p>';
			}
			if($arreglo[1]=="reply"){
				echo '<p class="text-right"><span class="comment-date pull-left">'.$date.'</span> ';
				if($icon_logo){ echo '<img src="'.$icon_logo.'" class="icon"/>'; } else { echo '<i class="fa fa-user icon"></i>'; }
				echo '<br>'.$arreglo[4].'</p>';
			}
		}
		echo '</div>';
			
		}
		for ($i=0; $i < mysql_num_rows($stream_comments) ; $i++) { 
		$arreglo=mysql_fetch_row($stream_comments);

		$time = strtotime($arreglo[3]); 
		$date = date("d/m/y", $time);
			if($arreglo[1]=="contact"){
				echo '<p class="text-left"><i class="fa fa-user icon"></i> <span class="comment-date pull-right">'.$date.'</span><br>'.$arreglo[4].'</p>';
			}
			if($arreglo[1]=="reply"){
				echo '<p class="text-right"><span class="comment-date pull-left">'.$date.'</span> ';
				if($icon_logo){ echo '<img src="'.$icon_logo.'" class="icon"/>'; } else { echo '<i class="fa fa-user icon"></i>'; }
				echo '<br>'.$arreglo[4].'</p>';
			}

		}

		echo '</div>';
	}

	public static function Form($a,$b,$c) {
		$form_type= (!empty($a) ? $a : 'contact');
		$show_message = (!empty($b) ? $b : 'show');
		$opc_email = (!empty($c) ? $c : 'show');

		echo '<form class="form" role="form" form-type="'.$form_type.'">';
		if ($show_message=='show'){ echo '<div class="result"><div class="col-xs-12"><p><i class="fa fa-info-circle"></i> La respuesta a su mensaje la podra consultar posteriormente ingresando de nuevo a esta pagina.</p></div></div>';} else {echo '<div class="result"></div>';}
		if($form_type=='contact'){
			echo '<div class="form-group"><div class="input-group"><span class="input-group-addon"><i class="fa fa-comment"></i></span>
              <textarea name="mensaje" placeholder="Su mensaje a la administración ..." class="form-control" required></textarea></div></div>';
		}
		if($form_type=='chat'){
		echo '<div class="form-group"><div class="input-group"><input type="text" name="mensaje" placeholder="Su mensaje a la administración ..." class="form-control" required></input><div class="input-group-btn"><button type="submit" class="btn btn-default"><i class="fa fa-share"></i></button></div></div></div>';
		}
		if ($opc_email=='show'){ echo '<label class="col-xs-12"><input type="checkbox" name="opciones"><span>Notificarme a mi correo.</span></label>';
		echo '<div class="collapse col-xs-12" aria-expanded="false">
            <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-user"></i></span>
              <input type="email" name="correo" class="form-control" placeholder="correo@ejemplo.com" disabled="disabled">
            </div>
            </div>
          </div>';}
		if($form_type=="contact") {
          	echo '<div class="form-group col-xs-12"><button type="submit" class="btn btn-default btn-block">Enviar mensaje <i class="fa fa-share"></i></button></div>';
          }
          
        echo '</form>';
	}
}