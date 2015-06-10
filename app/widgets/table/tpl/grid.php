<?php
/**
 * Date: 2015-2-12
 * Author: Awei.tian
 * function:
 */
// var_dump($this->config->conf);exit;
$i = 0;
$j = 0;
$col = $this->config->conf["gridCol"];//显示为几列
?>
<div class="widget-table grid-table">
<?php foreach ($html as $ns => $tbdata):?>
<?php $i=0;$j=0;?>
<?php if ($mutistyle == "collapse"):?>
<?php $tbid = $this->order."-".str_replace("/","-",$ns)?>
<table id="<?php print $tbid?>"<?php if($ns != $default_ns):?>style="display:none"<?php endif;?>>
<?php else:?>
<table>
<caption><?php echo count($tbdata["body"])> 1 ? trim($ns,"/") : $this->config->conf["tableCaption"] == "" ? trim($ns,"/") : $this->config->conf["tableCaption"]?></caption>
<?php endif;?>
<tbody>
<?php foreach ($tbdata["body"] as $bdrow):?>
<?php if($i % $col == 0):?>
<?php $j = 0;?>
<tr>
<?php endif;?>
<td>

	
<?php switch ($this->confType):?>
<?php case "table_23tpe":?>
	<?php include dirname(__FILE__)."/grid_tpe.php";?>
<?php break;?>	
<?php case "table_23ldp":?>
	<?php include dirname(__FILE__)."/grid_ldp.php";?>
<?php break;?>	
<?php default:?>
	<div class="m-grid-title"><?php echo showTitle($this->config->conf,$bdrow[0])?></div>
	<div class="m-grid-price"><?php echo $bdrow[1]?></div>	
	<div class="m-grid-btn">
		<a href="<?php print app::pp(
				$this->getPpType(),
				htmlentities($this->path,ENT_QUOTES),
				$this->order,
				htmlentities($ns == "" ? "/" : $ns,ENT_QUOTES),
				htmlentities($bdrow[0],ENT_QUOTES)
			)?>">
			<?php print app::getBuyNowBtnHtml()?>
		</a>
	</div>
<?php endswitch;?>
	</td>
<?php if($j == $col - 1):?>
</tr>
<?php endif;?>
<?php $i++;$j++;?>
<?php endforeach;?>

<?php if(($j % $col) != 0):?>
<?php echo "</tr>";?>
<?php endif;?>
</tbody>
</table>
<?php endforeach;?>
</div>