<?php
/**
 * Date: 2014-12-29
 * Author: Awei.tian
 * function: 
 */
class apiFactory{
	/**
	 * 
	 * @param string 相对于API目录下的路径,以/开头
	 * @throws Exception
	 */
	public static function create($path){
		if(!preg_match("#^[\w/]+$#",$path)){
			throw new Exception("invalid path",0x3);
		}
		$path = ENTRY_PATH."/app/api".$path.".php";
		$info = basename($path,".php");
		if(!file_exists($path)){
			throw new Exception("invalid path:".$path,0x89);
		}
		require_once $path;
		return new $info();
	}
}