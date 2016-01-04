<?php
/**
 * Date: 2015-12-31
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
	public function md5Action(){
		echo App::calcPwd("tony11.");
	}
	public function welcomeAction(){
		$cur = isset($_GET["pn"]) ? intval($_GET["pn"]) : 1;
		$total = 33;
		$demo = new Pagination($total,$cur,10,3);
		$this->view->test($demo);
	}
}