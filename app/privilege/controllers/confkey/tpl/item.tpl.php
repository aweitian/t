<?php
/**
 * @author:awei.tian
 * @date: 2014-11-15
 * @functions:
 */
//type label为数据库中的原始值
//var_dump($defaultValue);exit;
require_once ENTRY_PATH."/app/data/datasrc/dataSrc.php";
extract($defaultValue);
?>

<div class="pure-g">
    <div class="pure-u-1-5"></div>
    <div class="pure-u-3-5">
		<h3 style="text-indent:10em;"><?php if($mode == "add"):?>添加<?php else:?>更新<?php endif;?>一个配置数据</h3>
		<form class="pure-form pure-form-aligned node-form" method="POST" action="<?php echo $append_path;?>">
		<input type="hidden" name="<?php if ($mode == "add"):?>path<?php else:?>path<?php endif;?>" value="<?php if($mode == "add") echo rtrim($path,"?");else echo $path?>">
		    <fieldset>
		        <div class="pure-control-group">
		            <label>名称：</label>
		            <input value="<?php echo $key;?>" type="text" placeholder='例如:class' name="key" title='只能是字母加空格'>
		        </div>
		        <?php if($mode == "edit"):?>
			        <div class="pure-control-group">
			            <label>数据类型：</label>
	                    <input readonly value="<?php echo conf::$typeArr[$typeid];?>" type="text">
	                    </select>
			        </div>
				<?php else:?>
			        <div class="pure-control-group">
			            <label>数据类型：</label>
			            <select name="type">
			            <?php foreach (conf::$typeArr as $k => $v):?>
	                    <option value="<?php echo $k?>"<?php if($k == $typeid):?> selected<?php endif;?>><?php echo $v;?></option>
	                    <?php endforeach;?>
	                    </select>
			        </div>				
				<?php endif;?>

		        <div class="pure-control-group">
		            <label>备注：</label>
		            <input name="comment" type="text" value="<?php echo $comment;?>" placeholder="写个备注,方便别人看的懂">
		        </div>
		        <div class="pure-controls">
		            <button id="btn"<?php if($mode == "editdstype"):?> disabled<?php endif;?> type="submit" class="pure-button pure-button-primary"><?php if($mode == "add"):?>添加<?php else:?>更新<?php endif;?></button>
		        </div>
		    </fieldset>
		</form>    
    
    </div>
    <div class="pure-u-1-5"></div>
</div>
