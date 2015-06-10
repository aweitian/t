<?php
/**
 * Date: 2015-1-26
 * Author: Awei.tian
 * function: 
 */
class mainView extends appView{
	private $hot_data;
	public function __construct(){
		parent::__construct();
	}
	public function main($data){
		$main = $this->fetch(array("hotdata"=>$data), "index.tpl");
		$this->ui->wrap(array("content"=>$main),"layout");
	}
	public function getSlideNewsHtml(){
		$news = new themeDataNews();
		return $news->getSlideHTML();
	}
	public function getContactHtml(){
		return $this->ui->getContactHtml();
	}
	public function getHotHtml($data){
		$hot = $this->fetch(array("data"=>$data), "hot");
		return $hot;
	}
}