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
<?php if($mode == "editdstype"):?>
<script>
function c(o){
	if(o.value != '<?php echo $dstype;?>')
	{
		$("#btn").attr("disabled",false);
	}else{
		$("#btn").attr("disabled",true);
	}
}

</script>



<?php endif;?>
<div class="pure-g">
    <div class="pure-u-1-5"></div>
    <div class="pure-u-3-5">
		<h3 style="text-indent:10em;"><?php if($mode == "add"):?>添加<?php else:?>更新<?php endif;?>一个数据命名空间</h3>
		<form class="pure-form pure-form-aligned node-form" method="POST" action="<?php echo $append_path;?>">
		<input type="hidden" name="<?php if ($mode == "add"):?>nodepath<?php else:?>path<?php endif;?>" value="<?php if($mode == "add") echo rtrim($path,"?");else echo $path?>">
		<?php if ($mode == "editdstype"):?>	
		 <input type="hidden" name="_dstype" value="1">
		<?php endif;?>
		    <fieldset>
<?php if ($mode != "editdstype"):?>			    
		        <div class="pure-control-group">
		            <label>名称：</label>
		            <input value="<?php echo $key;?>" type="text" placeholder='例如:class' name="key" title='只能是字母加空格'>
		        </div>
<?php endif;?>		        
<?php if ($mode != "edit"):?>		
		        <div class="pure-control-group">
		            <label>数据类型：</label>
		            <select id="dstype" name="dstype"<?php if($mode == "editdstype"):?> onchange="return c(this)"<?php endif;?>>
		            <?php foreach (dataSrc::$typeArr as $k => $v):?>
                    <option value="<?php echo $k?>"<?php if($k == $dstype):?> selected<?php endif;?>><?php echo $v;?></option>
                    <?php endforeach;?>
                    </select>
		        </div>
<?php endif;?>	
<?php if ($mode == "add"):?>	
		        <div class="pure-control-group">
		            <label>数据是否需要分类：</label>
		            <select id="nsroottype" name="nsroottype">
                    <option value="file"<?php if("file" == $nsroottype):?> selected<?php endif;?>>数据不分类</option>
                    <option value="folder"<?php if("folder" == $nsroottype):?> selected<?php endif;?>>数据分类</option>
                    </select>
		        </div>
<?php endif;?>
<?php if ($mode != "editdstype"):?>	
		        <div class="pure-control-group">
		            <label>路径装饰：<a href=""><i class="icon-uniE686"></i></a></label>
		            <input type="text" name="deco" value="<?php echo $deco;?>" placeholder='/aa/bb/cc,/kd/ek,...'>
		        </div>
		
		        <div class="pure-control-group">
		            <label>备注：</label>
		            <input name="comment" type="text" value="<?php echo $comment;?>" placeholder="写个备注,方便别人看的懂">
		        </div>
<?php else:?>
				<div class="textFail padding8" style="width:70%;margin:auto;">
				<br>
					<i class="icon-uniE68C"></i> 警告:修改类型,会删除下面所有数据.数据路径结构不会删除
				</div>
<?php endif;?>
		        <div class="pure-controls">
		            <button id="btn"<?php if($mode == "editdstype"):?> disabled<?php endif;?> type="submit" class="pure-button pure-button-primary"><?php if($mode == "add"):?>添加<?php else:?>更新<?php endif;?></button>
		        </div>
		    </fieldset>
		</form>    
    
    </div>
    <div class="pure-u-1-5"></div>
</div>
