<?php
//var_dump($data);exit;

?>
<style>
<!--

-->
</style>
    <div class="container">
	<div class="row">
	
	<div class="col-md-12">

		<table class="table table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>游戏名称</th>
				<th>付款金额</th>
				<th>代练时间</th>
				<th>顾客联系名</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($data as $item):?>
			<tr>
				<td><a title="订单轨迹查询" href="<?php print App::url_ca("his")."?sid=".$item["sid"]?>"><?php print $item["sid"]?></a></td>
				<td><?php print $item["gm_name"]?></td>
				<td><?php print $item["price"]?></td>
				<td><?php print $item["time"]?></td>
				<td><?php print $item["con_val"]?></td>
				<td>
					
					<a title="添加订单轨迹" href="<?php print App::url_ca("his","add")."?sid=".$item["sid"]?>"><span class="glyphicon glyphicon-plus"></span></a>
						&nbsp;&nbsp;&nbsp;
						<a title="订单编辑" href="<?php print App::url_ca("main","edit")."?sid=".$item["sid"]?>"><span class="glyphicon glyphicon-pencil"></span></a>
			
					&nbsp;&nbsp;&nbsp;
					<a title="订单删除" onclick="return confirm('?')" href="<?php print App::url_ca("main","rm")."?sid=".$item["sid"]?>"><span class="glyphicon glyphicon-trash text-danger"></span></a>
					&nbsp;&nbsp;&nbsp;
					<a title="订单详情" href="<?php print App::url_ca("main")."?sid=".$item["sid"]?>"><span class="glyphicon glyphicon-option-horizontal"></span></a>
					
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
		</table>

	
	</div>
	
	
	</div>


    </div> <!-- /container -->