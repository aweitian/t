<?php
/**
 * 		return array(
				"title"=>$t,
				"price"=>$p,
				"ns"=>$ns,
				"np"=>$nodepath,
				"dt"=>$delivery_type,
				"wo"=>$wo,
				"delivery"=>$ui->getData()
		);
 */
// array (
// 		'title' => '3 g',
// 		'price' => 12.6,
// 		'ns' => '/fd/a',
// 		'np' => '/ui/axz',
// 		'dt' => 'pl',
// 		'wo' => '48',
// 		'delivery' =>
// 		array (
// 				'type' => 'pl',
// 				'data' =>
// 				array (
// 						'eml' =>
// 						array (
// 								'name' => 'Email',
// 								'html' => '<input name="eml">',
// 						),
// 						'tt' =>
// 						array (
// 								'name' => 'ttest',
// 								'html' => '<select name="tt"><option value=\'a\'>a</option><option value=\'b\'>b</option><option value=\'c\'>c</option></select>',
// 						),
// 				),
// 		),
// )



// switch ($wgtype){
// 	case "calcJS":
// 	case "calc":
// 		$locPriceStr = $locPrice["amount"];
// 		break;
// 	case "spancalcJS":
// 	case "spancalc":
// 		$locPriceStr = $locPrice["start"].",".$locPrice["end"];
// 		break;
// 	default:
// 		$locPriceStr = $locPrice;
// 		return ;
// }
//var_export($data);
?>
<script>
function checksubmit(form){
	var ret = true;
	$(":input[ept='no']",form).removeClass("err");
	$(":input[ept='no']",form).each(function(){
		if(ret){
			if(this.value == ""){
				ret = false;
				$(this).addClass("err");
				this.focus();
				return false;
			}
		}
	});
	return ret;
}
</script>
<div class="container">
<div class="row">
<div class="col-12 f-box">
				<div class="m-form" style="width:512px;margin:32px auto;">
				<fieldset>
					<legend>Welcome to choose us</legend>
					<div class="formitm">
						<label class="lab">Title:</label>
						<div class="ipt">
				        	<?php print $data["title"]?>
						</div>
					</div>		
					<div class="formitm">
						<label class="lab">Price:</label>
						<div class="ipt">
				        	<?php print $data["price"]?>
						</div>
					</div>		
					<form action="<?php print ENTRY_HOME?>/order/subscribe" method="post" onsubmit="return checksubmit(this)">
					<input type="hidden" name="qs" value="<?php print urlencode($rawQueryString);?>">
					<input type="hidden" name="pmtype" value="pp">
				<?php 
				//######################################################################
				//delivery约定在name前加上delivery_,约定于/app/modules/order/subsribe.php
				//######################################################################
				?>
				
				<?php foreach ($data["delivery"]["data"] as $dk => $dlv):?>
					<div class="formitm">
						<label class="lab"><?php print $dlv["name"]?>:</label>
						<div class="ipt">
				        	<?php 
				        		print str_replace("<input", "<input class=\"u-ipt\"",str_replace("name=\"", "name=\"delivery_", $dlv["html"]))
				        	?>
						</div>
					</div>	
				<?php endforeach;?>
				
						<div class="formitm">
						<label class="lab">Choose a payment:</label>
						<div class="ipt">
				        	<?php foreach (app::getPayMethods() as $pay):?>
				        	<div style="padding:5px;">
				        	<input<?php if($pay == "paypal"):?> checked<?php endif;?> id="paym_<?php print $pay?>" type="radio" name="pmtype" value="<?php print $pay?>">
				        	<label for="paym_<?php print $pay?>">
								<img alt="" src="<?php print ENTRY_HOME?>/static/images/payments/<?php print $pay?>.png">
				        	</label>
				        	</div>
				        	<?php endforeach;?>
						</div>
					</div>	
				
				
				
				
				 	<div class="formitm formitm-1"><button type="submit" class="u-btn" type="button">submit</button></div>
				</fieldset>
				</form>
				</div>
</div><!-- col -->
</div><!-- row -->
</div><!-- container -->
