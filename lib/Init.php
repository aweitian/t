<?php
define("FULL_URL",$_SERVER['SERVER_NAME']);

#网站HTTP入口路径,网站放在根目录定义为空，假如放在joyhr/1目录下，定义为  /joyhr/1   (以/开头，尾部没有 /)
#http_entry.txt这个文件不提交到SVN
if (file_exists(FILE_SYSTEM_ENTRY."/http_entry.txt")) {
	define("HTTP_ENTRY",file_get_contents(FILE_SYSTEM_ENTRY."/http_entry.txt"));
} else {
	define("HTTP_ENTRY","");
}
define("DEFAULT_MODULE","default");
define("DEFAULT_CONTROLLER","main");
define("DEFAULT_ACTION","index");

#mysql setting



require(FILE_SYSTEM_ENTRY."/lib/Controller.php");
require(FILE_SYSTEM_ENTRY."/lib/DBUtil.php");
require(FILE_SYSTEM_ENTRY."/lib/Router.php");
require(FILE_SYSTEM_ENTRY."/lib/Session.php");
require(FILE_SYSTEM_ENTRY."/lib/Validator.php");


?>