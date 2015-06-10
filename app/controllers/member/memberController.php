<?php
/**
 * @author awei.tian
 * date: 2015-5-7
 * 说明:login/logout都接受get 方式,return 参数
 */
require_once ENTRY_PATH."/app/themesData/member/member.php";
require_once ENTRY_PATH."/app/modules/member/memberModule.php";
require_once ENTRY_PATH."/app/modules/auth/memberAuth.php";
class memberController extends appController{
	/**
	 * @var memberView
	 */
	protected $view;
	/**
	 * @var memberModel
	 */
	protected $model;
	
	public function __construct(){
		$this->_init();
		
	}
	public function welcomeAction(message $msg){
		if($this->model->isLogined()){
			$this->profileAction($msg);
		}else{
			$this->loginAction($msg);
		}
	}
	public function profileAction(){
		if($this->model->isBlocked()){
			$this->view->_404();
		}
		if(!$this->model->isLogined()){
			$this->view->go("/member/login");
		}
		$this->view->profile($this->model->getProfile());
		//echo $this->model->getLoginedEml();
	}
	public function logoutAction(message $msg){
		$this->model->auth->logout();
		if(isset($msg["?return"])){
			$this->view->redirect($msg["?return"]);
		}else{
			$this->view->go("/member/login");
		}
	}
	public function loginAction(message $msg){
		if($this->model->isBlocked()){
			$this->view->_404();
		}
		if($this->model->isLogined()){
			if(isset($msg["?return"])){
				$this->view->redirect($msg["?return"]);
			}else{
				$this->view->go("/member/profile");
			}
			
		}
		if($msg->getHttpRequest()->isPost()){
			if(!isset($msg["id"],$msg["pwd"])){
				$this->view->_404();
			}
			if(isset($msg["code"])){
				$code = $msg["code"];
			}else{
				$code = "";
			}
			if($this->model->login($msg["id"], $msg["pwd"], $code)){
				$this->view->go("/member/profile");
			}else{
				$this->view->go("/member/login");
			}
		}else{
			$this->view->login();
		}
	}
	public function registerAction(message $msg){
		if($this->model->isBlocked()){
			$this->view->_404();
		}
		if($msg->getHttpRequest()->isPost()){
			if(!isset($msg["email"],$msg["pswod"],$msg["nknme"],$msg["fname"],$msg["lname"]
					,$msg["squst"],$msg["sqkey"],$msg["phone"],$msg["mssnn"]
					,$msg["aimmm"],$msg["yahoo"])){
				$this->view->_404();
			}
			if($this->model->register($msg["email"],$msg["nknme"],$msg["pswod"],$msg["fname"],$msg["lname"]
					,$msg["squst"],$msg["sqkey"],$msg["phone"],$msg["mssnn"]
					,$msg["aimmm"],$msg["yahoo"])){
				$msg["id"]  = $msg["email"];
				$msg["pwd"] = $msg["pswod"];
				$this->loginAction($msg);
			}else{
				//$this->view->showErr($this->model->errorMsg);
				$this->view->register($this->model->errorMsg);
			}
		}else{
			$this->view->register();
		}
		
	}
}