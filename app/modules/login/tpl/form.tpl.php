<?php


?>
    <div class="container">
	<div class="row">
	
	<div class="col-md-6 col-md-offset-3">
	<br><br><br><br>
	<div class="panel panel-default">
		<div class="panel-heading"><h2 class="form-signin-heading">登陆</h2></div>
	  <div class="panel-body">
	  <?php if($data["loginMsg"]):?>
	    <div class="alert alert-danger" role="alert"><?php print $data["loginMsg"]?></div>
	    <?php endif;?>
			      <form class="form-signin" method="post" action="<?php print App::url_ca("login")?>">
			        <div class="form-group">
			        	<input type="text" name="n" class="form-control" placeholder="name" required autofocus>
			        </div>
			        <div class="form-group">
			       		 <input type="password" name="p" class="form-control" placeholder="Password" required>
			        </div>
			        <button class="btn btn-lg btn-primary btn-block" type="submit">提交</button>
			      </form>		  
	  
	  
	  
	  
	  
	  
	  </div>
	</div>
	
	
	
	

	
	</div>
	
	
	</div>


    </div> <!-- /container -->