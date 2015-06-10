<?php
/**
 * @author:awei.tian
 * @date: 2014-10-3
 * @functions:
 */
require_once DATASRC_PATH."/base/DataSrc_23ldp.php";
class datasrc_23ldpOpRegexp{
	public static function isValid($data){
		return datasrc_23ldp::check($data);
	}
}