<?php
/**
 * @author: awei.tian
 * @date: 2014-3-27
 * @usage:
 */
require_once dirname(dirname(dirname(__FILE__)))."/tian/functions.php";
class d2calc{
	private $data;
	/**
	 * @param array $data
	 * @throws Exception
	 */
	public function __construct(array $data){
		$this->data=$data;
		if(!$this->_check()){
			throw new Exception("Data illegal.");
		}
	}
	/**
	 * 
	 * @param int $start
	 * @param int $end
	 * @param number $unitprice
	 * @param number $factor
	 * @throws Exception
	 * @return array("price"=>p,"day"=>d)
	 */
	public function calc($start,$end,$unitprice,$factor=1){
		if(!$this->_check_args($start, $end, $unitprice, $factor)){
			throw new Exception(sprintf("illegal args:\r\nstart:%s,\r\nend:%s\r\n,unitprice:%s\r\n,factor:%s", 
					var_export($start,true),
					var_export($end,true),
					var_export($unitprice,true),
					var_export($factor,true) ));
		}
		$c = $start;
		$d = $end;
		$e = $this->data;
		$f = $factor;
		$s = 0;
		$p = 0;
		$u = $unitprice;
		$r = 0;
		$l = 0;
		$needdays = 0;
		$price = 0;
		$exMode = $this->isExMode();
		if($e[0][0] != 0 && $e[0][1] != 0){array_unshift($e,$exMode ? array(0,0,0) : array(0,0));}
		
		for($i=0; $i<count($e); $i++){
			if($c < $e[$i][0]){$s = $i;break;}
		}
		for($i=count($e); $i; $i--){
			if($d > $e[$i-1][0]){
				$p = $i-1;break;
			}
		}
		switch($p-$s){
			case -1:
				$needdays=round(($d-$c)/+($e[$s][0]-$e[$p][0])*$e[$s][1],2);
				if($exMode){
					$price = round(($d-$c)/+($e[$s][0]-$e[$p][0])*$e[$s][2],2);
					return array("price" => $price,"day" => $needdays);
				}
				return array("price" => round(($d-$c)/+($e[$s][0]-$e[$p][0])*$e[$s][1]*$u*$f,2),"day" => $needdays);
			case 0:
				$needdays=round((($e[$s][0]-$c)/($e[$s][0]-$e[$s-1][0])*$e[$s][1]+($d-$e[$p][0])/($e[$p+1][0]-$e[$p][0])*$e[$p+1][1]),2);
				if($exMode){
					$price = round((($e[$s][0]-$c)/($e[$s][0]-$e[$s-1][0])*$e[$s][2]+($d-$e[$p][0])/($e[$p+1][0]-$e[$p][0])*$e[$p+1][2]),2);
					return array("price" => $price,"day" => $needdays);
				}
				return array("price" => round((($e[$s][0]-$c)/($e[$s][0]-$e[$s-1][0])*$e[$s][1]+($d-$e[$p][0])/($e[$p+1][0]-$e[$p][0])*$e[$p+1][1])*$u*$f,2),"day" => $needdays);
			default:
				$r = 0;
				$l = 0;
				if($exMode)$r+=($e[$s][0]-$c)/($e[$s][0]-$e[$s-1][0])*$e[$s][2];
				$l=($e[$s][0]-$c)/($e[$s][0]-$e[$s-1][0])*$e[$s][1];
				for($i=$s;$i<$p;$i++){if($exMode)$r+=$e[$i+1][2];$l+=$e[$i+1][1];}
				$l+=($d-$e[$p][0])/($e[$p+1][0]-$e[$p][0])*$e[$p+1][1];
				if($exMode)$r+=($d-$e[$p][0])/($e[$p+1][0]-$e[$p][0])*$e[$p+1][2];
				$needdays=round($l,2);
				if($exMode){
					$price = round($r,2);
					return array("price" => $price,"day" => $needdays);
				}
				return array("price" => round($l*$u*$f,2),"day" => $needdays);
		}
	}
	private function isExMode(){
		$lvl = $this->data;
		return count($lvl) > 0 && is_array($lvl[0]) && count($lvl[0]) == 3;
	}
	/**
	 * @return bool
	 * @param array $data
	 */
	private function _check(){
		if(!is_array($this->data))return false;
		return true;
	}
	private function _check_args($start,$end,$unitprice,$factor){
		return util::isInt($start) && util::isInt($end)
			&& is_numeric($unitprice) && is_numeric($factor)
			&& $this->_check_args_ext($start,$end,$unitprice,$factor);
	}
	private function _check_args_ext($start,$end,$unitprice,$factor){
		if($start < 0)return false;
		if($end < 0)return false;
		if($start >= $this->data[count($this->data) - 1][0])return false;
		if($end > $this->data[count($this->data) - 1][0])return false;
		if($start >= $end)return false;
		return true;
	}
}