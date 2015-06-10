<?php
/**
 * @author:awei.tian
 * @date: 2014-10-3
 * @functions:
 */
require_once DATASRC_PATH."/base/DataSrc_html.php";
class datasrc_htmlOpRegexp{
	public static function isValidData($data){
		return datasrc_html::check($data);
	}
	public static function isValidKey($data){
		return preg_match("/^\w{1,20}$/", $data);
	}
}