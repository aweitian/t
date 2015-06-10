<?php
require_once DATASRC_PATH."/ADataSrc.php";
require_once LIB_PATH."/functions.php";
class DataSrc_hot extends ADataSrc implements IOrder{
	public function __construct(array $data){
		$this->data = $data;
		if(!self::checkWithOrder($this->data)){
			if(DEBUG_FLAG){
// 				var_dump($data);
			}
			throw new Exception("illegal data",0x123);
		}
	}
	public function getPrice($id_info){
		foreach ($this->data as $row){
			if($id_info == $row[0]){
				return $row[2];
			}
		}
		throw new Exception("invalid id",0x1);
	}
	public function getTitle($id_info){
		return $id_info;
	}
	public static function check($data){
		$f = is_array($data) && count($data) > 0;
		$f = $f && util::isDigitalSeqArray($data);
		for($i=0; $i<count($data) && $f; $i++){
			$f = is_array($data[$i]) && count($data[$i]) == 5 
			&& util::isDigitalSeqArray($data[$i])
			&& is_string($data[$i][0]) && is_string($data[$i][3]) 
			&& is_numeric($data[$i][1]) && is_numeric($data[$i][2])
			&& is_string($data[$i][4])
			;
		}
		return $f;
	}
	public static function checkWithOrder($data){
// 		var_dump($data);exit;
		$f = is_array($data) && count($data) > 0;
		$f = $f && util::isDigitalSeqArray($data);
		for($i=0; $i<count($data) && $f; $i++){
			$f = is_array($data[$i]) && count($data[$i]) == 6 
			&& util::isDigitalSeqArray($data[$i])
			&& is_string($data[$i][0]) && is_string($data[$i][3]) 
			&& is_numeric($data[$i][1]) && is_numeric($data[$i][2]) 
			&& is_numeric($data[$i][4]) && is_string($data[$i][5])
			;
		}
		return $f;
	}
}