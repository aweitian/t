<?php
/**
 * Date: 2015-1-26
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/uipatch/pagination/uipatch_pagination.php";
// var_dump($data);exit;
$pagination = new uipatch_pagination($data["cnt"], 0, 10, 5);
// $pagination = new uipatch_pagination(25, 0, 10, 5);
$page_data = $pagination->getData();
// var_dump($data);exit;


//  array(13) {
//   ["sid"]=>
//   string(1) "8"
//   ["pmtype"]=>
//   string(2) "pp"
//   ["eml"]=>
//   string(7) "22@qq.c"
//   ["dt"]=>
//   string(2) "pl"
//   ["title"]=>
//   string(3) "1 g"
//   ["price"]=>
//   string(3) "4.2"
//   ["st"]=>
//   string(1) "0"
//   ["nsid"]=>
//   string(2) "80"
//   ["widord"]=>
//   string(2) "48"
//   ["locprice"]=>
//   string(8) "Amount:1"
//   ["dlvid"]=>
//   string(1) "9"
//   ["ip"]=>
//   string(9) "127.0.0.1"
//   ["dtime"]=>
//   string(19) "2015-04-08 13:43:47"
// }
?>
<script src="<?php print ENTRY_HOME?>/public/js/privilege/showOrderDetail.js"></script>







<table class="pure-table pure-table-bordered pure-table-striped table100">
<caption>订单记录</caption>
<thead>
<tr>
	<th colspan="10" align="right" style="background:white;border-bottom:1px solid #cbcbcb;">
	<form action="<?php print ENTRY_HOME?>/priv/order/search" class="pure-form">
	<input name="cond" value="<?php print $cond?>"><input type="submit" value="search" class="pure-button pure-button-primary">
	</form>
	</th>
</tr>
<tr>
	<th>#</th>
	<th>标题</th>
	<th>价格</th>
	<th>Email</th>
	<td>URL</td>
	<th>收货信息</th>
	<th>付款状态</th>
	<th>其它信息</th>
	<th>时间</th>
	<th>操作</th>
</tr>
</thead>
<tbody>
<?php foreach ($data["data"] as $item):?>
<tr>
	<td><?php print $item["sid"]?></td>
	<td><?php print htmlspecialchars($item["title"])?></td>
	<td><?php print htmlspecialchars($item["price"])?></td>
	<td><?php print htmlspecialchars($item["eml"])?></td>
	<td><?php print htmlspecialchars($item["path"])?>:<?php print htmlspecialchars($item["widord"])?></td>
	<td>
		<div style="display: none">
		<?php 
		foreach ($item["deliveryInfo"] as $dk => $delivery)
		{
			print $dk . ":" . $delivery . "<br>";
		}		
		?><br>
		<span onclick="od.hide(this)" style="color:blue;cursor:pointer;text-decoration:underline;">收起</span>	
		</div><span onclick="od.show(this)" style="color:blue;cursor:pointer;text-decoration:underline;">显示</span>
	
	</td>
	<td><?php print htmlspecialchars($item["st"])?></td>
	<td>
		<div style="display: none">
			<table>
			<tr>
				<td>付款方式</td><td><?php print htmlspecialchars($item["pmtype"])?></td>
			</tr><tr>
				<td>订单类型</td><td><?php print htmlspecialchars($item["dt"])?></td>
			</tr><tr>
				<td>IP地址</td><td><?php print htmlspecialchars($item["ip"])?></td>
			</tr><tr>
				<td>购买内容</td><td><?php print htmlspecialchars($item["locprice"])?></td>
			</tr>
			</table>	
			<br>
			<span onclick="od.hide(this)" style="color:blue;cursor:pointer;text-decoration:underline;">收起</span>	
		</div><span onclick="od.show(this)" style="color:blue;cursor:pointer;text-decoration:underline;">显示</span>

	</td>
	<td><?php print htmlspecialchars($item["dtime"])?></td>
	<td>
		<a href="<?php print ENTRY_HOME?>/priv/order/remove?sid=<?php print $item["sid"]?>" onclick="return confirm('?')">删除</a>
	</td>
</tr>
<?php endforeach;?>
</tbody>
</table>



<?php if($page_data["maxPage"]>1):?>
<div class="pagination">
<?php print $cur+1?> of <?php print $page_data["maxPage"]?>

<?php for($i=0;$i<$page_data["maxPage"];$i++):?>
<?php if($i+$page_data["start"] == $cur +1):?>
	<?php print $i+$page_data["start"]?>
<?php else:?>
	<a href="<?php echo ENTRY_HOME?>/order?page=<?php print $i+$page_data["start"]?>"><?php print $i+$page_data["start"]?></a>
<?php endif;?>
<?php endfor;?>
</div>
<?php endif;?>