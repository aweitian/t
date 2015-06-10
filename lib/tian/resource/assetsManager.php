<?php
/**
 * @author:awei.tian
 * @date:2013-12-11
 * @functions:
 */
require_once LIB_PATH."/algorithms/base32.php";
class assetsManager{
	public $base32;
	public function __construct($assets_path){
		$this->base32=new base32();
		$this->_check($assets_path);
		$this->assets_path=$assets_path;
	}
	private function _check($assets_path){
		$path_arr=explode("://",$assets_path,2);
		if(count($path_arr)!=2){
			throw new Exception("assets path is invalid,eg:LIB_PATH://resource/contextType.json");
		}		
	}
	public function __toString(){
		return tian::createUrl("/assets/".$this->base32->encode($this->assets_path));
	}
}