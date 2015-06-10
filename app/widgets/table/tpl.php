<?php
/**
 * Date: 2015-2-11
 * Author: Awei.tian
 * function:
 */
// var_dump($this->config->conf);exit;
if(!function_exists("showTitle")){
	function showTitle($conf,$title){
		if(array_key_exists("titleType", $conf)){
			$type = $conf["titleType"];
		}else{
			$type = "text";
		}
		if($type == "text"){
			return $title;
		}else{
			return '<img src="'.$title.'">';
		}
	}
}
$mutistyle = $this->config->conf["mutistyle"];
if($mutistyle == "auto")
{
	$mutistyle = count($html)> 3 ? "collapse" : "expand";
}
$default_ns = key($html);
//TABLE CATPION 的选择:如果只有一个表格,tableCaption的优先级比ns高,其它情况ns高
?>
<script src="<?php echo ENTRY_HOME;?>/public/js/jquery-1.10.0.js"></script>
<script src="<?php echo ENTRY_HOME;?>/public/js/ext.js"></script>

<?php if ($mutistyle == "collapse"):?>

<div><select onchange="$('#widget-collapse-div-<?php print $this->order;?> table').hide();$('#'+this.value).show();">
<?php foreach ($html as $ns => $tbdata):?>
<?php $tbid = $this->order."-".str_replace("/","-",$ns)?>
<option value="<?php print $tbid?>"><?php print trim($ns,"/")?></option>
<?php endforeach;?>
</select></div>
<div id="widget-collapse-div-<?php print $this->order;?>">
<?php endif;?>


<?php if(array_key_exists("showType", $this->config->conf) && $this->config->conf["showType"] == "grid"):?>
	<?php include dirname(__FILE__)."/tpl/grid.php";?>
<?php else:?>
	<?php include dirname(__FILE__)."/tpl/tb.php";?>
<?php endif;?>


<?php if ($mutistyle == "collapse"):?>
</div><!-- end collapse div -->
<?php endif;?>
