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
// var_dump($data);exit;


// array(2) {
//   ["cnt"]=>
//   string(1) "7"
//   ["data"]=>
//   array(7) {
//     [0]=>
//     array(16) {
//       ["id"]=>
//       string(1) "1"
//       ["member_email"]=>
//       string(5) "a@b.c"
//       ["member_nknme"]=>
//       NULL
//       ["member_pswod"]=>
//       string(32) "5396017a1afce83cd9145bcde1f04d75"
//       ["member_fname"]=>
//       NULL
//       ["member_lname"]=>
//       NULL
//       ["member_squst"]=>
//       string(0) ""
//       ["member_sqkey"]=>
//       string(0) ""
//       ["member_ranks"]=>
//       string(6) "member"
//       ["member_vipid"]=>
//       NULL
//       ["member_cnsum"]=>
//       string(1) "0"
//       ["member_phone"]=>
//       NULL
//       ["member_mssnn"]=>
//       NULL
//       ["member_aimmm"]=>
//       NULL
//       ["member_yahoo"]=>
//       NULL
//       ["time"]=>
//       string(19) "2015-01-20 11:28:33"
//     }
?>



<table class="pure-table pure-table-bordered pure-table-striped table100">
<caption>注册会员管理</caption>
<thead>
<tr>
	<td colspan="6">
		<table width="100%">
		<tr>
			<td width=150><a href="">
				<button class="pure-button"><i class="icon-plus"></i> 添加</button>
			</a></td>
			<td align="right">
			<form action="<?php print ENTRY_HOME?>/priv/member/search" class="pure-form">
		<input name="cond" value="<?php print $cond?>"><input type="submit" value="search" class="pure-button pure-button-primary">
		</form>
			</td>
		</tr>
		</table>
	
	</td>
</tr>
<tr>
	<th>#</th>
	<th>Email</th>
	<th>会员级别</th>
	<th>消费金额</th>
	<th>时间</th>
	<th>操作</th>
</tr>
</thead>
<tbody>
<?php foreach ($data["data"] as $item):?>
<tr>
	<td><?php print $item["id"]?></td>
	<td><?php print htmlspecialchars($item["member_email"])?></td>
	<td><?php print htmlspecialchars($item["member_ranks"])?></td>
	<td><?php print htmlspecialchars($item["member_cnsum"])?></td>
	<td><?php print htmlspecialchars($item["time"])?></td>
	<td width=226>
		<a href="<?php print ENTRY_HOME?>/priv/member/remove?sid=<?php print $item["id"]?>" onclick="return confirm('?')">删除</a>
		<a href="<?php print ENTRY_HOME?>/priv/member/update?sid=<?php print $item["id"]?>">金额/级别</a>
		<a href="<?php print ENTRY_HOME?>/priv/member/resetpwd?sid=<?php print $item["id"]?>">密码</a>
		<a href="<?php print ENTRY_HOME?>/priv/member/view?sid=<?php print $item["id"]?>">详细</a>
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
	<a href="<?php echo ENTRY_HOME?>/member?page=<?php print $i+$page_data["start"]?>"><?php print $i+$page_data["start"]?></a>
<?php endif;?>
<?php endfor;?>
</div>
<?php endif;?>