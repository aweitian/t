<?php
/**
 * Date: 2016年1月9日
 * Author: Awei.tian
 * Description: 
 */
if(!isset($data["msg"])){
	$data["msg"] = "";
}
?>
    <div class="container">
	<div class="row">
	
	<div class="col-md-12">
<form action="<?php print HTTP_ENTRY?>/main/editword" method="post">
  <div class="form-group">
    <label for="exampleInputPassword1">编辑负面词: <span id="form-msg" class="<?php if($data["result"]):?>text-success<?php else:?>text-danger<?php endif;?>"><?php print $data["msg"]?></span></label>
    
    <textarea name="w" class="form-control" rows="20"><?php print $data["content"]?></textarea>
  </div>
  <button type="submit" class="btn btn-primary">提交</button>
</form>


</div><!-- col-md-12 -->
</div><!-- row -->
</div><!-- container -->
<script>
$("#form-msg").show().delay(2000).hide(0);
</script>
