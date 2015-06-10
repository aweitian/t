<?php
/**
 * Date: 2015-1-5
 * Author: Awei.tian
 * function: 
 */
?>
<table>
<thead>
<tr>
	<th>dksid</th>
	<th>p</th>
	<th>t</th>
</tr>
</thead>
<tbody>
<?php foreach ($data as $item):?>
<tr>
	<th><?php print $item["dksid"]?></th>
	<th><?php print $item["p"]?></th>
	<th><?php print $item["t"]?></th>
</tr>
<?php endforeach;?>
</tbody>
</table>
