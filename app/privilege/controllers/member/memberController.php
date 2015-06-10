<?php
/**
 * @author:awei.tian
 * @date: 2015-4-9
 * @functions:
 */
class memberController extends privilege{
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
		if(isset($msg["?page"])){
			$cur = $msg["?page"] - 1;
			if($cur < 0){
				$cur = 0;
			}
		}else{
			$cur = 0;
		}
		$this->view->showList($this->model->getData($cur),$cur,"");
	}
	public function searchAction(message $msg){
		if(isset($msg["?page"])){
			$cur = $msg["?page"] - 1;
			if($cur < 0){
				$cur = 0;
			}
		}else{
			$cur = 0;
		}
		$this->view->showList($this->model->getDataByCond($cur,$msg["?cond"]),$cur,$msg["?cond"]);
	}
	public function removeAction(message $msg){
		if(!isset($msg["?sid"])){
			$this->view->_404();
		}
		if($this->model->remove($msg["?sid"])){
			$this->view->showOk("删除成功");
		}else{
			$this->view->showFail("删除失败");
		}
	}
	public function updateAction(message $msg){
		if($msg->getHttpRequest()->isPost()){
			if(!isset($msg["eml"],$msg["rank"],$msg["vid"],$msg["cnsm"])){
				$this->view->_404();
			}
			if($this->model->update($msg["eml"],$msg["rank"],$msg["vid"],$msg["cnsm"])){
				$this->view->showOk("更新成功");
			}else{
				$this->view->showFail("更新失败");
			}
		}else{
			if(!isset($msg["?sid"])){
				$this->view->_404();
			}
			$this->view->update($this->model->getDataBySid($msg["?sid"]));
		}
	}
	public function resetpwdAction(message $msg){
		if($msg->getHttpRequest()->isPost()){
			if(!isset($msg["eml"],$msg["pwd"],$msg["sid"])){
				$this->view->_404();
			}
			if($this->model->resetpwd($msg["eml"],$msg["pwd"],$msg["sid"])){
				$this->view->showOk("更新成功");
			}else{
				$this->view->showFail("更新失败");
			}
		}else{
			if(!isset($msg["?sid"])){
				$this->view->_404();
			}
			$this->view->resetpwd($this->model->getDataBySid($msg["?sid"]));
		}
	}
	public function viewAction(message $msg){

		if(!isset($msg["?sid"])){
			$this->view->_404();
		}
		$this->view->view($this->model->getDataBySid($msg["?sid"]));

	}
}