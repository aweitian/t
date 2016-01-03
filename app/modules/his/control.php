<?php
/**
 * Date: 2016-01-01
 * Author: Awei.tian
 * Description: 
 */
require_once FILE_SYSTEM_ENTRY.'/app/modules/his/model.php';
require_once FILE_SYSTEM_ENTRY.'/app/modules/his/view.php';
class hisController extends Controller{
	private $did;
	private $pageSize = 10;
	/**
	 * 
	 * @var hisModel
	 */
	private $model;
	/**
	 * 
	 * @var hisView
	 */
	private $view;
	public function __construct(){
		if(!roleSession::getInstance()->isLogined()){
			$this->redirect("/login");
		}
		if(!isset($_GET["sid"])){
			$this->err();
		}
		$this->did = intval($_GET["sid"]);
		if ($this->did < 1){
			$this->err();
		}
		$this->model = new hisModel();
		$this->view = new hisView();
	}
	private function err(){
		$this->_404();
	}
	public function welcomeAction(){
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
		
		$data = $this->model->getList($this->did);
		if (empty($data["data"])){
			$this->err();
		}
		$this->view->wrap($this->view->getList(
			$data
		))->show();
	}
	public function addAction(){
		if ($this->isPost()){
			
			if (!isset($_POST["did"],
					$_POST["exhaust"],
					$_POST["op_date"],
					$_POST["mark"])){
				$this->_404();
				exit;
			}
			$result = $this->model->add(
					$_POST["did"],
					$_POST["exhaust"],
					
					$_POST["mark"],
					$_POST["op_date"]
			);
			if ($result){
				$this->addUI(array("msg"=>"添加成功","rmtime"=>$this->model->getRemains($_POST["did"])));
			}else{
				$this->addUI(array("msg"=>"添加失败","rmtime"=>$this->model->getRemains($_POST["did"])));
			}
		}else{
			if (!$this->model->hasOrder($this->did)){
				$this->err();
			}
			$this->addUI(array("msg"=>"","rmtime"=>$this->model->getRemains($this->did)));
		}
	
	}
	public function editAction(){
		if ($this->isPost()){
			if (!isset(
					$_POST["sid"],
					$_POST["exhaust"],
					$_POST["op_date"],
					$_POST["mark"])){
				$this->_404();;
			}
			$result = $this->model->update(
					$_POST["sid"],
					$_POST["exhaust"],
					$_POST["mark"],
					$_POST["op_date"]
			);
			if ($result){
				$this->editUI("编辑成功");
			}else{
				$this->editUI("编辑失败");
			}
	
		}else{
			if(!isset($_GET["sid"])){
				$this->_404();
			}
			$this->editUI();
		}
	
	}
	private function editUI($msg=""){
		$data = $this->model->getRow($_GET["sid"]);
		if(!$data){
			$this->_404();
		}
		$bodyHTML = $this->view->fetch("edit",array(
			"msg" => $msg,
			"def" => $data,
			"rmtime"=>$this->model->getRemains($data["did"])
		));
		$this->view->wrap($bodyHTML)->show();
	}
	private function addUI($msg){
		$bodyHTML = $this->view->fetch("add",$msg);
		$this->view->wrap($bodyHTML)->show();
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