<?php
require_once DATASRC_PATH."/ADataSrc.php";
require_once LIB_PATH."/functions.php";
class DataSrc_ofhint extends ADataSrc{
	public function __construct(array $data){
		$this->data = $data;
		if(!self::check($this->data)){
			if(DEBUG_FLAG){
// 				var_dump($data);
			}
			throw new Exception("illegal data",0x123);
		}
	}
	public static function check($data){
		$f = is_array($data);
		return $f;
	}
}