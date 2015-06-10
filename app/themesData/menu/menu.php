<?php
/**
 * Date:2015年5月6日
 * Author:Awei.tian
 * Function:
 */
require_once ENTRY_PATH."/app/modules/nodeleaf/nodeleafModule.php";
class themeDataMenu{
	public function getRawData(){
		$ins = new nodeleafModule();
		return $ins->allLeaves();
	}
	public function getHTML(){
		ob_start();
		$data = $this->getRawData();
		include dirname(__FILE__)."/tpl.php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
}



?>
