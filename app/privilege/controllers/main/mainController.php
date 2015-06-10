<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */
require_once ENTRY_PATH."/app/modules/auth/privUsrAuth.php";
class mainController extends privilege{
	public static function _checkPrivilege(message $msg,identityToken $it){
		if(privilege::_checkPrivilege($msg, $it)){
			return true;
		}
		tian::$context->getResponse()->_redirect(ENTRY_HOME."/priv/login");
		return false;
	}
	public function __construct(){
		$this->_init();
	}
	public function welcomeAction(message $msg){
		$this->view->go("/priv/node");
	}

}