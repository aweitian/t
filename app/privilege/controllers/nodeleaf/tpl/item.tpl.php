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
		<h3 style="text-indent:10em;"><?php if($mode == "add"):?>添加<?php else:?>更新<?php endif;?>一个结点</h3>
		<form class="pure-form pure-form-aligned node-form" method="POST" action="<?php echo $append_path;?>">
		<input type="hidden" name="nodepath" value="<?php echo $path;?>">
		    <fieldset>
		    	<div class="pure-control-group">
		            <label>结点类型：</label>
		            <?php if($mode == "add"):?>
		            <select name="nt">
                    <option value="folder">文件夹</option>
                    <option value="file">文件</option>
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
		            <label>名称：</label>
		            <input value="<?php echo $key;?>" type="text" placeholder='例如:World of warcraft' name="key" title='不能是\ / < > ? | : * "'>
		        </div>
		
		        <div class="pure-control-group">
		            <label>结点顺序：</label>
		            <input value="<?php echo $order;?>" type="text" name="order" placeholder="100" title="数字，从小到大排列">
		        </div>
		
		        <div class="pure-control-group">
		            <label>数据类型：</label>
		            <select name="type">
                    <option value="-1">空类型</option>
                    <?php foreach($types as $tk => $tv):?>
                    <option value="<?php echo $tk;?>"<?php if((1<<$tk) & $type):?> selected<?php endif;?>><?php echo $tv;?></option>
                    <?php endforeach;?>
                    </select>
		        </div>
		
		        <div class="pure-control-group">
		            <label>结点标签：</label>
		             <select name="label[]" multiple="multiple" title="最后一个点不掉?,按CTRL键点击">
	                  <?php foreach($labels as $lk => $lv):?>
	                  <option value="<?php echo $lk?>"<?php if((1<<$lk) & $label):?> selected<?php endif;?>><?php echo $lv;?></option>
	                  <?php endforeach;?>
	                  </select>
		        </div>
		
		        <div class="pure-controls">
		            <button type="submit" class="pure-button pure-button-primary"><?php if($mode == "add"):?>添加<?php else:?>更新<?php endif;?></button>
		        </div>
		    </fieldset>
		</form>    
    
    </div>
    <div class="pure-u-1-5"></div>
</div>
