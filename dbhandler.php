<?php
#Conexion a Mysql DB
 include 'mysql_db.php';
MysqlConnect();


class API {

	public static function chat($method, $params = array()){
	
    $params = array_merge(array(
        'domain' => null,
        'type' => null,
        'id-profile' => null,
        'message' => null,
        'order-by' => 'id',
        'order' => 'ASC'
    	), $params);

    switch ($method) {
    	case 'get':
    		$sql=mysql_query("SELECT * FROM `chat` WHERE `domain` = '".$params['domain']."' AND `id_profile` = '".$params['id-profile']."' ORDER BY `".$params['order-by']."` ".$params['order']."");

			$response = array();
			while($i = mysql_fetch_assoc($sql)) {
    			$response[] = $i;
				}
				return json_encode($response);
    		break;

    	case 'post':
    		if(mysql_query("INSERT INTO `chat` (`id`, `domain`, `type`, `id-profile`, `date`, `message`) VALUES (NULL, '".$params['domain']."', '".$params['type']."', '".$params['id-profile']."', '".date("Y-m-d H:i:s")."', '".$params['message']."' )")) {	
				$id = mysql_insert_id();
				$sql=mysql_query("SELECT * FROM `chat` WHERE `id` = '".$id."' LIMIT 1");
				$response = array();
				while($i = mysql_fetch_assoc($sql)) {
    				$response[] = $i;
				}
				array_push($response, "status", "correct");
				return json_encode($response);
				break;
			}
			else {
				$response = ['status'=>'error'];
				return json_encode($response);
			}

    		break;

    	default:
    		# code...
    		break;
    }


	}
}