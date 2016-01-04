<?php



if(defined('SAE_MYSQL_DB')){
	define("DB_DNS","mysql:host=".SAE_MYSQL_HOST_M.";dbname=".SAE_MYSQL_DB.";port=".SAE_MYSQL_PORT);
	define("DB_USER",SAE_MYSQL_USER);
	define("DB_PASS",SAE_MYSQL_PASS);
	define("DB_CHARSET","utf8");
}else if(false !== strpos(FILE_SYSTEM_ENTRY, "openshift")){

}else{
	define("DB_DNS","mysql:host=localhost;dbname=anpl;port=3306");
	define("DB_USER","root");
	define("DB_PASS","");
	define("DB_CHARSET","utf8");
}





require_once FILE_SYSTEM_ENTRY.'/app/model.php';
require_once FILE_SYSTEM_ENTRY.'/app/view.php';
require_once FILE_SYSTEM_ENTRY.'/app/roles/roleSession.php';









