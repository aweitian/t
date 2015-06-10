<?php
/**
 * Date:2015年5月6日
 * Author:Awei.tian
 * Function:
 */
$profile_name = array(
		
);
var_dump($data);exit;
?>

<table>
<caption><a href="<?php print tian::$context->getRequest()->frontUrl()?>">Back</a></caption>
<?php foreach ($profile_name as $key => $val):?>
<tr><td><?php print $val?></td><td><?php print $data[$key]?></td></tr>
<?php endforeach;?>
</table>
