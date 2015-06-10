<?php
//2014-3-13
require_once LIB_PATH."/mvc/route/routes/defaultRoute.php";

/**
 * 路由的作用就是怎么看侍URL
 */

class svcRoute extends defaultRoute{
	public function __construct(){
		$p=tian::getDefualtPreurlMask();
		parent::__construct(ENTRY_HOME."/".SVC_NAME."(/[\d\D]+)?",$p."mca");
	}
	public function getActionPath(){
		$pathinfo = tian::$context->getRequest()->requestUri();
		$pi = str_replace(ENTRY_HOME."/".SVC_NAME, "", $pathinfo);
		$tmp = explode("?", $pi);
		return urldecode($tmp[0]);
	}
}
