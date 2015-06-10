<?php
/**
 * @author awei.tian
 * date: 2013-9-18
 * 说明:
 */
class userController extends controller{
	public static function _checkPrivilege(message $msg,identityToken $it){
		return true;
	}
	public function welcome(){
		echo "aa was dispalyed";
	}
	public function bbAction(message $msg){
		var_dump($msg);
	}
	public function hypAction(message $msg){
		echo $msg["?aa"];
	}
	private function isLogined(){
		
	}
}