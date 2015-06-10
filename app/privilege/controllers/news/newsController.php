<?php
/**
 * @author:awei.tian
 * @date: 2015-4-9
 * @functions:
 */
require_once ENTRY_PATH."/app/modules/auth/privUsrAuth.php";
class newsController extends privilege{
	/**
	 * @var newsView
	 */
	protected $view;
	/**
	 * @var newsModel
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
		$this->view->showList($this->model->getData($cur),$cur);
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
	public function upAction(message $msg){
		if(!isset($msg["?sid"],$msg["?f"])){
			$this->view->_404();
		}
		if($this->model->up($msg["?sid"],$msg["?f"])){
			$this->view->showOk("成功");
		}else{
			$this->view->showFail("失败");
		}
	}
	public function editAction(message $msg){
		if(!isset($msg["?sid"])){
			$this->view->_404();
		}
		$this->view->edit($this->model->getDataBySid($msg["?sid"]));
	}
	public function addAction(message $msg){
		$this->view->add($this->model->getDefData());
	}
	public function updateAction(message $msg){
		if(!isset(
				$msg["sid"],
				$msg["title"],
				$msg["content"],
				$msg["lnk"],
				$msg["sldimg"],
				$msg["sldflg"],
				$msg["sldorder"]
		)){
			$this->view->_404();
		}
		if($this->model->update(
				$msg["sid"],
				$msg["title"],
				$msg["content"],
				$msg["lnk"],
				$msg["sldimg"],
				$msg["sldflg"],
				$msg["sldorder"])){
			$this->view->showOk("更新成功");
		}else{
			$this->view->showFail("更新失败");
		}
	}
	public function appendAction(message $msg){
		if(!isset(
				$msg["title"],
				$msg["content"],
				$msg["lnk"],
				$msg["sldimg"],
				$msg["sldflg"],
				$msg["sldorder"]
		)){
			$this->view->_404();
		}
		if($this->model->append(
				$msg["title"],
				$msg["content"],
				$msg["lnk"],
				$msg["sldimg"],
				$msg["sldflg"],
				$msg["sldorder"])){
			$this->view->showOk("添加成功");
		}else{
			$this->view->showFail("添加失败");
		}
	}
}