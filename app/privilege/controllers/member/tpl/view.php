<?php
/**
 * Date:2015年5月5日
 * Author:Awei.tian
 * Function:
 */
// var_dump($data);exit;
?>
<div style="width:512px;margin:18px auto;">
<table class="pure-table pure-table-bordered pure-table-striped">
<?php foreach ($data as $k=>$v):?>
<tr><td><?php print $k?></td><td><?php print $v?></td></tr>
<?php endforeach;?>
<tr><td colspan="2"><a href="<?php print tian::$context->getRequest()->frontUrl()?>">返回</a></td></tr>
</table>
</div>