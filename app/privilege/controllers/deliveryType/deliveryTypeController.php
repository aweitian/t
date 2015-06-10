<?php
/**
 * @author:awei.tian
 * @date: 2014-11-16
 * @functions:
 */
class deliveryTypeController extends privilege{
	/**
	 * @var deliveryTypeView
	 */
	protected $view;
	/**
	 * @var deliveryTypeModel
	 */
	protected $model;
	public function __construct(){
		$this->_loadModel();
		$this->_loadView();
		$this->_init();
	}
	public function welcomeAction(message $msg){
		$this->view->deliveryType($this->model->getData());
	}
	public function removeAction(message $msg){
		if(!isset($msg["?name"])){
			$this->view->_404();
			return ;
		}
		try{
			$row = $this->model->remove($msg["?name"]);
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
			ENTRY_HOME."/priv/deliveryType/append",
			$this->model->defaultValue(),
			$this->model->getAllFields()
		);
	}
	public function appendAction(message $msg){
		//var_dump($msg["keylist"]);exit;
		try{
			$this->model->append($msg["name"],join(",", $msg["keylist"]));
			return $this->view->showOk("添加成功",ENTRY_HOME."/priv/deliveryType");
		}catch (Exception $e){
			$this->view->showFail($e);
		}
	}
	public function testAction(message $msg){
		$this->view->_404();
	}
}