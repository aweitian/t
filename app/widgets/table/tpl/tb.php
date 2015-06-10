<?php
/**
 * Date: 2015-2-12
 * Author: Awei.tian
 * function:
 */
// var_dump($this->config->conf);exit;

//var_export($html);exit;
?>
<?php foreach ($html as $ns => $tbdata):?>
<?php if ($mutistyle == "collapse"):?>
<?php $tbid = $this->order."-".str_replace("/","-",$ns)?>
<div class="m-table widget-table table-table">
<table id="<?php print $tbid?>"<?php if($ns != $default_ns):?>style="display:none"<?php endif;?>>
<?php else:?>
<div class="m-table widget-table table-table">
<table>
<caption><?php echo count($tbdata["body"])> 1 ? trim($ns,"/") : $this->config->conf["tableCaption"] == "" ? trim($ns,"/") : $this->config->conf["tableCaption"]?></caption>
<?php endif;?>
<thead>
<tr>
<?php foreach ($tbdata["head"] as $hd):?>
<th><?php echo $hd?></th>
<?php endforeach;?>
<?php if(count($tbdata["head"])):?>
<th>bn</th>
<?php endif;?>
</tr>
</thead>
<tbody>
<?php foreach ($tbdata["body"] as $bdrow):?>
<tr>
	<?php for($i=0;$i<count($bdrow)-1;$i++):?>
	<td><?php echo $i == 0 ? showTitle($this->config->conf,$bdrow[$i]) : $bdrow[$i]?></td>
	<?php endfor;?>
	<td>
	<a href="<?php print app::pp(
			$this->getPpType(), 
			htmlentities($this->path,ENT_QUOTES), 
			$this->order, 
			htmlentities($ns == "" ? "/" : $ns,ENT_QUOTES), 
			htmlentities($bdrow[$i],ENT_QUOTES)
		)?>">
		<?php print app::getBuyNowBtnHtml()?>
	</a>
	</td>
</tr>
<?php endforeach;?>
</tbody>
</table>
</div>
<?php endforeach;?>




