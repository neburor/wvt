<?php
#Conexion a Mysql DB
 include 'mysql_db.php';

#Chat online
class Chat
{    
	public static function Stream($limit_comments) {
		$stream_comments = (!empty($limit_comments) ? $stream_comments : 2);
		$id=1;
		

		try {
			$ConnectDB = MysqlConnect();
			$dbh = $ConectarDB->prepare("SELECT * FROM chat WHERE id_profile = ?");
			$dbh->bindParam(1,$id);
			$dbh->execute();
			$stream = $dbh->fetchObject();
			$ConectarDB=null;

			echo $stream;
    	} 
    	catch (Exception $e) {
        		die("Error : ".$e);
    	}
	}
}