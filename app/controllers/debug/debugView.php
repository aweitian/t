<?php
/**
 * Date: 2015-1-22
 * Author: Awei.tian
 * function: 
 */
class debugView extends appView{
	public function __construct(){
		parent::__construct();
	}
	public function testMF(){
		$mf = $this->getFieldManifest();
		$mf->addField("q", "file");
		$mf->addField("h", "text",array("type"=>"hidden"));
		$mf->addField("c", "text");
		$mf->addField("cx", "textarea");
		$mf->addField("g", "select",array(),array("a","b","c"),array(),"b");
		$mf->addField("w", "select_muti",array(),array("aa","bb","cc"),array("aaa","bbb","ccc"),"bb,cc");
		var_dump($mf->getData()); 
	}
	public function testui(){
		$this->ui->wrap(array(
			"content"=>"hi,lol"
		), "main");
	}
	public function spancalc($content){
		$this->ui->wrap(array("content"=>$content),"index");
	}
}