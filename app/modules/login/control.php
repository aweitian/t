<?php
/**
 * Date: 2015-12-31
 * Author: Awei.tian
 * Description: 
 */
require_once FILE_SYSTEM_ENTRY.'/app/modules/login/model.php';
require_once FILE_SYSTEM_ENTRY.'/app/modules/login/view.php';
class loginController extends Controller{
	/**
	 * 
	 * @var loginModel
	 */
	private $model;
	/**
	 * 
	 * @var loginView
	 */
	private $view;
	public function __construct(){
		
		$this->model = new loginModel();
		$this->view = new loginView();
		
		if ($this->isPost()){
			$this->login();
		}else{
			if(roleSession::getInstance()->isLogined()){
				if(App::$router->getAction() == "logout"){
					return ;
				}else{
					$this->goHome();
				}
				
			}
			$this->loginUI();
		}
	}
	private function login(){
		$role = $this->model->checkNamePass($_POST["n"], $_POST["p"]);
		if("guest"==$role["role"]){
			$this->loginUI("登陆失败");
		}else{
			roleSession::getInstance()->setName($_POST["n"]);
			roleSession::getInstance()->setRole($role["role"]);
			roleSession::getInstance()->setUserID($role["sid"]);
			$this->goHome();
		}
	}
	private function loginUI($msg=""){
		
		$this->view->hideHeader()->wrap($this->view->fetch("form",array(
			"loginMsg"=>$msg
		)))->show();
	}
	public function logoutAction(){
		roleSession::getInstance()->loginOut();
		$this->redirect("/login");
	}
}