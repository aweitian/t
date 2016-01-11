<?php
/**
 * Date: 2016年1月9日
 * Author: Awei.tian
 * Description: 
 */
$chked = array(
	"url"=>true,
	"result"=>true,
	"ma_word"=>true,
	"rawhtml"=>false,
	"str_content"=>false
);
?>
<div class="container">
<div class="row">
<div class="col-md-12">

<form action="" method="post">
<?php foreach ($data as $key => $val):?>
<div class="checkbox">
  <label>
    <input type="checkbox" name="col[]" value="<?php print $key?>"<?php if(array_key_exists($key, $chked) && $chked[$key]):?> checked<?php endif;?>><?php print $val?>
  </label>
</div>
<?php endforeach;?>
<button type="submit" class="btn btn-info">下载EXCEL格式文件</button>
</form>




</div><!-- col-md-12 -->
</div><!-- row -->
</div><!-- container -->