<?php
/**
 * @author:awei.tian
 * @date: 2014-11-15
 * @functions:
 */
extract($default);
?>
<div class="pure-g">
    <div class="pure-u-1-5"></div>
    <div class="pure-u-3-5">
		<h3 style="text-indent:10em;"><?php if($mode == "add"):?>添加<?php else:?>更新<?php endif;?>一个结点标签</h3>
		<form class="pure-form pure-form-aligned node-form" method="POST" action="<?php echo $submit_path;?>">
		<?php if($mode == "edit"):?><input type="hidden" name="lk" value="<?php echo $lk;?>"><?php endif;?>
		    <fieldset>
		        <div class="pure-control-group">
		            <label>标签名：</label>
		            <input value="<?php echo $lv;?>" type="text" placeholder='例如:wow' name="lv">
		        </div>
		
		        <div class="pure-controls">
		            <button type="submit" class="pure-button pure-button-primary"><?php if($mode == "add"):?>添加<?php else:?>更新<?php endif;?></button>
		        </div>
		    </fieldset>
		</form>    
    
    </div>
    <div class="pure-u-1-5"></div>
</div>
