<?php
#文件系统入口路径,路径尾部没有 /
define("FILE_SYSTEM_ENTRY",realpath("./"));
require(FILE_SYSTEM_ENTRY."/lib/Init.php");
require(FILE_SYSTEM_ENTRY."/app/app.php"); 


App::run();
?>