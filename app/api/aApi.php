<?php
/**
 * Date: 2014-10-15
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/lib/tian/interfaces/IApi.php";
require_once ENTRY_PATH."/app/api/apiFactory.php";
abstract class aApi implements IApi{
	protected $args;
	protected $method;
	protected $url;
	protected $scenario="default";
	
	public function help(){
		echo "see api doc";
	}
	public function setArgs($args){
		$this->args=$args;
		return $this;
	}
	public function setMethod($method){
		$this->method=$method;
		return $this;
	}
	public function setUrl($url){
		$this->url=$url;
		return $this;
	}
	public function setScenario($scenario){
		$this->scenario = $scenario;
		return $this;
	}
	public function isPost(){
		return strtolower($this->method)==="post";
	}
	public function isGet(){
		return strtolower($this->method)==="get";
	}
	public function isDelete(){
		return strtolower($this->method)==="delete";
	}
	public function isPut(){
		return strtolower($this->method)==="put";
	}
}