<?php
/**
 * Date: {date}
 * Author: Awei.tian
 * Description: 
 */
require_once 'app/modules/{name}/{name}Model.php';
require_once 'app/modules/{name}/{name}View.php';
class {name}Controller extends Controller{
	/**
	 * 
	 * @var {name}View
	 */
	private $model;
	/**
	 * 
	 * @var {name}View
	 */
	private $view;
	public function __construct(){
		$this->model = new {name}Model();
		$this->view = new {name}View();

	}
	public function welcomeAction(){

	}
}