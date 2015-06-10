<?php
/**
 * @author:awei.tian
 * @date: 2014-11-16
 * @functions:
 */
class widgetController extends privilege{
	/**
	 * @var widgetView
	 */
	protected $view;
	/**
	 * @var widgetModel
	 */
	protected $model;
	public function __construct(){
		$this->_init();
	}
	public function welcomeAction(message $msg){
		$msg->setControl("nodeleaf");
		$msg->setDispatchedState(dispatcher::DISPATCH_STATE_RESTART);
		tian::$context->getDispatcher("default")->dispatch();
	}
	public function listDkAction(message $msg){
		echo json_encode($this->model->autoCompleteDk($msg["?dk"]));
	}
	public function listCkAction(message $msg){
		echo json_encode($this->model->autoCompleteCk($msg["?ck"]));
	}
	
	
	
	
	public function removeAction(message $msg){
		if(!isset($msg["?path"])){
			$this->view->_404();
			return ;
		}
		if(!isset($msg["?order"])){
			$this->view->_404();
			return ;
		}
		try{
			$this->model->remove($msg["?path"],$msg["?order"]);
			return $this->view->showOk("删除成功",ENTRY_HOME."/priv/nodeleaf?nodepath=".urlencode($msg["?path"]));
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
			ENTRY_HOME."/priv/widget/append",
			$this->model->defaultValue($msg["?path"]),
			$this->model->getAllOrderTpl()
		);
	}
	public function appendAction(message $msg){
//		$this->view->_404();
		if(!isset($msg["path"],$msg["order"],$msg["typeid"],$msg["datasrcpath"],$msg["confpath"],$msg["ordertpl"],$msg["comment"])){
			$this->view->_404();
			return ;
		}
		try{
			$this->model->append($msg["path"],$msg["order"],$msg["typeid"],$msg["datasrcpath"],$msg["confpath"],$msg["ordertpl"],$msg["comment"]);
			return $this->view->showOk("添加成功",ENTRY_HOME."/priv/nodeleaf?nodepath=".urlencode($msg["path"]));
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function updateAction(message $msg){
//		$this->view->_404();
		if(!isset($msg["path"],$msg["old_order"],$msg["new_order"],$msg["typeid"],$msg["datasrcpath"],$msg["confpath"],$msg["ordertpl"],$msg["comment"])){
			$this->view->_404();
			return ;
		}
		try{
			$this->model->update($msg["path"],$msg["old_order"],$msg["new_order"],$msg["typeid"],$msg["datasrcpath"],$msg["confpath"],$msg["ordertpl"],$msg["comment"]);
			$tmp = explode("?",$msg["path"]);
			return $this->view->showOk("更新成功",ENTRY_HOME."/priv/nodeleaf?nodepath=".urlencode($msg["path"]));
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function editAction(message $msg){
		if(!isset($msg["?path"])){
			$this->view->_404();
			return ;
		}
		if(!isset($msg["?order"])){
			$this->view->_404();
			return ;
		}
//		
////		var_dump($this->model->nodeInfo($msg["?path"]));exit;
		$data = $this->model->info($msg["?path"],$msg["?order"]);
//		var_dump($data);exit;
		if(empty($data)){
			$this->view->showFail("invalid path.");
			return ;
		}
		$this->view->edit(
			$msg["?path"], 
			ENTRY_HOME."/priv/widget/update",
			$data,
			$this->model->getAllOrderTpl()
		);
	}
	public function editdstypeAction(message $msg){
		if(!isset($msg["?path"])){
			$this->view->_404();
			return ;
		}
//		
////		var_dump($this->model->nodeInfo($msg["?path"]));exit;
		$data = $this->model->info($msg["?path"]);
//		var_dump($data);exit;
		if(empty($data)){
			$this->view->showFail("invalid path.");
			return ;
		}
		$this->view->editdstype(
			$msg["?path"], 
			ENTRY_HOME."/priv/widget/updatedstype",
			$data
		);
	}
	public function testAction(message $msg){
		$this->view->_404();
	}
}