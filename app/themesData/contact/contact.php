<?php
/**
 * Date:2015年5月6日
 * Author:Awei.tian
 * Function:
 */
class themeDataContact{
	public function getHtml(){
		ob_start();
		include dirname(__FILE__)."/tpl.php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
}