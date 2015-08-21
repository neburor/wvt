<?php
#COMPROBAR SI HAN UTILIZADO ESTE EQUIPO 
if($_SESSION['profile']!="" || $_POST["token"]!="" || $_POST["device"]!="" || $_COOKIE["token"]!="" || $_COOKIE["device"]!=""){
	if($_SESSION["profile"]!=""){
		$profile=$_SESSION["profile"];
	}
	else {
		if($_POST["token"]!="" || $_COOKIE["token"]!=""){
			if($_POST["token"]!=""){$token=$_POST["token"];}else {$token=$_COOKIE["token"];}

			$Profile=json_decode(API::profiles('get',array('token' => $token)));

		}
		else {
			if($_POST["device"]!="" || $_COOKIE["device"]!=""){
				if($_POST["device"]!=""){$device=$_POST["device"];}else {$device=$_COOKIE["device"];}

				$Profile=json_decode(API::profiles('get',array('device' => $device)));
				
  				#Si estan mandando correo
  				if($Profile->email=="" && $_POST["email"]!=""){
  					$token=md5($_SERVER['REQUEST_TIME_FLOAT']);
  					#si estan mandando nombre(Form de contacto)
  					if($_POST["name"]!=""){$set="`name`= '".$_POST['name']."', ";}
  					API::profiles('update',array('id' => $device))
  					if(mysql_query("UPDATE `cuentas` SET ".$set."`correo` = '".$dataForm['correo']."', `token` = '".$token."', `status` = '".$status."' WHERE `device` = '".$device."'  LIMIT 1")){
  						setcookie("token",$token,time()+7776000,"/");
  						$dataStatus["token"]=$token;
					}
  				}
			}
		}

	}

}
#No lo han utilizado
else {
	#comprobar si estan mandando correo
	if($dataForm['correo']!=""){
		#Verificar si existe alguna cuenta relasionada
		$ids=mysql_query("SELECT * FROM `cuentas` WHERE `correo` = '".$dataForm['correo']."' LIMIT 1");
		$registros = mysql_num_rows($ids);
		if($registros==0){
		#No hay usuarios, crear uno
			$status="NOTIFICACION";
			if($dataForm["nombre"]!=""){ $status="CONTACTO";}
			$device=substr(md5(uniqid(rand())),0,12);
			$token=strtoupper(substr(md5(uniqid(rand())),0,10));
			if(mysql_query("INSERT INTO `cuentas` (`id`, `dominio`, `fecha`, `nombre`, `correo`, `status`, `token`, `device`) VALUES (NULL, '".$dominio."', '".date("Y-m-d H:i:s")."', '".$dataForm['nombre']."', '".$dataForm['correo']."', '".$status."','".$token."','".$device."')")){
					$cuenta=mysql_insert_id();
					setcookie("token",$token,time()+7776000,"/");
					$dataStatus["token"]=$token;
					setcookie("device",$device,time()+7776000,"/");
					$dataStatus["device"]=$device;
					}

		}
		#Si hay una cuenta relasionada
		else {
			#Asignar id y token de la cuenta
			$usuario=mysql_fetch_row($ids);
			$cuenta=$usuario[0];
			setcookie("token",$usuario[7],time()+7776000,"/");
			$dataStatus["token"]=$usuario[7];
		}
	}
	#No estan mandando correo
	else {
		#Registrar equipo
		$status="APORTACION";
		if($dataForm["text"]!=""){$status="LIKE";}
		if($dataForm["rating"]!=""){ $status="RATING"; }
		if($dataForm["q"]!=""){$status="BUSQUEDA";}
		$device=substr(md5(uniqid(rand())),0,12);
 		if(mysql_query("INSERT INTO `cuentas` (`id`, `dominio`, `fecha`, `nombre`, `correo`, `status`, `token`, `device`) VALUES (NULL, '".$dominio."', '".date("Y-m-d H:i:s")."', '', '', '".$status."','','".$device."')")){
		$cuenta=mysql_insert_id();
		setcookie("device",$device,time()+7776000,"/");
		$dataStatus["device"]=$device;
		}
	}
}
?>