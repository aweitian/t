<?php
/**
 * Date:2015年5月6日
 * Author:Awei.tian
 * Function:
 */
?>
<div class="container m-news f-box">
	<div class="row">
		<div class="col-9">
			<div style="padding-left:15px;">
				<?php print $this->getSlideNewsHtml()?>
			</div>
			
		</div>
		<div class="col-3">
			<div style="padding:0px 15px 0px 15px;">
				<div class="f-bgf3" style="padding:15px;">
					<?php print $this->getContactHtml()?>
				</div>
				
			</div>
			
		</div>
	
	</div>


</div>
<?php print $this->getHotHtml($hotdata)?>


