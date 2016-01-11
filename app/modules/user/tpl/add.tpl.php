<?php
if(!isset($data["msg"])){
	$data["msg"] = "";
}
if(!isset($data["def"])){
	$data["def"] = array(
		"name"=>"",
		"pass"=>"",
		"role"=>"search"
	);
}
if(!isset($data["act"])){
	$data["act"] = "add";
}else{
	$data["def"]["pass"] = "";
}
function formaction($act){
	if ($act == "add"){
		return App::url_ca("user",$act);
	}else{
		return App::url_ca("user","resetpwd") . "?sid=" . $_GET["sid"];
	}
}

?>

    <div class="container">
	<div class="row">
	
	<div class="col-md-6 col-md-offset-3">
	<div class="panel panel-default">
		<div class="panel-heading"><?php if($data["act"] == "add"):?>添加用户<?php else:?>重置密码<?php endif;?></div>
	  <div class="panel-body">
	  <?php if($data["msg"]):?>
	    <div class="alert alert-danger" role="alert"><?php print $data["msg"]?></div>
	    <?php endif;?>
	      <form class="form-horizontal" method="post" action="<?php print formaction($data["act"])?>">
	      <?php if($data["act"] == "resetpwd"):?>
	      <input type="hidden" name="sid" value="<?php print $_GET["sid"]?>">
	      
	      <?php endif;?>
	      
	        <div class="form-group">
	        	<label class="col-sm-2 control-label">用户名</label>
	        	<div class="col-sm-10">
	        	 <?php if($data["act"] == "resetpwd"):?>
			      <p class="form-control-static"><?php print $data["def"]["name"]?></p>
			      <?php else:?>
			      <input type="text" name="name" value="<?php print $data["def"]["name"]?>" class="form-control" placeholder="用户名">
			       <?php endif;?>
			    </div>
	        </div>
	        <div class="form-group">
			    <label class="col-sm-2 control-label"><?php if($data["act"] == "resetpwd"):?>新<?php endif;?>密码</label>
			    <div class="col-sm-10">
			      <input type="text" name="pass" value="<?php print $data["def"]["pass"]?>" class="form-control" placeholder="密码">
			    </div>
			</div>
        	<?php if($data["act"] == "add"):?>
	        <div class="form-group">
	        	<label class="col-sm-2 control-label">权限</label>
	        	<div class="col-sm-10">
	        	<select name="role" class="form-control">
	        	
	        	<?php foreach (App::$roles as $r=>$rx):?>
	        	<?php if($r == "debug")continue;?>
	        	<?php if($r == "guest")continue;?>
        		 <option value="<?php print $r?>"<?php if($data["def"]["role"] == $r):?> selected<?php endif;?>><?php print $rx?></option>
		       	<?php endforeach;?>
		       		 </select>
		       	</div>
	        </div>
	        <?php endif;?>

	        
	        <button class="btn btn-lg btn-primary" type="submit">提交</button>
	      </form>		  
	  
	  
	  
	  
	  
	  
	  </div>
	</div>
	
	
	
	

	
	</div>
	
	
	</div>


    </div> <!-- /container -->