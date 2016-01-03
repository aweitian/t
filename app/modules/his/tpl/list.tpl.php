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
		<div class="alert<?php if($data["rmTime"]>0):?> alert-success<?php else:?> alert-danger<?php endif;?>" role="alert">
			此订单还剩 <b><?php print $data["rmTime"]?></b> 小时,ID: 
			<?php print $data["data"]["sid"]?>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a class="btn btn-default" href="<?php print App::url_ca("his","add")."?sid=".$data["data"]["sid"]?>" role="button">添加记录</a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			
			<a href="<?php print App::url_ca("main")."?sid=".$data["data"]["sid"]?>" role="button">订单全部信息</a>
			
		</div>
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">订单摘要</h3></div>
			
		  <div class="panel-body">
		  <table class="table table-bordered">
			<tbody>
			<tr>
				<td>价格: <?php print $data["data"]["price"]?></td>
				<td>时间: <?php print $data["data"]["time"]?></td>
				<td>游戏名: <?php print $data["data"]["gm_name"]?></td>
				<td>角色名: <?php print $data["data"]["char_name"]?></td>
			</tr>
			</tbody>
			</table>
		    <?php /*var_dump($data["data"])*/?>
		  </div>
		</div>
		<?php $i=0; foreach($data["his"] as $his):?>
		<div class="panel panel-default">
		  <div class="panel-body">
		  <h3>
			  #<?php print ++$i?>
			  &nbsp;&nbsp;&nbsp;
			   <a style="font-size: 15px" title="编辑" href="<?php print App::url_ca("his","edit")."?sid=".$his["sid"]?>"><span class="glyphicon glyphicon-pencil"></span></a>
		&nbsp;&nbsp;&nbsp;
		<a style="font-size: 15px" title="删除" onclick="return confirm('?')" href="<?php print App::url_ca("his","rm")."?sid=".$his["sid"]?>"><span class="glyphicon glyphicon-trash text-danger"></span></a>
					
			 </h3>
			 消耗: <?php print ($his["exhaust"])?> 小时<br>
		   日期: <?php print ($his["op_date"])?><br>
		 备注: <?php print ($his["mark"])?>
		    <?php /*var_dump($his)*/?>
		  </div>
		</div>
		<?php endforeach;?>
	</div>
	
	
	</div>


    </div> <!-- /container -->