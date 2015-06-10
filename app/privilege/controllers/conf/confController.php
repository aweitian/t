<?php
/**
 * @author:awei.tian
 * @date: 2014-11-16
 * @functions:
 */
class confController extends privilege{
	/**
	 * @var confView
	 */
	protected $view;
	/**
	 * @var confModule
	 */
	protected $model;
	public function __construct(){
		$this->_init();
	}
	public function welcomeAction(message $msg){
		if(!isset($msg["?path"])){
			$this->view->_404();
		}
//		var_dump($this->model->getData($msg["?path"]));exit;
		$this->view->conf($msg["?path"],$this->model->getData($msg["?path"]));
	}
	public function removeAction(message $msg){
		if(!isset($msg["?path"])){
			$this->view->_404();
			return ;
		}
		try{
			$row = $this->model->remove($msg["?path"]);
			if($row > 0)
			return $this->view->showOk("删除成功");
			else
			return $this->view->showFail("参数错误");
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function addAction(message $msg){
		if(!isset($msg["?path"])){
			$this->view->_404();
			return ;
		}
		$this->view->add(
			$msg["?path"], 
			ENTRY_HOME."/priv/conf/append",
			$this->model->getData($msg["?path"])
		);
	}
	public function appendAction(message $msg){
		try{
			$this->model->append($msg);
			$tmp = explode("?",$msg["path"]);
			return $this->view->showOk("添加成功",ENTRY_HOME."/priv/confkey?path=".urlencode($tmp[0]."?"));
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function updateAction(message $msg){
		try{
			$this->model->update($msg);
			$tmp = explode("?",$msg["path"]);
			return $this->view->showOk("更新成功",ENTRY_HOME."/priv/confkey?path=".urlencode($tmp[0]."?"));
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function editAction(message $msg){
		if(!isset($msg["?path"])){
			$this->view->_404();
			return ;
		}
////		var_dump($this->model->nodeInfo($msg["?path"]));exit;
		$data = $this->model->getData($msg["?path"]);
//		var_dump($data);exit;
		if(empty($data)){
			$this->view->showFail("invalid path.");
			return ;
		}
		$this->view->edit(
			$msg["?path"], 
			ENTRY_HOME."/priv/conf/update",
			$data
		);
	}
	public function testAction(message $msg){
		$this->view->_404();
	}
}