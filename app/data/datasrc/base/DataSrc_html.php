<?php
require_once DATASRC_PATH."/ADataSrc.php";
require_once LIB_PATH."/functions.php";
class DataSrc_html extends ADataSrc{
	public function __construct($data){
		$this->data = $data;
		if(!self::check($this->data)){
			throw new Exception("illegal data",0x123);
		}
	}
	public static function check($data){
		return is_string($data);
	}
}