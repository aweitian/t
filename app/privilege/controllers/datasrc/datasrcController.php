<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */
require_once ENTRY_PATH."/app/data/datasrc/DataSrcPath.php";
class datasrcController extends privilege{
	/**
	 * @var datasrcView
	 */
	protected $view;
	/**
	 * @var datasrcModule
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
		$data = $this->model->getData($path);
		if(empty($data["data"])){
			$this->view->add(new DataSrcPath($path),$this->model->getData($path));
		}else{
			$this->view->edit(new DataSrcPath($path),$this->model->getData($path));
		}
	}
	public function appendAction(message $msg){
//		$this->view->_404();
		if(!isset($msg["path"],$msg["dstype"],$msg["data"])){
			$this->view->_404();
			return ;
		}
		try{
			$this->model->append($msg["path"],$msg["dstype"],$msg["data"]);
			return $this->view->showOk("添加成功",ENTRY_HOME."/priv/datasrc?path=".urlencode($msg["path"]));
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function updateAction(message $msg){
//		$this->view->_404();
		if(!isset($msg["path"],$msg["dstype"],$msg["data"])){
			$this->view->_404();
			return ;
		}
		try{
			$this->model->update($msg["path"],$msg["dstype"],$msg["data"]);
			return $this->view->showOk("更新成功",ENTRY_HOME."/priv/datasrc?path=".urlencode($msg["path"]));
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function testAction(message $msg){
		
	}
}