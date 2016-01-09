<?php
/**
 * Date: 2016-01-04
 * Author: Awei.tian
 * Description: 
 */
require_once FILE_SYSTEM_ENTRY.'/app/modules/user/model.php';
require_once FILE_SYSTEM_ENTRY.'/app/modules/user/view.php';
class userController extends AuthController{
	/**
	 * 
	 * @var userModel
	 */
	private $model;
	/**
	 * 
	 * @var userView
	 */
	private $view;
	public static function _checkPrivilege() {
		return true;
	}
	public function __construct(){
		$this->role = roleSession::getInstance();
		if(!$this->role->isLogined()){
			$this->redirect("/login");
		}
		$this->model = new userModel();
		$this->view = new userView();
		
	}
	public function welcomeAction(){
		$this->checkPriv("user-list");
		$this->view->wrap($this->view->getList(
			$this->model->getList()
		))->show();
	}
	public function addAction(){
		$this->checkPriv("user-add");
		if ($this->isPost()){
			
			if (!isset($_POST["name"],
					$_POST["pass"],
					$_POST["role"])){
				$bodyHTML = $this->view->fetch("add",array("msg"=>"添加失败"));
				$this->view->wrap($bodyHTML)->show();
				exit;
			}
			$result = $this->model->add(
					$_POST["name"],
					$_POST["pass"],
					$_POST["role"]
			);
			if ($result){
				$bodyHTML = $this->view->fetch("add",array("msg"=>"添加成功"));
			}else{
				$bodyHTML = $this->view->fetch("add",array("msg"=>"添加失败:"));
			}
				
			$this->view->wrap($bodyHTML)->show();
		}else{
			$bodyHTML = $this->view->fetch("add");
			$this->view->wrap($bodyHTML)->show();
		}
	
	}
	public function resetpwdAction(){
		$this->editAction();
	}
	public function editAction(){
		$this->checkPriv("user-resetpwd");
		if ($this->isPost()){
			if (!isset($_POST["pass"],$_POST["sid"])){
				$this->_404();
			}
			$result = $this->model->updatePwdSuper(
					$_POST["sid"],
					$_POST["pass"]
			);
			if ($result){
				$bodyHTML = $this->view->fetch("edit",array("msg"=>"重置成功"));
			}else{
				$msg = $this->model->debug()->getErrorInfo();
				$bodyHTML = $this->view->fetch("edit",array("msg"=>"重置失败:".$msg));
			}
	
			$this->view->wrap($bodyHTML)->show();
		}else{
			if(!isset($_GET["sid"])){
				$this->_404();
			}
			$data = $this->model->getRow($_GET["sid"]);
			if(!$data){
				$this->_404();
			}
			$bodyHTML = $this->view->fetch("edit",array(
					"def" => $data
			));
			$this->view->wrap($bodyHTML)->show();
		}
	
	}
	public function chpwdAction(){
		$this->checkPriv("user-chpwd");
		if ($this->isPost()){
			if (!isset($_POST["pass"],$_POST["oldpass"])){
				$this->_404();
			}
			$result = $this->model->updatePwd(
					roleSession::getInstance()->getUserID(),
					$_POST["oldpass"],
					$_POST["pass"]
			);
			if ($result){
				$bodyHTML = $this->view->fetch("chpwd",array("msg"=>"密码修改成功"));
			}else{
				$bodyHTML = $this->view->fetch("chpwd",array("msg"=>"密码修改失败:"));
			}
	
			$this->view->wrap($bodyHTML)->show();
		}else{
			$bodyHTML = $this->view->fetch("chpwd");
			$this->view->wrap($bodyHTML)->show();
		}
	
	}
	public function rmAction(){
		$this->checkPriv("user-rm");
		if (!isset($_GET["sid"])){
			$this->_404();
		}
		$sid = intval($_GET["sid"]);
		$this->model->rm($sid);
		$this->back();
	}
}