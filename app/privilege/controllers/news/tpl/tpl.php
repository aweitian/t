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
// exit;
?>



<table class="pure-table pure-table-bordered pure-table-striped table100">
<caption>新闻管理</caption>
<thead>
<tr>
	<td colspan="8">
		<a href="/ep/priv/news/add">
    		<button class="pure-button">
		    	<i class="icon-plus"></i>
		    	添加
			</button></a>
	</td>
</tr>
<tr>
	<th>#</th>
	<th>标题</th>
	<th>内容</th>
	<th>是否为图片</th>
	<th>图片名</th>
	<th>图片链接</th>
	<th>顺序</th>
	<th>日期</th>
	<th>操作</th>
</tr>
</thead>
<tbody>
<?php foreach ($data["data"] as $item):?>
<tr>
	<td><?php print $item["sid"]?></td>
	<td><?php print htmlspecialchars($item["title"])?></td>
	<td><?php print htmlspecialchars($item["content"])?></td>
	<td><?php print $item["sldflg"] == "1" ? "是":"否"?></td>
	<td><?php print ($item["sldimg"])?></td>
	<td><?php print ($item["lnk"])?></td>
	<td><?php print ($item["sldorder"])?></td>
	<td><?php print ($item["date"])?></td>
	<td>
		<a href="<?php print ENTRY_HOME?>/priv/news/remove?sid=<?php print $item["sid"]?>" onclick="return confirm('?')">删除</a>
		<a href="<?php print ENTRY_HOME?>/priv/news/edit?sid=<?php print $item["sid"]?>">编辑</a>
		<a href="<?php print ENTRY_HOME?>/priv/news/up?sid=<?php print $item["sid"]?>&f=<?php print ($item["sldflg"])?>"><?php print $item["sldflg"] == "1" ? "取消置顶":"置顶"?></a>
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
	<a href="<?php echo ENTRY_HOME?>/news?page=<?php print $i+$page_data["start"]?>"><?php print $i+$page_data["start"]?></a>
<?php endif;?>
<?php endfor;?>
</div>
<?php endif;?>