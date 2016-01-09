<?php
if(!isset($data["msg"])){
	$data["msg"] = "";
}


?>

    <div class="container">
	<div class="row">
	
	<div class="col-md-6 col-md-offset-3">
	<div class="panel panel-default">
		<div class="panel-heading">修改密码</div>
	  <div class="panel-body">
	  <?php if($data["msg"]):?>
	    <div class="alert alert-danger" role="alert"><?php print $data["msg"]?></div>
	    <?php endif;?>
	      <form class="form-horizontal" method="post" action="<?php print App::url_ca("user","chpwd")?>">

	      <div class="form-group">
			    <label class="col-sm-3 control-label">当前密码</label>
			    <div class="col-sm-9">
			      <input type="text" name="oldpass" value="" class="form-control" placeholder="当前密码" required>
			    </div>
			</div>
	        <div class="form-group">
			    <label class="col-sm-3 control-label">新密码</label>
			    <div class="col-sm-9">
			      <input type="text" name="pass" value="" class="form-control" placeholder="新密码" required>
			    </div>
			</div>


	        
	        <button class="btn btn-lg btn-primary" type="submit">提交</button>
	      </form>		  
	  
	  
	  
	  
	  
	  
	  </div>
	</div>
	
	
	
	

	
	</div>
	
	
	</div>


    </div> <!-- /container -->