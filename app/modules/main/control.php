<?php
/**
 * Date: 2015-12-31
 * Author: Awei.tian
 * Description: 
 */
require_once FILE_SYSTEM_ENTRY.'/app/modules/main/model.php';
require_once FILE_SYSTEM_ENTRY.'/app/modules/main/view.php';
class mainController extends AuthController{
	private $pageSize = 10;
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
			$this->redirect("/login");
		}
		$this->model = new mainModel();
		$this->view = new mainView();
		
	}
	public function welcomeAction(){
		if (isset($_GET['sid'])){
			$this->detailAction();
			return ;
		}
		$this->listAction();
	}
	public function detailAction(){
		$this->view->wrap($this->view->detail(
				$this->model->detail($_GET['sid'])
		))->show();
	}
	public function addAction(){
		if ($this->isPost()){
			if (!isset($_POST["price"],
				$_POST["time"],
				$_POST["con_type"],
				$_POST["con_val"],
				$_POST["gm_name"],
				$_POST["char_name"],
				$_POST["pay_type"],
				$_POST["ad_from"],
				$_POST["op_name"])){
				$bodyHTML = $this->view->fetch("add",array("msg"=>"添加失败"));
				$this->view->wrap($bodyHTML)->show();
				exit;
			}
			$result = $this->model->add(
				$_POST["price"],
				$_POST["time"],
				$_POST["con_type"],
				$_POST["con_val"],
				$_POST["gm_name"],
				$_POST["char_name"],
				$_POST["pay_type"],
				$_POST["ad_from"],
				$_POST["op_name"]
			);
			if ($result){
				$bodyHTML = $this->view->fetch("add",array("msg"=>"添加成功"));
			}else{
				$msg = $this->model->debug()->getErrorInfo();
				$bodyHTML = $this->view->fetch("add",array("msg"=>"添加失败:".$msg));
			}
			
			$this->view->wrap($bodyHTML)->show();
		}else{
			$bodyHTML = $this->view->fetch("add");
			$this->view->wrap($bodyHTML)->show();
		}
		
	}
	public function editAction(){
		if ($this->isPost()){
			if (!isset($_POST["price"],
					$_POST["sid"],
					$_POST["time"],
					$_POST["con_type"],
					$_POST["con_val"],
					$_POST["gm_name"],
					$_POST["char_name"],
					$_POST["pay_type"],
					$_POST["ad_from"],
					$_POST["op_name"])){
				$this->_404();;
			}
			$result = $this->model->update(
					$_POST["sid"],
					$_POST["price"],
					$_POST["time"],
					$_POST["con_type"],
					$_POST["con_val"],
					$_POST["gm_name"],
					$_POST["char_name"],
					$_POST["pay_type"],
					$_POST["ad_from"],
					$_POST["op_name"]
			);
			if ($result){
				$bodyHTML = $this->view->fetch("edit",array("msg"=>"编辑成功"));
			}else{
				$msg = $this->model->debug()->getErrorInfo();
				$bodyHTML = $this->view->fetch("edit",array("msg"=>"编辑失败:".$msg));
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
	public function listAction(){
		if (isset($_GET["pn"])){
			$pn = intval($_GET["pn"]);
		}else{
			$pn = 1;
		}
		if($pn<1){
			$pn = 1;
		}
		$offset = ($pn-1) * $this->pageSize;
		$limit = $this->pageSize;

		
		$this->view->wrap($this->view->getList(
			$this->model->getList($offset, $limit)
		))->show();
	}
	public function rmAction(){
		if (!isset($_GET["sid"])){
			$this->_404();
		}
		$sid = intval($_GET["sid"]);
		$this->model->rm($sid);
		$this->back();
	}
}