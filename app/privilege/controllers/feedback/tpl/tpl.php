<?php
/**
 * Date: 2015-1-26
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/uipatch/pagination/uipatch_pagination.php";
$pagination = new uipatch_pagination($data["cnt"], 0, 10, 5);
// $pagination = new uipatch_pagination(25, 0, 10, 5);
$page_data = $pagination->getData();
// var_dump($data);


// array(9) {
//       ["id"]=>
//       string(1) "2"
//       ["title"]=>
//       string(8) "hi again"
//       ["contt"]=>
//       string(24) "leave a message balabala"
//       ["email"]=>
//       string(6) "a@b.cc"
//       ["ipars"]=>
//       string(9) "127.0.0.1"
//       ["pictt"]=>
//       string(5) "face1"
//       ["reply"]=>
//       string(3) "lol"
//       ["times"]=>
//       string(19) "2015-01-22 16:01:36"
//       ["nname"]=>
//       string(2) "ui"
//     }
?>



<table class="pure-table pure-table-bordered pure-table-striped table100">
<caption>留言管理</caption>
<thead>
<tr>
	<td colspan="9" align="right">
	<form action="<?php print ENTRY_HOME?>/priv/feedback/search" class="pure-form">
	<input name="cond" value="<?php print $cond?>"><input type="submit" value="search" class="pure-button pure-button-primary">
	</form>
	</td>
</tr>
<tr>
	<th>#</th>
	<th>Name</th>
	<th>标题</th>
	<th>Email</th>
	<th>IP地址</th>
	<th>内容</th>
	<th>回复</th>
	<th>时间</th>
	<th>操作</th>
</tr>
</thead>
<tbody>
<?php foreach ($data["data"] as $item):?>
<tr>
	<td><?php print $item["id"]?></td>
	<td><?php print htmlspecialchars($item["nname"])?></td>
	<td><?php print htmlspecialchars($item["title"])?></td>
	<td><?php print htmlspecialchars($item["email"])?></td>
	<td><?php print htmlspecialchars($item["ipars"])?></td>
	<td><?php print htmlspecialchars($item["contt"])?></td>
	<td><?php print htmlspecialchars($item["reply"])?></td>
	<td><?php print htmlspecialchars($item["times"])?></td>
	<td>
		<a href="<?php print ENTRY_HOME?>/priv/feedback/remove?sid=<?php print $item["id"]?>" onclick="return confirm('?')">删除</a>
		<a href="<?php print ENTRY_HOME?>/priv/feedback/reply?sid=<?php print $item["id"]?>">回复</a>
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
	<a href="<?php echo ENTRY_HOME?>/feedback?page=<?php print $i+$page_data["start"]?>"><?php print $i+$page_data["start"]?></a>
<?php endif;?>
<?php endfor;?>
</div>
<?php endif;?>