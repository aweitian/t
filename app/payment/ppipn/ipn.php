<?php
//这个文件由PP自动请求
error_reporting(E_ALL);
ini_set("display_errors","On");
require 'ppipn.php';
require 'db_test.php';
$ppipn=new ppipn("xlong928_business@gmail.com",ppipn::TEST);
$db=new testipndb();
$ppipn->setOkCallback(array($db,"ok"));
$ppipn->setFailCallback(array($db,"fail"));
$ppipn->post();
?>
