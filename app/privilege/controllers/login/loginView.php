<?php
/**
 * @author:awei.tian
 * @date: 2014-11-15
 * @functions:
 */
class loginView extends pview{

	public function showLoginUI($loginuidata){
		include dirname(__FILE__)."/tpl/login.tpl.php";
	}
	
}