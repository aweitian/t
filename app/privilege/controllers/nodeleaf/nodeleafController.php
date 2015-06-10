<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */

class nodeleafController extends privilege{
	/**
	 * @var nodeleafView
	 */
	protected $view;
	/**
	 * @var nodeleafModule
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
		$this->view->showList($path,$this->model->getData($path));
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
		$msg->setControl("widget");
		$msg->setDispatchedState(dispatcher::DISPATCH_STATE_RESTART);
		tian::$context->getDispatcher("default")->dispatch();
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
		$msg->setControl("widget");
		$msg->setDispatchedState(dispatcher::DISPATCH_STATE_RESTART);
		tian::$context->getDispatcher("default")->dispatch();
	}
	public function testAction(message $msg){
		
	}
}