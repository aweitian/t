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
		
	}
	public function md5Action(){
		echo App::calcPwd("tony11.");
	}
}