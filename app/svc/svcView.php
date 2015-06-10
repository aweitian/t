<?php
/**
 * Date:2015年4月7日
 * Author:Awei.tian
 * Function:
 */
class svcView extends appView{
	public function showData($data){
		$this->ui->wrap(array("content"=>$this->fetch(
			$data, 
			is_array($data) ? "list" : "tpl"
		)),"default");
	}
	public function fetch($data,$tpl){
		ob_start();
		include dirname(__FILE__)."/tpl/".$tpl.".php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
}