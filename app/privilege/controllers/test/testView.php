<?php
/**
 * @author:awei.tian
 * @date: 2014-11-15
 * @functions:
 */
class testView extends view{

	public function showDs($data){
		include dirname(__FILE__)."/tpl.php";
	}
	
}