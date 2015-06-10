<?php
/**
 * @author awei.tian
 * date: 2015-2-12
 * 说明:
 */
require_once LIB_PATH."/interfaces/IDispatcher.php";
require_once LIB_PATH."/mvc/dispatcher/AController.php";
require_once ENTRY_PATH."/app/".SVC_NAME."/".SVC_NAME."Controller.php";
C::addAutoloadPath("message", LIB_PATH."/mvc/message/message.php");

class noActionDispatcher implements IDispatcher{
	private $msg;
	private $pi;
	private $ret;
	public function __construct(message $msg){
// 		var_dump(tian::$context->getRouter()->getMatchedRouteName());
		if(tian::$context->getRouter()->getMatchedRouteName() == SVC_NAME){
			$this->msg = $msg;
			$this->pi = tian::getContext()->getRouter()->getRoute()->getActionPath();	
			$this->ret = true;		
		}else{
			$this->ret = false;
		}

	}
	/**
	 * 返回是否派遣成功
	 */
	public function dispatch(){
		if($this->ret){
			new svcController($this->msg,$this->pi);
			return true;			
		}else{
			return false;
		}

	}
	public function debug(){
		echo "debug msg @ noActionDispatcher,pi:".$this->pi;
	}
}