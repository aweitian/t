<?php
/**
 * @author:awei.tian
 * @date: 2015-4-9
 * @functions:
 */
require_once ENTRY_PATH."/app/modules/auth/privUsrAuth.php";
class feedbackController extends privilege{
	/**
	 * @var feedbackView
	 */
	protected $view;
	/**
	 * @var feedbackModel
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
}