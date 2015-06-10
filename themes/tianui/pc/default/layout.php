<?php
/**
 * @author:awei.tian
 * @date:2014-1-17
 * @functions:
 */
$local=tian::$context->getVisterEnvironment()->getLocal();
function p($msg){
	echo $msg;
}

?>
<!DOCTYPE html>
<html>
<head>
<title><?php p($title);?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">
<?php if($local==visterEnvironment::VISTER_EINVIRONMENT_DEVICE_TYPE_PC):?>
<?php include_once dirname(__FILE__)."/layout/local_header_cdn.php";?>
<?php else:?>
<?php include_once dirname(__FILE__)."/layout/foreign_header_cdn.php";?>
<?php endif?>
</head>
<body>
<?php p($body);?>
</body>
</html>