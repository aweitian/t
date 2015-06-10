<?php
//start end unit
require_once DATASRC_PATH."/ADataSrc.php";
require_once LIB_PATH."/functions.php";
require_once ENTRY_PATH."/lib/extend/d2calc/d2calc.php";
class DataSrc_22ld extends ADataSrc implements IOrder{
	public function __construct(array $data){
		$this->data = $data;
		if(!self::check($this->data)){
			if(DEBUG_FLAG){
				var_dump($data);
			}
			throw new Exception("illegal data");
		}
	}
	public function getPrice($id_info){
		$start = $id_info["start"];
		$end   = $id_info["end"];
		$unit  = $id_info["unit"];
		$calc = new d2calc($this->data);
		return $calc->calc($start, $end, $unit);
	}
	public function getTitle($id_info){
		$start = $id_info["start"];
		$end   = $id_info["end"];
		return $start." - ".$end;
	}
	public static function check($data){
		$f = is_array($data) && count($data) > 0;
		$f = $f && util::isDigitalSeqArray($data);
		for($i=0; $i<count($data) && $f; $i++){
			$f = $f && util::isDigitalSeqArray($data[$i])
			&& count($data[$i]) == 2 
			&& (is_int($data[$i][0]) || (is_numeric($data[$i][0]) && preg_match("/^\d+$/", $data[$i][0])))
			&& is_numeric($data[$i][1])
			;
		}
		return $f;
	}
}