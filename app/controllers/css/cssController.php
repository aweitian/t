<?php

class cssController extends controller{
	private $setting='';
	public function __construct(){
		$this->_loadView(__CLASS__);
		$this -> view = new cssView();
		$setting=parse_ini_file($this->_getCurDir(__CLASS__)."/setting.ini");
		define("CSS_SIGNATURE_CODE",$setting["slogan"]);
	}	
	
	public function welcomeAction($msg){
		$this -> view -> welcome(array());
	}
	public function clearAction($msg){
		$this->view->clear();
		echo "ok";
	}
	public function privilege($msg){

	}
}