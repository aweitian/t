<?php
/**
 * Date: 2014-9-16
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/lib/tian/formUI/fieldsManifest.php";
abstract class AUipatch{
	/**
	 * @var fieldsManifest
	 */
	public $fieldsManifest;
 	public function getId(){
 		return substr(get_class($this),5);
 	}
 	public function initFieldsManifest(){
 		$this->fieldsManifest = new fieldsManifest();
 	}
 	abstract public function getData();
	static public function getSupportDatasrc(){}
}