<?php 
//"wretwer":{"nt":"folder","order":"0","type":0,"label":[0],"type_deco":"pl","label_deco":"gold"}
require_once ENTRY_PATH."/app/data/datasrc/dataSrc.php";
extract($data);

//var_dump($fields);exit;

?>
<div class="pure-g">
    <div class="pure-u-1-5"></div>
    <div class="pure-u-3-5">
		<h3 style="text-indent:10em;"><?php if($mode == "add"):?>添加<?php else:?>更新<?php endif;?>发货地址类型</h3>
		<form class="pure-form pure-form-aligned node-form" method="POST" action="<?php echo $submit_path;?>">
		    <fieldset>
		        <div class="pure-control-group">
		            <label>类型名：</label>
		            <input type="text" placeholder='只能是小写字母和数字' name="name">
		        </div>
		
				<?php $vir = true;?>
				 <?php foreach($fields as $fk=>$fv):?>
				 <div class="pure-control-group">
				 <?php if($vir):?>
		            <label>字段选择：</label>
		            <?php $vir = false;?>
		         <?php else:?>
		         <label></label>
                 <?php endif;?>  
                    <input name="keylist[]" type="checkbox" value="<?php echo $fk;?>"<?php if(array_key_exists($fk, $keylist)):?> checked<?php endif;?>><?php echo $fv;?>
                   
		        </div>
		         <?php endforeach;?>
		       
		        		
		        <div class="pure-controls">
		            <button type="submit" class="pure-button pure-button-primary"><?php if($mode == "add"):?>添加<?php else:?>更新<?php endif;?></button>
		        </div>
		    </fieldset>
		</form>    
    
    </div>
    <div class="pure-u-1-5"></div>
</div>