<?php
/**
 * Date: 2015-1-26
 * Author: Awei.tian
 * function: 
 */
// var_dump($data);exit;
?>



<table class="pure-table pure-table-bordered pure-table-striped table100">
<caption>后台用户管理</caption>
<thead>
<tr>
	<td colspan="5">
			<a href="<?php print ENTRY_HOME?>/priv/privusr/add">
				<button class="pure-button"><i class="icon-plus"></i> 添加</button>
			</a>
	</td>
</tr>
<tr>
	<th>#</th>
	<th>Name</th>
	<th>权限</th>
	<th>时间</th>
	<th>操作</th>
</tr>
</thead>
<tbody>
<?php foreach ($data as $item):?>
<tr>
	<td><?php print $item["id"]?></td>
	<td><?php print htmlspecialchars($item["name"])?></td>
	<td><?php print htmlspecialchars($item["privilege"])?></td>
	<td><?php print htmlspecialchars($item["time"])?></td>
	<td>
		<?php if(privusrController::hasPriv($item["name"])):?>
		<?php if($item["name"] != "Apocalypse"):?>
		<a href="<?php print ENTRY_HOME?>/priv/privusr/remove?sid=<?php print $item["id"]?>" onclick="return confirm('?')">删除</a>
		<?php endif;?>
		<a href="<?php print ENTRY_HOME?>/priv/privusr/resetpwd?sid=<?php print $item["id"]?>">修改密码</a>
		<?php endif;?>
	</td>
</tr>
<?php endforeach;?>
</tbody>
</table>
