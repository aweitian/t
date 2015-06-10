<?php
/**
 * 入口文件所在目录
 * @var ENTRY_PATH
 * @var ENTRY_HOME
 * @var LIB_PATH
 * @var VENDOR_PATH
 */
define("DEBUG_FLAG", TRUE);
if(DEBUG_FLAG){
	error_reporting(E_ALL);
	ini_set("display_errors","On");
}else{
	error_reporting(0);
	ini_set("display_errors","Off");
}
define("ENTRY_PATH",dirname(dirname(__FILE__)));
define("ENVIR_SAE",0);
define("ENVIR_COMMON",1);
define("ENVIR_BAE",2);
define("ENVIR_OPENSHIFT",3);
if(defined('SAE_MYSQL_DB')){
	define("ENVIR",ENVIR_SAE);
	define("ENTRY_HOME","/ep");
	require ENTRY_PATH.'/pd/db_pwd/sae.php';
}else if(false !== strpos(ENTRY_PATH, "openshift")){
	define("ENVIR",ENVIR_OPENSHIFT);
	define("ENTRY_HOME","");
	require ENTRY_PATH.'/pd/db_pwd/openshift.php';
}else{
	define("ENVIR",ENVIR_COMMON);
	define("ENTRY_HOME","");
	require ENTRY_PATH.'/pd/db_pwd/local.php';
}
define("URLREWRITEMODE",1);//不想用应该在前面加//不是改为FALSE
if(!defined("URLREWRITEMODE")){
	define("ROUTE_GET_NAME","r");
}


define("LIB_PATH",ENTRY_PATH.'/lib/tian');
define("EXT_PATH",ENTRY_PATH.'/lib/extend');
define("VENDOR_PATH",ENTRY_PATH.'/lib/vendor');