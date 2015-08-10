<?php
require_once "config.php";

class MysqlDB
{
 protected $_db;

 public function __construct()
 {
  $this->_db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 /* Comprueba la conexión */
if ($this->_db->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

if (!$this->_db->query("SET a=1")) {
    printf("Errormessage: %s\n", $mysqli->error);
}

  $this->_db->set_charset(DB_CHARSET);
 }
}