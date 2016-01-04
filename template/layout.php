<?php
/**
 * Date: 2015年12月30日
 * Author: Awei.tian
 * Description: 
 */
if (!($this instanceof view)){
	exit('this invalid;');
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>debug</title>
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<meta name="viewport" content="width=device-width"/>
<!--

<link rel="stylesheet/less" href="<?php print HTTP_ENTRY?>/src/bootstrap-3.3.5/less/bootstrap.less"/>
<link rel="stylesheet/less" href="<?php print HTTP_ENTRY?>/src/bootstrap-3.3.5/less/theme.less">
-->
<link rel="stylesheet" href="<?php print HTTP_ENTRY?>/static/css/bootstrap.min.css"/>
<link rel="stylesheet" href="<?php print HTTP_ENTRY?>/static/css/bootstrap-theme.min.css">


</head>
<body>
<?php if($this->isShowHeader()):?>
<?php include 'template/header.php';?>
<?php endif;?>
<?php print $content?>
<?php if($this->isShowFooter()):?>
<?php include 'template/footer.php';?>
<?php endif;?>
<script src="<?php print HTTP_ENTRY?>/static/js/jquery-1.11.2.js"></script>
<script src="<?php print HTTP_ENTRY?>/static/js/bootstrap.min.js"></script>
</body>
</html>