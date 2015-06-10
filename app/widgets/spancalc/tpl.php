<?php
/**
 * @author:awei.tian
 * @date: 2014-12-27
 * @functions:http://www.cnblogs.com/lxblog/archive/2013/01/11/2856582.html
 */
$nsdata = $this->_getnamespacehtml();
$spandata = $this->_getspanhtml();
function jsargs(){
	$ouput = "";
	if($ouput == ""){
		if(STATIC_JS_SPANCALC_NAME != "g_spancalc")
		$ouput .= "?gvn=".STATIC_JS_SPANCALC_NAME;
	}else{
		if(STATIC_JS_SPANCALC_NAME != "g_spancalc")
			$ouput .= "&gvn=".STATIC_JS_SPANCALC_NAME;
	}
	return $ouput;
}
//数据源结构固定
function add_prefix_forname($str){
	return preg_replace("/name=\"([\w]+)\"/", "name=\"_$1\"",$str);
}
?>
<script src="<?php echo ENTRY_HOME;?>/public/js/jquery-1.10.0.js"></script>
<script src="<?php echo ENTRY_HOME;?>/public/js/ext.js"></script>
<script src="<?php echo ENTRY_HOME;?>/public/js/spancalc.js<?php echo jsargs();?>"></script>
<?php if($this->conf_spancalc_22ld->conf["cachejs"]):?>
<script>(function(){<?php echo STATIC_JS_SPANCALC_NAME?>['<?php echo $this->order?>']=<?php echo $this->getJsData()?>;})();</script>
<?php endif;?>
<style>
.u-dialog{
	position:relative;
}
.u-dialog .close{
	position:absolute;
	right:5px;
	top:5px;
	width:15px;
	height:15px;
	background:red;
	cursor:pointer;
}
</style>


<?php if(!$this->conf_spancalc_22ld->conf["cachejs"]):?>
<form action="<?php echo ENTRY_HOME;?>/order/estimate">
<input type="hidden" name="c" value="spancalc">
<input type="hidden" name="ns" value="<?php echo join(",", $this->uipatch_nsselector->getCurrentKeypath());?>">
<input type="hidden" name="np" value="<?php echo htmlentities($this->path);?>">
<input type="hidden" name="wo" value="<?php echo $this->order;?>">
<?php endif;?>


<div class="widget-spancalc">
<?php if($this->conf_spancalc_22ld->conf["cachejs"]):?>
<input type="hidden" id="np-<?php echo $this->order;?>" value="<?php echo htmlentities($this->path);?>">
<?php endif;?>
<input type="hidden" id="widget-spancalc-unit-<?php echo $this->order;?>" value="<?php echo $this->conf_spancalc_22ld->conf["unit"];?>">
<table>
<caption>Calc</caption>
<?php foreach($nsdata as $namespace):?>
<tr class="nsrow">
	<td><?php echo $namespace["name"]?></td>
	<td><?php echo add_prefix_forname($namespace["html"])?></td>
</tr>
<?php endforeach;?>

<tr class="currow">
	<td><?php echo $spandata["current"]["name"]?></td>
	<td><?php echo $spandata["current"]["html"]?></td>
</tr>

<tr class="destrow">
	<td><?php echo $spandata["destination"]["name"]?></td>
	<td><?php echo $spandata["destination"]["html"]?></td>
</tr>

<?php if($this->conf_spancalc_22ld->conf["cachejs"]):?>
	<tr>
		<td>
			<div class="estimate">
				<button class="u-btn u-btn-c4" onclick="<?php echo STATIC_JS_SPANCALC_NAME?>.estimate(<?php echo $this->order;?>)">Estimate</button>
			</div>
		</td>
		<td>
			<div class="buynow">
				<button class="u-btn u-btn-c4" onclick="<?php echo STATIC_JS_SPANCALC_NAME?>.buynow(<?php echo $this->order;?>)">Buy Now</button>
			</div>
		</td>
	</tr>
<?php else:?>
	<tr>
		<td colspan="2">
			<div class="buynow">
				<button type="submit">Buy Now</button>
			</div>
		</td>
	</tr>

<?php endif;?>

</table>
</div>



<?php if(!$this->conf_spancalc_22ld->conf["cachejs"]):?>
</form>
<?php endif;?>