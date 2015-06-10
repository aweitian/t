<?php
/**
 * @author:awei.tian
 * @date: 2014-10-3
 * @functions:
 */
require_once DATASRC_PATH."/base/DataSrc_22tp.php";
class datasrc_22tpOpRegexp{
	public static function isValid(&$data){
//		var_dump($data);exit;
		if(empty($data))return false;
		$newdata = array();
		if(count($data[0]) == 2){
			$i = 0;
			foreach ($data as $val){
				array_push($val, $i++);
				$newdata[] = $val;
			}
			$data = $newdata;
		}
		return datasrc_22tp::checkWithOrder($data);
	}
}