<?php
/**
 * @author:awei.tian
 * @date: 2015-4-9
 * @functions:
 */
require_once ENTRY_PATH.'/app/api/privilege/data/newsApi.php';
class newsModel extends model{
	public function getData($page){
		$api = new newsApi();
		$api->setMethod("get");
		$api->setArgs(array(
				"offset" => $page * 10,
				"length" => 10
		));
		return $api->invoke();
	}
	public function getDataByCond($page,$cond){
		$api = new newsApi();
		$api->setMethod("get");
		$api->setArgs(array(
				"cond" => $cond,
				"offset" => $page * 10,
				"len" => 10
		));
		return $api->invoke();
	}
	public function remove($sid){
		$api = new newsApi();
		$api->setMethod("delete");
		$api->setArgs(array(
			"sid" => $sid
		));
		return $api->invoke();
	}
	public function up($sid,$f){
		$api = new newsApi();
		$api->setMethod("put");
		$api->setScenario($f == 1 ? "turnoffslide" : "turnonslide");
		$api->setArgs(array(
			"sid" => $sid
		));
		return $api->invoke();
	}
	public function getDataBySid($sid){
		$api = new newsApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"sid" => $sid
		));
		return $api->invoke();
	}
	public function getDefData(){
		return array(
			"title" => "",	
			"content" => "",	
			"lnk" => "",	
			"sldimg" => "",	
			"sldflg" => "0",	
			"sldorder" => "0",	
		);
	}
	public function update($sid,$title,$content,$lnk,$sldimg,$sldflg,$sldorder){
		$api = new newsApi();
		$api->setMethod("put");
		$api->setArgs(array(
			"sid"=>$sid,
			"title"=>$title,
			"content"=>$content,
			"lnk"=>$lnk,
			"sldimg"=>$sldimg,
			"sldflg"=>$sldflg,
			"sldorder"=>$sldorder
		));
		return $api->invoke();
	}
	public function append($title,$content,$lnk,$sldimg,$sldflg,$sldorder){
		$api = new newsApi();
		$api->setMethod("post");
		$api->setArgs(array(
			"title"=>$title,
			"content"=>$content,
			"lnk"=>$lnk,
			"sldimg"=>$sldimg,
			"sldflg"=>$sldflg,
			"sldorder"=>$sldorder
		));
		return $api->invoke();
	}
}