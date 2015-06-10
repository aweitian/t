<?php
/**
 * Date:2015年4月7日
 * Author:Awei.tian
 * Function:
 */
class svcModel extends appModel{
	public function getData(){
		$ins = new nodeleafModule();
		return $ins->allLeaves();
	}
}