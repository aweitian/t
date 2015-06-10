<?php
//2014-3-13
require_once LIB_PATH."/mvc/route/routes/defaultRoute.php";

/**
 * 路由的作用就是怎么看侍URL
 */

class privRoute extends defaultRoute{
	public function __construct(){
		$p=tian::getDefualtPreurlMask();
		parent::__construct(ENTRY_HOME."/priv(/[\d\D]+)?",$p."mca");
	}
}
