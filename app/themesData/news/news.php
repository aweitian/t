<?php
/**
 * Date:2015年5月6日
 * Author:Awei.tian
 * Function:
 */
require_once ENTRY_PATH."/app/data/news/newsInfo.php";
class themeDataNews{
	public function getSlideData(){
		$ins = new newsInfo();
		return $ins->getSlideData();
	}
	public function getAllNews($offset, $len){
		$ins = new newsInfo();
		return $ins->all($offset, $len);
	}
	public function getData($sid){
		$ins = new newsInfo();
		return $ins->info($sid);
	}
	public function getSlideHTML(){
		ob_start();
		$data = $this->getSlideData();
		include dirname(__FILE__)."/slide.tpl.php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
}



?>
