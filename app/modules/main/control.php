<?php
/**
 * Date: 2016-01-09
 * Author: Awei.tian
 * Description: 
 */
require_once FILE_SYSTEM_ENTRY.'/app/modules/main/model.php';
require_once FILE_SYSTEM_ENTRY.'/app/modules/main/view.php';
class mainController extends AuthController{
	/**
	 * 
	 * @var mainModel
	 */
	private $model;
	/**
	 * 
	 * @var mainView
	 */
	private $view;
	public static function _checkPrivilege() {
		return true;
	}
	public function __construct(){
		if(!roleSession::getInstance()->isLogined()){
			$this->go("login","");
		}
		$this->model = new mainModel();
		$this->view = new mainView();
	}
	public function welcomeAction(){
		$this->searchAction();
	}
	public function editwordAction(){
		if($this->isPost()){
			return $this->updateWord();
		}
		$this->showWord();
	}
	private function updateWord(){
		if(isset($_POST["w"])){
			$r = $this->model->putWords(roleSession::getInstance()->getUserID(), $_POST["w"]);
		}else{
			$r = false;
		}
		$this->showWord($r,$r ? "编辑成功":"编辑失败");
	}
	private function showWord($r=true,$msg=""){
		$this->view->wrap(
				$this->view->fetch(
						"editword",
						array(
							"result"=>$r,
							"msg"=>$msg,
							"content"=>$this->model->getWords(roleSession::getInstance()->getUserID())
						)
				)
		)->show();
	}
	public function editurlAction(){
		if($this->isPost()){
			return $this->updateUrl();
		}
		$this->showurl();
	}
	
	private function showurl($r=true,$msg=""){
		$this->view->wrap(
				$this->view->fetch(
						"editurl",
						array(
								"result"=>$r,
								"msg"=>$msg,
								"content"=>$this->model->getUrls(roleSession::getInstance()->getUserID())
						)
				)
		)->show();
	}
	private function updateUrl(){
		if(isset($_POST["u"])){
			$r = $this->model->putUrls(roleSession::getInstance()->getUserID(), $_POST["u"]);
		}else{
			$r = false;
		}
		$this->showurl($r,$r ? "编辑成功":"编辑失败");
	}
	
	public function searchAction(){
		$this->view->wrap($this->view->showTask(
			$this->model->getUrls(roleSession::getInstance()->getUserID())		
		))->show();
	}
}