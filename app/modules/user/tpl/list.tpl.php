<?php
// var_dump($data);exit;

?>

    <div class="container">
	<div class="row">
	
	<div class="col-md-12">

		<table class="table table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>登陆名</th>
				<th>权限</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($data as $item):?>
			<tr>
				<td><?php print $item["sid"]?></td>
				<td><?php print $item["name"]?></td>
				<td><?php print App::$roles[$item["role"]] ?></td>
				<td>
					
					<a title="重置密码" href="<?php print App::url_ca("user","resetpwd")."?sid=".$item["sid"]?>"><span class="glyphicon glyphicon-pencil"></span></a>
					<?php if(roleSession::getInstance()->getUserID() != $item["sid"]):?>
					&nbsp;&nbsp;&nbsp;
					<a title="删除" onclick="return confirm('?')" href="<?php print App::url_ca("user","rm")."?sid=".$item["sid"]?>"><span class="glyphicon glyphicon-trash text-danger"></span></a>
					<?php endif;?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
		</table>
	
	</div>
	
	
	</div>


    </div> <!-- /container -->