<?php
/**
 * @author:awei.tian
 * @date: 2014-10-3
 * @functions:
 */
require_once DATASRC_PATH."/base/DataSrc_22ld.php";
class datasrc_22ldOpRegexp{
	public static function isValid($data){
		return datasrc_22ld::check($data);
	}
}