<?php
if(!isset($data["msg"])){
	$data["msg"] = "";
}
if(!isset($data["def"])){
	$data["def"] = array(
		"did" => $_GET["sid"],
		"exhaust"=>"",
		"mark"=>"",
		"op_date"=>date("Y-m-d",time())
	);
}
if(!isset($data["act"])){
	$data["act"] = "add";
}
function formaction($act,$did=""){
	if ($act == "add"){
		return App::url_ca("his",$act) . "?sid=" . $did;
	}else{
		return App::url_ca("his",$act) . "?sid=" . $did;
	}
}
if ($data["act"] == "add"){

}else {
	
	
}
?>
<style>
<!--

-->
</style>
    <div class="container">
	<div class="row">
	
	<div class="col-md-6 col-md-offset-3">
	<div class="panel panel-default">
		<div class="panel-heading"><?php if($data["act"] == "add"):?>添加<?php else:?>编辑<?php endif;?>订单轨迹 (<a href="<?php print App::url_ca("his")."?sid=".$data["def"]["did"]?>">查看订单轨迹</a>)</div>
	  <div class="panel-body">
	  <?php if($data["msg"]):?>
	    <div class="alert alert-danger" role="alert"><?php print $data["msg"]?></div>
	    <?php endif;?>
	      <form class="form-signin" method="post" action="<?php print formaction($data["act"],$_GET["sid"])?>">
	      <?php if($data["act"] == "add"):?>
	      <input type="hidden" name="did" value="<?php print $_GET["sid"]?>">
	      <?php endif;?>
	      
	      <?php if($data["act"] == "edit"):?>
	      <input type="hidden" name="sid" value="<?php print $_GET["sid"]?>">
	      
	      <?php endif;?>
	        <div class="form-group">
	        	<label>本次完成时间,还剩: <b><?php print $data["rmtime"]?></b> (小时)</label>
	        	<input type="text" name="exhaust" value="<?php print $data["def"]["exhaust"]?>" class="form-control" placeholder="本次完成时间" required autofocus>
	        </div>
	        
	        
	        <div class="form-group">
	        	<label>备注</label>
	       		 <input type="text" name="mark" value="<?php print $data["def"]["mark"]?>" class="form-control" placeholder="备注">
	        </div>

	        <div class="form-group">
	        	<label>日期</label>
	       		 <input type="text" name="op_date" value="<?php print $data["def"]["op_date"]?>" class="form-control" placeholder="日期" required>
	        </div>
	        <button class="btn btn-lg btn-primary" type="submit">提交</button>
	      </form>		  
	  
	  
	  
	  
	  
	  
	  </div>
	</div>
	
	
	
	

	
	</div>
	
	
	</div>


    </div> <!-- /container -->