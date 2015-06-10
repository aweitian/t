<?php
/**
 * @author:awei.tian
 * @date: 2014-10-3
 * @functions:
 */
require_once DATASRC_PATH."/base/DataSrc_22ap.php";
class datasrc_22apOpRegexp{
	public static function isValid($data){
		return datasrc_22ap::check($data);
	}
}