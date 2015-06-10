<?php
/**
 * @author awei.tian
 * date: 2013-9-18
 * 说明:
 */
require_once ENTRY_PATH."/app/themesData/news/news.php";
class mainController extends appController{
	/**
	 * @var mainView
	 */
	protected $view;
	/**
	 * @var mainModel
	 */
	protected $model;
	public function __construct(){
		$this->_init();
	}
	public function welcomeAction(){
		$this->view->main($this->model->getHotData());
	}
	public function testAction(){
		echo "hello test";
	}
}