<?php
/**
 * Date: 2015-1-26
 * Author: Awei.tian
 * function: 
 */
$i = 0;
$colspan = 4;
?>
<div class="container f-box">
<?php foreach ($data["body"] as $row):?>
	<?php if($i % $colspan == 0 && $i > 0):?>
	</div><!-- row -->
	<?php endif;?>
	<?php if($i % $colspan == 0):?>
	<div class="row">
	<?php endif;?>
	
		<div class="col-<?php print 12/$colspan?>">
			<div class="f-container">
				<div class="f-bgf3 f-cb f-container hot-item">
						<div class="m-hot-title"><?php if($i < 3):?><i class="icon-uniE65B f-vam" style='color:#fe9900'></i><?php endif?><?php echo $row[0]?></div>
						<div class="m-hot-ico"><img src="<?php echo ENTRY_HOME?>/uploads/hots/<?php echo $row[3]?>"></div>
						<div class="m-hot-rgt">
							<del class="m-hot-ori f-tdt"><?php echo CURRENCY_SYMBOL." ".$row[1]?></del>
							<div class="m-hot-price">Only <b><?php echo CURRENCY_SYMBOL."".$row[2]?></b></div>
							<div class="m-hot-btn">
								<a href="<?php print app::pp("tb", "/", 0, $row[5], $row[0])?>">
									<button>buy now</button>
								</a>
							</div>
						</div>				
				
				</div>

			</div>
			
		</div><!-- col -->
	
	<?php $i++?>
<?php endforeach;?>

	<?php if($i % $colspan != 0):?>
	</div><!-- row -->
	<?php endif;?>
</div>
