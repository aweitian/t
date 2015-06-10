<?php
/**
 * Date: 2015-5-8
 * Author: Awei.tian
 * function: 
 */
class feedbackView extends appView{
	public function __construct(){
		parent::__construct();
	}
	public function showList($data,$cur,$cond){
		$left = $this->fetch(array("data"=>$data,"cur"=>$cur,"cond"=>$cond), "tpl");
		$content = $this->ui->getLeftRightSkl($left);
		$this->ui->wrap(array("content"=>$content),"index");
		//var_dump($content);
	}
}