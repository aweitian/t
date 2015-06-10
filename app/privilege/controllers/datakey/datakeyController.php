<?php
/**
 * @author:awei.tian
 * @date: 2014-11-16
 * @functions:
 */
class datakeyController extends privilege{
	/**
	 * @var datakeyView
	 */
	protected $view;
	/**
	 * @var datakeyModule
	 */
	protected $model;
	public function __construct(){
		$this->_init();
	}
	public function welcomeAction(message $msg){
		$path = "/?";
		if(isset($msg["?nodepath"])){
			$path = $msg["?nodepath"];
		}
//		var_dump($this->model->getData($path));exit;
		$this->view->showList($path,$this->model->getData($path));
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
			ENTRY_HOME."/priv/datakey/append",
			$this->model->defaultValue()
		);
	}
	public function appendAction(message $msg){
//		$this->view->_404();
		if(!isset($msg["nodepath"],$msg["dstype"],$msg["key"],$msg["deco"],$msg["comment"],$msg["nsroottype"])){
			$this->view->_404();
			return ;
		}
		try{
			$this->model->append($msg["nodepath"],$msg["dstype"],$msg["key"],$msg["deco"],$msg["comment"],$msg["nsroottype"]);
			return $this->view->showOk("添加成功",ENTRY_HOME."/priv/datakey?nodepath=".urlencode($msg["nodepath"]."?"));
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function updateAction(message $msg){
//		$this->view->_404();
		if(!isset($msg["path"],$msg["key"],$msg["deco"],$msg["comment"])){
			$this->view->_404();
			return ;
		}
		try{
			$this->model->update($msg["path"],$msg["key"],$msg["deco"],$msg["comment"]);
			$tmp = explode("?",$msg["path"]);
			return $this->view->showOk("更新成功",ENTRY_HOME."/priv/datakey?nodepath=".urlencode($tmp[0]."?"));
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function updatedstypeAction(message $msg){
//		$this->view->_404();
		if(!isset($msg["path"],$msg["dstype"])){
			$this->view->_404();
			return ;
		}
		try{
			$this->model->updatedstype($msg["path"],$msg["dstype"]);
			$tmp = explode("?",$msg["path"]);
			return $this->view->showOk("更新成功",ENTRY_HOME."/priv/datakey?nodepath=".urlencode($tmp[0]."?"));
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function editAction(message $msg){
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
		$this->view->edit(
			$msg["?path"], 
			ENTRY_HOME."/priv/datakey/update",
			$data
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
			ENTRY_HOME."/priv/datakey/updatedstype",
			$data
		);
	}
	public function testAction(message $msg){
		$this->view->_404();
	}
}