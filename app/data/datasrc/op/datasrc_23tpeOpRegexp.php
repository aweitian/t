<?php
/**
 * @author:awei.tian
 * @date: 2014-10-3
 * @functions:
 */
require_once DATASRC_PATH."/base/DataSrc_23tpe.php";
class datasrc_23tpeOpRegexp{
	public static function isValid(&$data){
		if(empty($data))return false;
		$newdata = array();
		if(count($data[0]) == 3){
			$i = 0;
			foreach ($data as $val){
				array_push($val, $i++);
				$newdata[] = $val;
			}
			$data = $newdata;
		}
		return datasrc_23tpe::checkWithOrder($data);
	}
}