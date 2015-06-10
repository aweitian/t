<?php
/**
 * @author:awei.tian
 * @date: 2014-11-16
 * @functions:
 */
class nodelabelController extends privilege{
	/**
	 * @var nodelabelView
	 */
	protected $view;
	/**
	 * @var nodelabelModule
	 */
	protected $model;
	public function __construct(){
		$this->_init();
	}
	public function welcomeAction(message $msg){
		$this->view->showlist($this->model->getData());
	}
	public function removeAction(message $msg){
		if(!isset($msg["?lk"])){
			$this->view->_404();
			return ;
		}
		try{
			$row = $this->model->remove($msg["?lk"]);
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
			ENTRY_HOME."/priv/nodelabel/append",
			$this->model->defaultValue()
		);
	}
	public function appendAction(message $msg){
		if(!isset($msg["lv"])){
			$this->view->_404();
			return ;
		}
		try{
			$this->model->append($msg["lv"]);
			return $this->view->showOk("添加成功",ENTRY_HOME."/priv/nodelabel");
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function updateAction(message $msg){
		if(!isset($msg["lv"],$msg["lk"])){
			$this->view->_404();
			return ;
		}
		try{
			$this->model->update($msg["lk"],$msg["lv"]);
			return $this->view->showOk("更新成功",ENTRY_HOME."/priv/nodelabel");
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function editAction(message $msg){
		if(!isset($msg["?lk"])){
			$this->view->_404();
			return ;
		}
////		var_dump($this->model->nodeInfo($msg["?path"]));exit;
		$data = $this->model->info($msg["?lk"]);
//		var_dump($data);exit;
		if(empty($data)){
			$this->view->showFail("invalid lk.");
			return ;
		}
		$this->view->edit(
			ENTRY_HOME."/priv/nodelabel/update",
			array(
				"lk"=>$msg["?lk"],
				"lv"=>$data
			)
		);
	}
	public function testAction(message $msg){
		$this->view->_404();
	}
}