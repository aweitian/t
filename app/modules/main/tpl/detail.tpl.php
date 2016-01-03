<?php
//var_dump($data);exit;
function con_val($w){
	switch ($w){
		case "wx":
			return "微信";
		default:
			return "旺旺";
	}
}
?>
<style>
<!--

-->
</style>
    <div class="container">
	<div class="row">
	
	<div class="col-md-12">
		<?php /*var_dump($data)*/?>
		
		<div class="panel panel-default">
		  <!-- Default panel contents -->
		  <div class="panel-heading">订单全部信息</div>
		
		  <!-- Table -->
		  <table class="table table-bordered table-striped">
		  <tbody>
		  <tr><td class="text-right">订单ID</td><td><?php print $data["sid"]?></td></tr>
		  
		  <tr><td class="text-right" style="width: 33.3%">付款金额</td><td><?php print $data["price"]?></td></tr>
		  <tr><td class="text-right">够买的代练时间</td><td><?php print $data["time"]?></td></tr>
		  <tr><td class="text-right">顾客联系名</td><td><?php print con_val($data["con_type"]).":";print $data["con_val"]?></td></tr>
		  <tr><td class="text-right">游戏名称</td><td><?php print $data["gm_name"]?></td></tr>
		  <tr><td class="text-right">顾客游戏名</td><td><?php print $data["char_name"]?></td></tr>
		  <tr><td class="text-right">付款方式</td><td><?php print $data["pay_type"]?></td></tr>
		  <tr><td class="text-right">顾客来源渠道</td><td><?php print $data["ad_from"]?></td></tr>
		  <tr><td class="text-right">接单人</td><td><?php print $data["op_name"]?></td></tr>
		  <tr><td class="text-right">添加时间</td><td><?php print $data["date"]?></td></tr>
		  </tbody>
		  </table>
		</div>
		
		
	</div><!-- /col-md-12 -->
	
	
	</div><!-- /row -->


    </div> <!-- /container -->