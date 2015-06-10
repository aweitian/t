<?php 
//"wretwer":{"nt":"folder","order":"0","type":0,"label":[0],"type_deco":"pl","label_deco":"gold"}
require_once ENTRY_PATH."/app/data/datasrc/dataSrc.php";
require_once ENTRY_PATH."/lib/tian/formUI/fieldsManifest.php";
extract($data);
//var_dump($data);exit;
//这个地方使用了精简的fieldsManifest::$typeArr
$fieldArr = array(
	'textarea','input_datetime','input_date','enum','set','input_file','input_str','input_num'
);
?>
<div class="pure-g">
    <div class="pure-u-1-5"></div>
    <div class="pure-u-3-5">
		<h3 style="text-indent:10em;"><?php if($mode == "add"):?>添加<?php else:?>更新<?php endif;?>发货地址字段</h3>
		<form class="pure-form pure-form-aligned node-form" method="POST" action="<?php echo $submit_path;?>">
		    <fieldset>
		        <div class="pure-control-group">
		            <label>字段KEY：</label>
		            <input<?php echo $mode == "add" ? "" : " readonly"?> value="<?php echo $key;?>" type="text" placeholder='只能是小写字母和数字' name="key">
		        </div>
		
		        <div class="pure-control-group">
		            <label>字段名：</label>
		            <input value="<?php echo $val;?>" type="text" name="val" placeholder="顾客看到的名字">
		        </div>
		
		        <div class="pure-control-group">
		            <label>字段类型：</label>
		            <select name="typ">
                    <?php foreach($fieldArr as $tk):?>
                    <option value="<?php echo $tk;?>"<?php if($tk == $typ):?> selected<?php endif;?>><?php echo fieldsManifest::$typeArr[$tk];?></option>
                    <?php endforeach;?>
                    </select>
		        </div>
		
		        <div class="pure-control-group">
		            <label>类型补充说明：</label>
		            <input value="<?php echo $len;?>" type="text" name="len" placeholder="根据字段类型来定">
		        </div>
		
		        <div class="pure-control-group">
		            <label>是否允许为空：</label>
		            <select name="ept">
                    <option value="yes"<?php if('yes' == $ept):?> selected<?php endif;?>>是</option>
                    <option value="no"<?php if('no' == $ept):?> selected<?php endif;?>>否</option>
                    </select>
		        </div>
		        <div class="pure-control-group">
		            <label>备注：</label>
		            <textarea name="comment" cols="45" rows="8"></textarea>
		        </div>
		        		
		        <div class="pure-controls">
		            <button type="submit" class="pure-button pure-button-primary"><?php if($mode == "add"):?>添加<?php else:?>更新<?php endif;?></button>
		        </div>
		    </fieldset>
		</form>    
    
    </div>
    <div class="pure-u-1-5"></div>
</div>