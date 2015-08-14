<?php
#Conexion a Mysql DB
 include 'mysql_db.php';
MysqlConnect();


class API {

	public static function chat($method, $params = array()){
	
    $params = array_merge(array(
        'domain' => null,
        'id-profile' => null,
        'order-by' => 'id',
        'order' => 'ASC'
    	), $params);

    switch ($method) {
    	case 'get':
    		$sql=mysql_query("SELECT * FROM `chat` WHERE `domain` = '".$params['domain']."' AND `id_profile` = '".$params['id-profile']."' ORDER BY `".$params['order-by']."` ".$params['order']."");

			$json = array();
			while($i = mysql_fetch_assoc($sql)) {
    			$json[] = $i;
				}
				return json_encode($json);
    		break;
    	
    	default:
    		# code...
    		break;
    }


	}
}