<?php
//2014-3-13
require_once LIB_PATH."/mvc/route/routes/defaultRoute.php";

/**
 * 路由的作用就是怎么看侍URL
 */

class webservicesRoute extends defaultRoute{
	public function __construct(){
		$p=str_repeat("p", count(explode("/", trim(ENTRY_HOME,"/"))));
		parent::__construct(ENTRY_HOME."/wsv2/[\d\D]+",$p."mca");
	}
}
