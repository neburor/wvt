<?php
#Configuracion y autentificacion a mysql
 define('DB_HOST','db586995718.db.1and1.com');
 define('DB_USER','dbo586995718');
 define('DB_PASS','112254');
 define('DB_NAME','db586995718');
 define('DB_CHARSET','utf-8');

#Conexion a mysql
class MysqlDB
{
 protected $_db;

 public function __construct()
 {
  $this->_db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  $this->_db->set_charset(DB_CHARSET);
 }
}