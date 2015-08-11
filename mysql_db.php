<?php
#Configuracion para Mysql DB
 define('DB_HOST','db586995718.db.1and1.com');
 define('DB_USER','dbo586995718');
 define('DB_PASS','112254');
 define('DB_NAME','db586995718');
 define('DB_CHARSET','utf-8');

#Conexion a mysql
function MysqlConnect () {
	try {
		$Connection = new PDO("mysql:host=".$BD_HOST.";dbname=".$DB_NAME, $DB_USER, $DB_PASS);
		$Connection->exec("set names utf8");
	} catch (PDOException $e) {
		echo "Error: ".$e->getMessage();
	}
}