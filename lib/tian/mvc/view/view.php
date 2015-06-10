<?php
/**
 * @author awei.tian
 * date: 2013-9-26
 * 说明:
 */
lang::import("sys");
C::addAutoloadPath("urlManager", LIB_PATH."/url/urlManager.php");
C::addAutoloadPath("fieldsManifest", LIB_PATH."/formUI/fieldsManifest.php");

class view{
	/**
	 * @param string $sce
	 * @return fieldsManifest
	 */
	public function getFieldManifest($sce="add"){
		return new fieldsManifest($sce);
	}
	
	public function response($content){
		if(is_array($content)){
			echo json_encode($content);
		}else{
			echo $content;
		}
	}
	/**
	 * @return httpRequest::
	 * Enter description here ...
	 */
	public function getRequest(){
		return tian::$context->getRequest();
	}
	/**
	 * @return visterEnvironment
	 */
	public function getVisterEnvironment(){
		return tian::$context->getVisterEnvironment();
	}
	/**
	 * @return httpResponse
	 * Enter description here ...
	 */
	public function getResponse(){
		return tian::$context->getResponse();
	}
	public function _404(){
		tian::$context->getResponse()->_404();
		exit;
	}
	public function showErr($msg){
		tian::$context->getResponse()->showError($msg);
		exit;
	}
	/**
	 * 直接转跳
	 * @param unknown_type $url
	 */	
	public function redirect($url){
		tian::$context->getResponse()->_redirect($url);
	}
	/**
	 * 
	 * 用/表示ENTRY_HOME,来相对转跳
	 * @param string $url
	 */
	
	public function go($url){
		$url = ENTRY_HOME.$url;
		$this->redirect($url);
	}
} 