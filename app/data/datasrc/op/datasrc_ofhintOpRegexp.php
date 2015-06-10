<?php
/**
 * @author:awei.tian
 * @date: 2014-10-3
 * @functions:
 */
require_once DATASRC_PATH."/base/DataSrc_ofhint.php";
class datasrc_ofhintOpRegexp{
	public static function isValid(&$data){
		return datasrc_ofhint::check($data);
	}
}