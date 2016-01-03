<?php
if(!isset($data["msg"])){
	$data["msg"] = "";
}
if(!isset($data["def"])){
	$data["def"] = array(
		"price"=>"",
		"time"=>"",
		"con_type"=>"ww",
		"con_val"=>"",
		"gm_name"=>"",
		"char_name"=>"",
		"pay_type"=>"",
		"ad_from"=>"",
		"op_name"=>""
	);
}
if(!isset($data["act"])){
	$data["act"] = "add";
}
function formaction($act){
	if ($act == "add"){
		return App::url_ca("main",$act);
	}else{
		return App::url_ca("main",$act) . "?sid=" . $_GET["sid"];
	}
}

?>
<style>
<!--
form label{
	display:none;
}
-->
</style>
    <div class="container">
	<div class="row">
	
	<div class="col-md-6 col-md-offset-3">
	<div class="panel panel-default">
		<div class="panel-heading"><?php if($data["act"] == "add"):?>添加<?php else:?>编辑<?php endif;?>订单记录</div>
	  <div class="panel-body">
	  <?php if($data["msg"]):?>
	    <div class="alert alert-danger" role="alert"><?php print $data["msg"]?></div>
	    <?php endif;?>
	      <form class="form-signin" method="post" action="<?php print formaction($data["act"])?>">
	      <?php if($data["act"] == "edit"):?>
	      <input type="hidden" name="sid" value="<?php print $_GET["sid"]?>">
	      
	      <?php endif;?>
	      
	        <div class="form-group">
	        	<label>价格</label>
	        	<input type="text" name="price" value="<?php print $data["def"]["price"]?>" class="form-control" placeholder="价格" required autofocus>
	        </div>
	        
	        
	        <div class="form-group">
	        	<label>够买的代练时间</label>
	       		 <input type="text" name="time" value="<?php print $data["def"]["time"]?>" class="form-control" placeholder="够买的代练时间" required>
	        </div>
	        
	        
	        <div class="form-group">
					<select name="con_type" class="btn btn-default">
		       		 <option value="ww"<?php if($data["def"]["con_type"] == "ww"):?> selected<?php endif;?>>旺旺</option>
		       		 <option value="wx"<?php if($data["def"]["con_type"] == "wx"):?> selected<?php endif;?>>微信</option>
		       		 </select>
				<input class="form-control" name="con_val" value="<?php print $data["def"]["con_val"]?>" type="text" placeholder="顾客联系名">
			</div>
			
			
			<div class="form-group">
	        	<label>游戏名称</label>
	       		 <input type="text" name="gm_name" value="<?php print $data["def"]["gm_name"]?>" class="form-control" placeholder="游戏名称">
	        </div>
	        
	        <div class="form-group">
	        	<label>顾客游戏名</label>
	       		 <input type="text" name="char_name" value="<?php print $data["def"]["char_name"]?>" class="form-control" placeholder="顾客游戏名">
	        </div>
	        
	        <div class="form-group">
	        	<label>付款方式</label>
	       		 <input type="text" name="pay_type" value="<?php print $data["def"]["pay_type"]?>" class="form-control" placeholder="付款方式">
	        </div>
	        
	        <div class="form-group">
	        	<label>顾客来源渠道</label>
	       		 <input type="text" name="ad_from" value="<?php print $data["def"]["ad_from"]?>" class="form-control" placeholder="顾客来源渠道">
	        </div>
	        
	        <div class="form-group">
	        	<label>接单人</label>
	       		 <input type="text" name="op_name" value="<?php print $data["def"]["op_name"]?>" class="form-control" placeholder="接单人">
	        </div>
	        
	        <button class="btn btn-lg btn-primary" type="submit">提交</button>
	      </form>		  
	  
	  
	  
	  
	  
	  
	  </div>
	</div>
	
	
	
	

	
	</div>
	
	
	</div>


    </div> <!-- /container -->