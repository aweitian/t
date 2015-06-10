<?php
/**
 * @author awei.tian
 * date: 2013-11-7
 * 说明:
 */
class event{
	private static $_listenen=array();
	public static function on($type,$callback,$args=array()){
		if(!array_key_exists($type,self::$_listenen)){
			self::$_listenen[$type]=array();
		}
		self::$_listenen[$type]["callback"]=$callback;
		self::$_listenen[$type]["args"]=$args;
	}
	public static function raise($type){
		if(!array_key_exists($type,self::$_listenen))return ;
		foreach (self::$_listenen as $listenen){
			call_user_func_array($listenen["callback"],$listenen["args"]);
		}
	}
}