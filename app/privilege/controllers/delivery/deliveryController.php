<?php
/**
 * @author:awei.tian
 * @date: 2014-11-16
 * @functions:
 */
class deliveryController extends privilege{
	/**
	 * @var deliveryView
	 */
	protected $view;
	/**
	 * @var deliveryModel
	 */
	protected $model;
	public function __construct(){
		$this->_loadModel();
		$this->_loadView();
		$this->_init();
	}
	public function welcomeAction(message $msg){
		$this->view->delivery($this->model->getData($msg["?path"]));
	}
	public function removeAction(message $msg){
		if(!isset($msg["?key"])){
			$this->view->_404();
			return ;
		}
		try{
			$row = $this->model->remove($msg["?key"]);
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
			ENTRY_HOME."/priv/delivery/append",
			$this->model->defaultValue()
		);
	}
	public function appendAction(message $msg){
		try{
			$this->model->append($msg["key"],$msg["val"],$msg["typ"],$msg["len"],$msg["ept"],$msg["comment"]);
			return $this->view->showOk("添加成功",ENTRY_HOME."/priv/delivery");
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function updateAction(message $msg){
		try{
			$this->model->update($msg);
			$tmp = explode("?",$msg["path"]);
			return $this->view->showOk("更新成功",ENTRY_HOME."/priv/deliverykey?path=".urlencode($tmp[0]."?"));
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function editAction(message $msg){
		if(!isset($msg["?key"])){
			$this->view->_404();
			return ;
		}
////		var_dump($this->model->nodeInfo($msg["?path"]));exit;
		$data = $this->model->info($msg["?key"]);
//		var_dump($data);exit;
		if(empty($data)){
			$this->view->showFail("invalid path.");
			return ;
		}
		$this->view->edit(
			ENTRY_HOME."/priv/delivery/update",
			$data[0]
		);
	}
	public function testAction(message $msg){
		$this->view->_404();
	}
}