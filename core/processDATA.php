<?php
#Procesar peticiones ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	
	include '../core/localapi.php';
	if($_POST){
  		$json_return=localAPI::post($_POST);
  		$return=json_decode($json_return);
 	}
 	if($return->status=='201') { header("HTTP/1.0 201 Created");}
 	if($return->status=='409') { header("HTTP/1.0 409 Conflict");}
	header("Content-type: application/json; charset=utf-8");
	echo $json_return;
}
else {
	header("HTTP/1.0 405 Method Not Allowed"); 
	header('Access-Control-Allow-Methods: POST, GET');
	die();
}