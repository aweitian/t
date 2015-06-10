<?php
/**
 * @author:awei.tian
 * @date: 2014-9-20
 * @functions:
 */
//require_once realpath("./../../")."/pd/const.php";
?><!DOCTYPE html>
<html>
<head>
<title>css demo</title>
<meta charset="UTF-8">
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<meta http-equiv="Content-type" content="text/html;charset=utf-8"/>
<meta http-equiv="Content-Style-Type" content="text/css"/>
<meta http-equiv="Content-Script-Type" content="text/javascript"/>
<meta name="entrypoint" content="<?php echo ENTRY_HOME;?>" />
<meta name="Author" content="netease"/>
<meta name="Version" content="1.0"/>
<link href="<?php print ENTRY_HOME?>/themes/default/css/grid.css" rel="stylesheet" type="text/css"/>
<link href="<?php print ENTRY_HOME?>/themes/default/css/global.css" rel="stylesheet" type="text/css"/>
<link href="<?php print ENTRY_HOME?>/themes/default/css/index.css" rel="stylesheet" type="text/css"/>
<link href="<?php print ENTRY_HOME?>/themes/default/css/skin.css" rel="stylesheet" type="text/css"/>
<link href="<?php print ENTRY_HOME?>/themes/default/css/widget.css" rel="stylesheet" type="text/css"/>
<link type="text/css" href="<?php print ENTRY_HOME?>/themes/default/css/ico/style.css" rel="stylesheet"/>
<link type="text/css" href="<?php print ENTRY_HOME?>/themes/default/slider/css/global.css" rel="stylesheet"/>

<script type="text/javascript" src="<?php print ENTRY_HOME?>/themes/default/js/jquery-1.10.0.js"></script>
<script type="text/javascript" src="<?php print ENTRY_HOME?>/themes/default/js/jquery.slideBox.min.js"></script>
<script type="text/javascript" src="<?php print ENTRY_HOME?>/themes/default/js/showSvrMenu.js"></script>

</head>
<body>
<?php include dirname(__FILE__)."/tpl/head.php"?>
<?php include dirname(__FILE__)."/tpl/menu.php"?>








<?php print $content?>







<?php include dirname(__FILE__)."/tpl/foot.php"?>
</body>
</html>