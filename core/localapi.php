<?php
#localAPI
class localAPI {

	public static function post($post = array()){

		 $post = array_merge(array(
        'domain' => $_SERVER['HTTP_HOST'],
  		'url' => $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
        'type' => 'contact',
        'message' => null,
        'token' => $_COOKIE['token'],
        'device' => $_COOKIE['device']
    	), $post);

		 if($post['message']==null || $post['message']==''){
		 	$return['status']='409';
		 }
		 else {
		 	$return['status']='201';
		 }

		return json_encode($return);
	}

}