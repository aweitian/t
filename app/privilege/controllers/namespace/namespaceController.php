<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */
require_once ENTRY_PATH."/app/data/datasrc/DataSrcPath.php";

class namespaceController extends privilege{
	/**
	 * @var namespaceView
	 */
	protected $view;
	/**
	 * @var namespaceModule
	 */
	protected $model;
	public function __construct(){
		$this->_init();
	}
	public function welcomeAction(message $msg){
		$path = "/";
		if(isset($msg["?path"])){
			$path = $msg["?path"];
		}
//		var_dump($this->model->getData($path));exit;
		$info = $this->model->info($path);
// 		var_dump($info);exit;
		if($info["nt"]=="file"){
			$this->view->go("/priv/datasrc?path=".urlencode($path));
		}else{
			$this->view->showList(new DataSrcPath($path),$this->model->getData($path));
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
			ENTRY_HOME."/priv/namespace/append",
			$this->model->defaultValue(),
			$this->model->getDaArr()
		);
	}
	public function editAction(message $msg){
		if(!isset($msg["?path"])){
			$this->view->_404();
			return ;
		}
		
//		var_dump($this->model->info($msg["?path"]));exit;
		$data = $this->model->info($msg["?path"]);
//		var_dump($data);exit;
		if(empty($data)){
			$this->view->showFail("invalid path.");
			return ;
		}
		$this->view->edit(
			$msg["?path"], 
			ENTRY_HOME."/priv/namespace/update",
			$data,
			$this->model->getDaArr()
		);
	}
	public function appendAction(message $msg){
//		$this->view->_404();
		if(!isset($msg["path"],$msg["nt"],$msg["key"],$msg["order"],$msg["da"])){
			$this->view->_404();
			return ;
		}
		try{
			$this->model->append($msg["path"],$msg["nt"],$msg["key"],$msg["order"],$msg["da"]);
			return $this->view->showOk("添加成功",ENTRY_HOME."/priv/namespace?path=".urlencode($msg["path"]));
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function updateAction(message $msg){
//		$this->view->_404();
		if(!isset($msg["path"],$msg["order"],$msg["da"])){
			$this->view->_404();
			return ;
		}
		if(!isset($msg["label"])){
			$label = array();
		}else{
			$label = $msg["label"];
		}
		try{
			$p = new DataSrcPath($msg["path"]);
			$this->model->update($msg["path"],basename($p->getNsPath()),$msg["order"],$msg["da"]);
			$ns_parent = DataSrcPath::getParentPath($p->getNsPath());
			$p->setNsPath($ns_parent);
			return $this->view->showOk("更新成功",ENTRY_HOME."/priv/namespace?path=".urlencode($p->toString()));
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function testAction(message $msg){
		
	}
}