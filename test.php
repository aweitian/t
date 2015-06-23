<?php
require "debug-data.php";
require 'navMenu.php';
//var_dump(is_array($data));
$demo = new navMenu($data);
$demo->output();
//$demo->debug();
?>
