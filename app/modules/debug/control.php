<?php
/**
 * Date: 2016-01-09
 * Author: Awei.tian
 * Description: 
 */
require_once FILE_SYSTEM_ENTRY.'/app/modules/debug/model.php';
require_once FILE_SYSTEM_ENTRY.'/app/modules/debug/view.php';
class debugController extends Controller{
	/**
	 * 
	 * @var debugModel
	 */
	private $model;
	/**
	 * 
	 * @var debugView
	 */
	private $view;
	public function __construct(){
		$this->model = new debugModel();
		$this->view = new debugView();
	}
	public function welcomeAction(){
		echo file_get_contents("http://baidu.com");
	}
}