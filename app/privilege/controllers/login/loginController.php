<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */
require_once ENTRY_PATH."/app/modules/auth/privUsrAuth.php";
class loginController extends privilege{
	public static function _checkPrivilege(message $msg,identityToken $it){
		if(privilege::_checkPrivilege($msg, $it)){
			return true;
		}
		return $msg->getAction() === C::get("defaultAction");
	}
	public function welcomeAction(message $msg){
		$this->_loadView();
		$this->view = new loginView();
		$loginModule = new privUsrAuthModule();
		if($msg->getHttpRequest()->isPost()){
			$vc = "";
			if(isset($msg["code"])){
				$vc = $msg["code"];
			}
			$ret = $loginModule->checkByNamePwd($msg["name"], $msg["pwd"],$vc);
			if($ret){
				if(isset($msg["?returnurl"])){
					$this->view->redirect($msg["?returnurl"]);
				}else{
					$this->view->go("/priv");
				}
			}else{
				$this->view->go("/priv/login");
			}
		}else{
			if($loginModule->isLogined()){
				if(isset($msg["?returnurl"])){
					$this->view->redirect($msg["?returnurl"]);
				}else{
					$this->view->go("/priv");
				}
			}else{
				$uidata = $loginModule->getUiData();
				
				$this->view->showLoginUI($uidata);
			}
		}
	}
	public function logoutAction(message $msg){
		$loginModule = new privUsrAuthModule();
		$loginModule->logout();
		$this->_loadView();
		$this->view = new loginView();
		$this->view->go("/priv/login");
	}
	public function hypAction(message $msg){
		echo $msg["?aa"];
	}
}