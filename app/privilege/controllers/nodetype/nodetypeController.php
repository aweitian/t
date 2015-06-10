<?php
/**
 * @author:awei.tian
 * @date: 2014-11-16
 * @functions:
 */
class nodetypeController extends privilege{
	/**
	 * @var nodetypeView
	 */
	protected $view;
	/**
	 * @var nodetypeModule
	 */
	protected $model;
	public function __construct(){
		$this->_init();
	}
	public function welcomeAction(message $msg){
		$this->view->showlist($this->model->getData());
	}
	public function removeAction(message $msg){
		if(!isset($msg["?tk"])){
			$this->view->_404();
			return ;
		}
		try{
			$row = $this->model->remove($msg["?tk"]);
			if($row > 0)
			return $this->view->showOk("删除成功");
			else
			return $this->view->showFail("参数错误");
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function addAction(message $msg){
		$this->view->add(
			ENTRY_HOME."/priv/nodetype/append",
			$this->model->defaultValue()
		);
	}
	public function appendAction(message $msg){
		if(!isset($msg["tv"])){
			$this->view->_404();
			return ;
		}
		try{
			$this->model->append($msg["tv"]);
			return $this->view->showOk("添加成功",ENTRY_HOME."/priv/nodetype");
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function updateAction(message $msg){
		if(!isset($msg["tv"],$msg["tk"])){
			$this->view->_404();
			return ;
		}
		try{
			$this->model->update($msg["tk"],$msg["tv"]);
			return $this->view->showOk("更新成功",ENTRY_HOME."/priv/nodetype");
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function editAction(message $msg){
		if(!isset($msg["?tk"])){
			$this->view->_404();
			return ;
		}
////		var_dump($this->model->nodeInfo($msg["?path"]));exit;
		$data = $this->model->info($msg["?tk"]);
//		var_dump($data);exit;
		if(empty($data)){
			$this->view->showFail("invalid tk.");
			return ;
		}
		$this->view->edit(
			ENTRY_HOME."/priv/nodetype/update",
			array(
				"tk"=>$msg["?tk"],
				"tv"=>$data
			)
		);
	}
	public function testAction(message $msg){
		$this->view->_404();
	}
}