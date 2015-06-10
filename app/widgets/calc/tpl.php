<?php
/**
 * @author:awei.tian
 * @date: 2014-12-27
 * @functions:http://www.cnblogs.com/lxblog/archive/2013/01/11/2856582.html
 */
//var_dump($this->config);exit;
//$this->setNsPath("/fd/a");
$data = $this->DataSrc_nsdata->data["datasrc"][$this->uipatch_nsselector->getCurrentKeypathStr()];
$deco = $this->getNsDeco();
$nsdata = $this->uipatch_nsselector->getData();

$defaultAmount = 1;
$ds = new DataSrc_22ap($data);
//var_dump($ds->getPrice(array("amount"=>$defaultAmount)));exit;

// var_dump($this->DataSrc_nsdata->data["datasrc"]);exit;
// var_dump($this->DataSrc_nsdata->data["data"]);exit;
// var_dump($ns_html_data);
function jsargs(){
	$ouput = "";
	if($ouput == ""){
		$ouput .= "?gvn=".STATIC_JS_CALC_NAME;
	}else{
		if(STATIC_JS_CALC_NAME != "g_calc")
		$ouput .= "&gvn=".STATIC_JS_CALC_NAME;
	}
	return $ouput;
}
//数据源结构固定
function add_prefix_forname($str){
	return preg_replace("/name=\"([\w]+)\"/", "name=\"_$1\"",$str);
}
?>
<script src="<?php echo ENTRY_HOME;?>/static/js/jquery-1.10.0.js"></script>
<script src="<?php echo ENTRY_HOME;?>/static/js/ext.js"></script>
<script src="<?php echo ENTRY_HOME;?>/static/js/calc.js<?php echo jsargs();?>"></script>
<?php if($this->config->conf["cachejs"]):?>
<script>(function(){<?php echo STATIC_JS_CALC_NAME?>['<?php echo $this->order?>']=<?php echo $this->getJsData()?>;})();</script>
<?php endif;?>



<?php if(!$this->config->conf["cachejs"]):?>
<form action="<?php echo ENTRY_HOME;?>/order/estimate" method="get">
<input type="hidden" name="c" value="calc">
<input type="hidden" name="ns" value="<?php echo join(",", $this->uipatch_nsselector->getCurrentKeypath());?>">
<input type="hidden" name="np" value="<?php echo htmlentities($this->path);?>">
<input type="hidden" name="wo" value="<?php echo $this->order;?>">

<?php endif;?>


<div class="widget-calc">
<input type="hidden" id="np-<?php echo $this->order;?>" value="<?php echo htmlentities($this->path);?>">
<input type="hidden" id="widget-calc-unit-<?php echo $this->order;?>" value="<?php echo $this->config->conf["unit"];?>">
<table>
<?php foreach($nsdata as $namespace):?>
<tr class="nsrow">
	<td><?php echo $namespace["name"]?></td>
	<td><?php echo add_prefix_forname($namespace["html"])?></td>
</tr>
<?php endforeach;?>

<tr>
	<td style="width:64px;">Amount:</td>
	<td><input type="text" name="amount" size="4" value="1"> &times; <?php echo $this->config->conf["unit"];?></td>
</tr>
<tr>
	<td>Price:</td>
	<td><span class="u-price"></span><?php echo CURRENCY_SYMBOL;?> <?php print $ds->getPrice(array("amount"=>$defaultAmount))?></td>
</tr>

<?php if($this->config->conf["cachejs"]):?>
	<tr>
		<td>
			<div class="estimate">
				<button class="u-btn u-btn-c4" onclick="<?php echo STATIC_JS_CALC_NAME?>.estimate(<?php echo $this->order;?>)">Estimate</button>
			</div>
		</td>
		<td>
			<div class="buynow">
				<button class="u-btn u-btn-c4" onclick="<?php echo STATIC_JS_CALC_NAME?>.buynow(<?php echo $this->order;?>)">Buy Now</button>
			</div>
		</td>
	</tr>
<?php else:?>
	<tr>
		<td>
			<div class="estimate">
				<button class="u-btn u-btn-c4" type="button">Estimate</button>
			</div>
		</td>
		<td>
			<div class="buynow">
				<button class="u-btn u-btn-c4" type="submit">Buy Now</button>
			</div>
		</td>
	</tr>

<?php endif;?>

</table>
</div>



<?php if(!$this->config->conf["cachejs"]):?>
</form>
<?php endif;?>