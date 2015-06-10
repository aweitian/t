<?php
/**
 * Date: 2015-2-13
 * Author: Awei.tian
 * function:
 */
//var_dump($bdrow);exit;
?>

<?php switch ($this->config->conf["extraShowMask"]):?>
<?php case "tpe":?>
	<div class="m-grid-title"><?php echo showTitle($this->config->conf,$bdrow[0])?></div>
	<div class="m-grid-price"><?php echo $bdrow[1]?></div>	
	<div class="m-grid-extra"><?php echo $bdrow[2]?></div>	
<?php break;?>
<?php case "tep":?>
	<div class="m-grid-title"><?php echo showTitle($this->config->conf,$bdrow[0])?></div>
	<div class="m-grid-extra"><?php echo $bdrow[1]?></div>	
	<div class="m-grid-price"><?php echo $bdrow[2]?></div>	
<?php break;?>
<?php case "etp":?>
	<div class="m-grid-extra"><?php echo $bdrow[0]?></div>	
	<div class="m-grid-title"><?php echo showTitle($this->config->conf,$bdrow[1])?></div>
	<div class="m-grid-price"><?php echo $bdrow[2]?></div>	
<?php break;?>
<?php endswitch;?>
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
