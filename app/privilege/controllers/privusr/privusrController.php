<?php
/**
 * @author:awei.tian
 * @date: 2015-4-9
 * @functions:
 */
require_once ENTRY_PATH."/app/modules/auth/privUsrAuth.php";
require_once ENTRY_PATH."/app/api/privilege/data/privUsrApi.php";
class privusrController extends privilege{
	/**
	 * @var privusrView
	 */
	protected $view;
	/**
	 * @var privusrModel
	 */
	protected $model;
	public function __construct(){
		$this->_init();
	}
	public function welcomeAction(message $msg){
		$this->view->showList($this->model->getData());
	}
	public function removeAction(message $msg){
		if(!isset($msg["?sid"])){
			$this->view->_404();
		}
		//权限检查
		
		if(!$this->_check_remove_priv($msg["?sid"])){
			$this->view->showFail("默认用户不能删除");
			return ;
		}
		if(!$this->_check_remove_priv($msg["?sid"])){
			$this->view->showFail("默认用户不能删除");
			return ;
		}
		
		if($this->model->remove($msg["?sid"])){
			$this->view->showOk("删除成功");
		}else{
			$this->view->showFail("删除失败");
		}
	}
	public function replyAction(message $msg){
		if($msg->getHttpRequest()->isPost()){
			if(!isset($msg["sid"],$msg["reply"])){
				$this->view->_404();
			}
			if($this->model->reply($msg["sid"],$msg["reply"])){
				$this->view->showOk("更新成功");
			}else{
				$this->view->showFail("更新失败");
			}
		}else{
			if(!isset($msg["?sid"])){
				$this->view->_404();
			}
			$this->view->reply($this->model->getDataBySid($msg["?sid"]));
		}
	}
	
	private function _check_remove_priv($sid){
		$data = $this->model->getDataBySid($sid);
		return $data["name"] !== "Apocalypse";
	}
	public static function hasPriv($name){
		if($name == "Apocalypse")return true;
		if($name == "qq")return true;
		$info = (tian::$context->getIdentityToken()->getInfo());
		return $name === $info["name"];
	}
}