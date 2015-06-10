<?php
/**
 * @author:awei.tian
 * @date: 2014-11-15
 * @functions:
 */
require_once APP_PATH."/privilege/pview.php";
if(!$this instanceof pview){
	exit("this must be inherited from pview");
}
 
?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="say something...">
<title>Pure</title>
<link rel="stylesheet" href="<?php echo PUBLIC_HOME;?>/css/pure-min.css"/>
<link rel="stylesheet" href="<?php echo PUBLIC_HOME;?>/css/ico/style.css"/>
<link rel="stylesheet" href="<?php echo PUBLIC_HOME;?>/priv/main.css"/>
<link rel="stylesheet" href="<?php echo PUBLIC_HOME;?>/jMenu/css/jmenu.css"/>
<script src="<?php echo PUBLIC_HOME;?>/js/jquery-1.10.0.js"></script>
<script src="<?php echo PUBLIC_HOME;?>/jMenu/js/jquery-ui.js"></script>
<script src="<?php echo PUBLIC_HOME;?>/jMenu/js/jMenu.jquery.min.js"></script>

</head>
<body>
<div id="navmenu-container">
    <ul id="navmenu">
        <li><a href="<?php echo ENTRY_HOME;?>/priv">首页</a></li>
        <li>
        	<a href="<?php echo ENTRY_HOME;?>/priv/nodetype"><i class="icon-uniE640"></i> 基本设置</a>
        	<ul>
        		<li><a href="<?php echo ENTRY_HOME;?>/priv/nodetype">节点类型管理</a></li>
        		<li><a href="<?php echo ENTRY_HOME;?>/priv/nodelabel">节点标签管理</a></li>
        		<li><a href="<?php echo ENTRY_HOME;?>/priv/delivery">发货地址字段</a></li>
        		<li><a href="<?php echo ENTRY_HOME;?>/priv/deliveryType">发货地址类型</a></li>
        	</ul>	
        </li>
        <li><a href="<?php echo ENTRY_HOME;?>/priv/node">结构和数据</a></li>
        <li><a href="<?php echo ENTRY_HOME;?>/priv/member">注册会员管理</a></li>
        <li>
        	<a href="<?php echo ENTRY_HOME;?>/priv/order"><i class="icon-uniE619"></i> 订单管理</a>
        	<ul>
        		<li><a href="<?php echo ENTRY_HOME;?>/priv/order">订单查询</a></li>
        		<li><a href="<?php echo ENTRY_HOME;?>/priv/blacklist">黑名单管理</a></li>
        	</ul>
        </li>
         <li>
        	<a href="<?php echo ENTRY_HOME;?>/priv/feedback"><i class="icon-uniE62E"></i> 热卖 & 留言</a>
        	<ul>
        		<li><a href="<?php echo ENTRY_HOME;?>/priv/feedback">留言管理</a></li>
        		<li><a href="<?php echo ENTRY_HOME;?>/priv/datasrc?path=%2F%3Fhot%2F">热卖管理</a></li>
        	</ul>
        </li>
        <li><a href="<?php echo ENTRY_HOME;?>/priv/news">新闻管理</a></li>
        <li><a href="<?php echo ENTRY_HOME;?>/priv/privusr">后台权限管理</a></li>
    </ul>
</div>
<?php echo $this->content;?>

<script type="text/javascript">
$(document).ready(function() {
	$("#navmenu").jMenu({
			openClick : false,
			ulWidth :'100',
			TimeBeforeOpening : 100,
			TimeBeforeClosing : 11,
			animatedText : false,
			paddingLeft: 1,
			effects : {
			effectSpeedOpen : 150,
			effectSpeedClose : 150,
			effectTypeOpen : 'slide',
			effectTypeClose : 'slide',
			effectOpen : 'swing',
			effectClose : 'swing'
		}
	});
});
</script>
</body>
</html>