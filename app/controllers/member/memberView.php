<?php
/**
 * Date: 2015-1-26
 * Author: Awei.tian
 * function: 
 */
class memberView extends appView{
	private $mem_ui;
	private $login_html;
	public function __construct(){
		parent::__construct();
		$this->mem_ui = new themeDataMember();
		//因为SESSION的原因,需要在没有输出前获取
		$this->login_html = $this->mem_ui->getLoginHtml();
	}
	public function login(){
		$content = $this->login_html;
		$this->ui->wrap(array("content"=>$content),"layout");
	}
	public function register($errorMsg=""){
		$content = $this->mem_ui->getRegisterHtml($errorMsg);
		$this->ui->wrap(array("content"=>$content),"layout");
	}
	public function profile($data){
		$profile = $this->fetch(array("data"=>$data), "profile");
		$this->ui->wrap(array("content"=>$profile),"layout");
	}
}