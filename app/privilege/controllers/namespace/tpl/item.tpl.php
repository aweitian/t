<?php
/**
 * @author:awei.tian
 * @date: 2014-11-15
 * @functions:
 */
//type label为数据库中的原始值
//var_dump($defaultValue);exit;
extract($defaultValue);
?>
<div class="pure-g">
    <div class="pure-u-1-5"></div>
    <div class="pure-u-3-5">
		<h3 style="text-indent:10em;"><?php if($mode == "add"):?>添加<?php else:?>更新<?php endif;?>一个数据路径</h3>
		<form class="pure-form pure-form-aligned node-form" method="POST" action="<?php echo $append_path;?>">
		<input type="hidden" name="path" value="<?php echo $path;?>">
		    <fieldset>
		    	<div class="pure-control-group">
		            <label>数据路径类型：</label>
		            <?php if($mode == "add"):?>
		            <select name="nt">
                    <option value="folder">数据文件夹</option>
                    <option value="file">数据文件</option>
                    </select>
                    <?php else:?>
                    	<?php if($nt == "file"):?>
                    		<input type="text" readonly value="文件">
                    	<?php else:?>
                    	 	<input type="text" readonly value="文件夹">
                    	<?php endif;?>
                    <?php endif;?>
		        </div>
		        <div class="pure-control-group">
		            <label>名称：<?php if($mode == "edit"):?><i class="icon-uniE686" title="修改名称的同时要修改子路径,因为API没有做这个功能,所以先用删除,添加代替.如果有需要,等后期完善"></i><?php endif;?></label>
		            <input<?php if($mode == "edit"):?> readonly<?php endif;?> value="<?php echo $key;?>" type="text" placeholder='例如:pldata' name="key" title='不能是\ / < > ? | : * "'>
		        </div>
		        <div class="pure-control-group">
		            <label>付款地址别名：</label>
		            <select name="da">
                    <option value=""></option>
                    <?php foreach ($daArr as $item):?>
                    
                    <option value="<?php echo $item["key"];?>"<?php if($item["key"] == $da)echo " selected"?>><?php echo $item["val"];?></option>
                    
                    <?php endforeach;?>
                    </select>
		        </div>
		
		        <div class="pure-control-group">
		            <label>结点顺序：</label>
		            <input value="<?php echo $order;?>" type="text" name="order" placeholder="100" title="数字，从小到大排列">
		        </div>
		
		        <div class="pure-controls">
		            <button type="submit" class="pure-button pure-button-primary"><?php if($mode == "add"):?>添加<?php else:?>更新<?php endif;?></button>
		        </div>
		    </fieldset>
		</form>    
    
    </div>
    <div class="pure-u-1-5"></div>
</div>
