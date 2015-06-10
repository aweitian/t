<?php
/**
 * @author:awei.tian
 * @date:2013-12-5
 * @functions:在路由中加入了assets/base32就路由到这个文件来处理
 */
class assetsController extends controller{
	public function welcomeAction(message $msg){
		require_once LIB_PATH."/algorithms/base32.php";
		$base32=new base32();
		$assets_path=$base32->decode($msg[":0"]);
		
		$path_arr=explode("://",$assets_path,2);
		if(count($path_arr)!=2){
			tian::$context->getResponse()->_404();
			exit;
		}
		$consts=get_defined_constants(true);
		$consts=$consts["user"];
		if(!array_key_exists($path_arr[0], $consts)){
			tian::$context->getResponse()->_404();
			exit;
		}
		$file_path=$consts[$path_arr[0]]."/".$path_arr[1];
		//var_dump($file_path);
		if(file_exists($file_path)){
			tian::$context->getResponse()->readLocalAsHttpContent($file_path,$path_arr[0],$path_arr[1]);
			exit;
		}else{
			tian::$context->getResponse()->_404();
			exit;
		}
	}
	//css asset path fix move to response
}