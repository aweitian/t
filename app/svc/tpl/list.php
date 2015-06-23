<?php
/**
 * Date:2015年4月7日
 * Author:Awei.tian
 * Function:
 */
// var_dump($data);exit;
$colspan = 4;
// $colspan_width = (int)(99 / $colspan);
var_export($data);exit;
?>
<div class="container">
<div class="row f-box">
	
	<?php foreach ($data as $path):?>
	<div class="col-<?php print 12/$colspan?>">
		<a class="f-color-dark" style="line-height: 200%" href="<?php print ENTRY_HOME?>/<?php print SVC_NAME;print $path?>"><?php $arr=explode("/", $path); print end($arr)?></a>
	</div>
	<?php endforeach;?>

</div>


</div>

