<?php
//unit amount
require_once DATASRC_PATH."/ADataSrc.php";
require_once LIB_PATH."/functions.php";
class DataSrc_22ap extends ADataSrc implements IOrder{
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
// 		var_dump($this->data);exit;
		$pos = 0;
		$div = true;
		$amount = $id_info["amount"];
		foreach($this->data as $row){
			if($row[0]>$amount){
				if($pos>0)$pos--;
				break;
			}
			if($row[0] == $amount){
				$div = false;
				break;
			}
			$pos++;
		}
		if($pos==count($this->data)){
			$pos--;
		}
		if($div){
			return round($this->data[$pos][1] / $this->data[$pos][0] * $amount,PRICE_PREC);
		}else{
			return $this->data[$pos][1];
		}
	}
	public function getTitle($id_info){
		$unit = $id_info["unit"];
		$amount = $id_info["amount"];
		return app::calcUnit($unit, $amount);
	}
	public static function check($data){
		$f = is_array($data) && count($data) > 0;
		$f = $f && util::isDigitalSeqArray($data);
		for($i=0; $i<count($data) && $f; $i++){
			$f = is_array($data[$i]) && util::isDigitalSeqArray($data[$i]) 
			&& count($data[$i]) == 2 
			&& (is_int($data[$i][0]) || (is_numeric($data[$i][0]) && preg_match("/^\d+$/", $data[$i][0])))
			&& is_numeric($data[$i][1]);
		}
		return $f;
	}
}