<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */

class nodeController extends privilege{
	/**
	 * @var nodeView
	 */
	protected $view;
	/**
	 * @var nodeModule
	 */
	protected $model;
	public function __construct(){
		$this->_init();
	}
	public function welcomeAction(message $msg){
		$path = "/";
		if(isset($msg["?nodepath"])){
			$path = $msg["?nodepath"];
		}
		$info = $this->model->nodeInfo($path);
		if($info["nt"] == "file"){
			$this->view->go("/priv/nodeleaf?nodepath=".urlencode($path));
		}else{
			$this->view->showList($path,$this->model->getData($path));
		}
	}
	public function removeAction(message $msg){
		if(!isset($msg["?path"])){
			$this->view->_404();
			return ;
		}
		try{
			$this->model->remove($msg["?path"]);
			return $this->view->showOk("删除成功");
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
			ENTRY_HOME."/priv/node/append",
			$this->model->getTypes(),
			$this->model->getLabels(),
			$this->model->defaultNodeValue()
		);
	}
	public function editAction(message $msg){
		if(!isset($msg["?path"])){
			$this->view->_404();
			return ;
		}
		
//		var_dump($this->model->nodeInfo($msg["?path"]));exit;
		$data = $this->model->nodeInfo($msg["?path"]);
//		var_dump($data);exit;
		if(empty($data)){
			$this->view->showFail("invalid path.");
			return ;
		}
		$this->view->edit(
			$msg["?path"], 
			ENTRY_HOME."/priv/node/update",
			$this->model->getTypes(),
			$this->model->getLabels(),
			$data
		);
	}
	public function appendAction(message $msg){
//		$this->view->_404();
		if(!isset($msg["nodepath"],$msg["nt"],$msg["key"],$msg["order"],$msg["type"])){
			$this->view->_404();
			return ;
		}
		if(!isset($msg["label"])){
			$label = array();
		}else{
			$label = $msg["label"];
		}
		try{
			$this->model->append($msg["nodepath"],$msg["nt"],$msg["key"],$msg["order"],$msg["type"],$label);
			return $this->view->showOk("添加成功",ENTRY_HOME."/priv/node?nodepath=".urlencode(
				($msg["nodepath"])
			));
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function updateAction(message $msg){
//		$this->view->_404();
		if(!isset($msg["nodepath"],$msg["key"],$msg["order"],$msg["type"])){
			$this->view->_404();
			return ;
		}
		if(!isset($msg["label"])){
			$label = array();
		}else{
			$label = $msg["label"];
		}
		try{
			$this->model->update($msg["nodepath"],$msg["key"],$msg["order"],$msg["type"],$label);
			return $this->view->showOk("更新成功",ENTRY_HOME."/priv/node?nodepath=".urlencode(
				DataSrcPath::getParentPath($msg["nodepath"])
			));
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function testAction(message $msg){
		
	}
}