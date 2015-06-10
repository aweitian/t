<?php 
require 'ppipn.php';
require 'db_test.php';
$title="test ipn title";//可以POST过来
$price=12.34;//可以POST过来
$ppipn=new ppipn("xlong928_business@gmail.com",ppipn::TEST);
$ppipn->setTitle($title);//商品标题
$ppipn->setPrice($price);//价格
$db=new testipndb();
$item_number=$db->insertNewItem($title, $price);//向数据库插入一条记录，然后返回这个记录ID，记名叫订单号
$ppipn->setItemNumber($item_number);//把订单号提交给PP
//$ppipn->setSubmitText("结算");
echo $ppipn->getFormUI();
?>