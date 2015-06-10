<?php
/**
 * @author:awei.tian
 * @date: 2014-10-3
 * @functions:
 */
require_once DATASRC_PATH."/base/DataSrc_hot.php";
class datasrc_hotOpRegexp{
	public static function isValid(&$data){
		if(empty($data))return false;
		$newdata = array();
		if(count($data[0]) == 4){
			$i = 0;
			foreach ($data as $val){
				array_push($val, $i++);
				$newdata[] = $val;
			}
			$data = $newdata;
		}
		return datasrc_hot::checkWithOrder($data);
	}
}