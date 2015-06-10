<?php
/**
 * @author:awei.tian
 * @date: 2015-5-10
 * @functions:
 */


?>


<div id="foot">
<div class="foot-container">
<table width="100%" height="256" align="center">
<tr>
	<td width="33.3%">
		<div class="u-tt-md f-color_dark f-fwb" style="margin-bottom:8px;">Contact us:</div>
		
		<ul class="m-list" id="foot-contact">
			<li><span class="f-ib label">Skype:</span><span class="f-ibd">tonypl-sales</span></li>
			<li><span class="f-ib label">Sales Email:</span><span class="f-ib">tonyadk_27@hotmail.com</span></li>
			<li><span class="f-ib label">QQ:</span><span class="f-ib">2629438554</span></li>
		</ul>
	</td>
	<td width="33.3%">
		<div class="u-tt-md f-color_dark f-fwb" style="margin-bottom:8px;">Frequently asked questions:</div>
		
		<ul class="m-list" id="foot-contact">
			<li><a>How to get refund?</a></li>
			<li><a>How do you level my character?</a></li>
			<li><a>Are you affiliated with any other gaming companies?</a></li>
		</ul>	
	</td>
	<td width="33.3%">
		<div class="u-tt-md f-color_dark f-fwb" style="margin-bottom:8px;">About Us:</div>
		
		<ul class="m-list" id="foot-contact">
			<li><a>We do not keep the gold and items obtained</a></li>
			<li><a>Speed & flexability of the power leveling.</a></li>
			<li><a>Do you use bots or macros?</a></li>
		</ul>	
	</td>

</tr>
<tr>
	<td colspan="3" class="foot-link">
	<?php $i=0;?>
	<?php foreach (app::getPayMethods() as $pay):?>
		<img style="margin:15px;" alt="" src="<?php print ENTRY_HOME?>/static/images/payments/<?php print $pay?>.png">
	<?php $i++;if($i==3)echo "<br>"?>
	<?php endforeach;?>
	
	</td>
</tr>
<tr>
	<td colspan="3" class="foot-link">
	<a href="">About us</a>
	<a href="">VIP</a>
	<a href="">feedback</a>
	<a href="">feedback</a>
	
	</td>
</tr>
</table>
</div>
<p align="center">
&copy; tony 2015
</p>
</div>

<!-- 
 -->