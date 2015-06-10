<?php
/**
 * @author:awei.tian
 * @date: 2014-11-15
 * @functions:
 */
//type label为数据库中的原始值
//var_dump($defaultValue);exit;
require_once ENTRY_PATH."/app/data/datasrc/dataSrc.php";
require_once ENTRY_PATH."/app/data/conf/base/conf.php";
extract($defaultValue);

$dkArr = $this->autoCompleteDk($typeid);
$ckArr = $this->autoCompleteCk($typeid);
// var_dump($tplArr);exit;
?>
<script>
function html2Escape(sHtml) {
	return sHtml.replace(/[<>&"]/g,function(c){return {'<':'&lt;','>':'&gt;','&':'&amp;','"':'&quot;'}[c];});
}
function ajaxCDK(o){
	$.getJSON("<?php echo ENTRY_HOME?>/priv/widget/listDk?dk="+o.value,function(dko){
		var dkhtml = [];
		for(var i=0;i<dko.length;i++){
			dkhtml.push('<option value="'+html2Escape(dko[i])+'">'+dko[i]+'</option>');
		}
		$("select[name=datasrcpath]").html(dkhtml.join(""));
	});
	$.getJSON("<?php echo ENTRY_HOME?>/priv/widget/listCk?ck="+o.value,function(cko){
		var ckhtml = [];
		for(var i=0;i<cko.length;i++){
			ckhtml.push('<option value="'+html2Escape(cko[i])+'">'+cko[i]+'</option>');
		}
		$("select[name=confpath]").html(ckhtml.join(""));
	});
	
}
</script>
<div class="pure-g">
    <div class="pure-u-1-5"></div>
    <div class="pure-u-3-5">
		<h3 style="text-indent:10em;"><?php if($mode == "add"):?>添加<?php else:?>更新<?php endif;?>一个页面组件</h3>
		<form class="pure-form pure-form-aligned node-form" method="POST" action="<?php echo $append_path;?>">
		<input type="hidden" name="path" value="<?php echo $path?>">
		    <fieldset>
		        <div class="pure-control-group">
		            <label>顺序：</label>
		            <?php if($mode == "edit"):?>
					<input  type="hidden" name="old_order" value="<?php echo $order;?>">
		            <?php endif;?>
		            <input value="<?php echo $order;?>" type="text" name="<?php if($mode == "add"):?>order<?php else:?>new_order<?php endif;?>" style="width:150px"> <i>(不要求连续,但要求在一个页面中唯一)</i>
		        </div>
		        <div class="pure-control-group">
		            <label>组件类型：</label>
		            <select id="dstype" name="typeid" onchange="ajaxCDK(this)">
		            <?php foreach (conf::$typeArr as $k => $v):?>
                    <option value="<?php echo $k?>"<?php if($k == $typeid):?> selected<?php endif;?>><?php echo $v;?></option>
                    <?php endforeach;?>
                    </select>
		        </div>
		        <div class="pure-control-group">
		            <label>数据源路径：<a href=""><i class="icon-uniE686"></i></a></label>
		            <select name="datasrcpath">
		            <?php foreach ($dkArr as $dk):?>
		            <option value="<?php echo htmlentities($dk)?>"<?php if($dk == $datasrcpath):?> selected<?php endif;?>><?php echo $dk?></option>
		            <?php endforeach;?>
		            </select>
		        </div>
		        <div class="pure-control-group">
		            <label>配置源路径：<a href=""><i class="icon-uniE686"></i></a></label>
		             <select name="confpath">
		            <?php foreach ($ckArr as $ck):?>
		            <option value="<?php echo htmlentities($ck)?>"<?php if($ck == $confpath):?> selected<?php endif;?>><?php echo $ck?></option>
		            <?php endforeach;?>
		            </select>
		        </div>
		        <div class="pure-control-group">
		            <label>发货类型:<a href=""><i class="icon-uniE686"></i></a></label>
		             <select name="ordertpl">
		            <?php foreach ($tplArr as $tpl):?>
		            <option value="<?php echo htmlentities($tpl)?>"<?php if($tpl == $ordertpl):?> selected<?php endif;?>><?php echo $tpl?></option>
		            <?php endforeach;?>
		            </select>
		        </div>
		
		        <div class="pure-control-group">
		            <label>备注：</label>
		            <input name="comment" type="text" value="<?php echo $comment;?>" placeholder="写个备注,方便别人看的懂">
		        </div>
		        <div class="pure-controls">
		            <button id="btn" type="submit" class="pure-button pure-button-primary"><?php if($mode == "add"):?>添加<?php else:?>更新<?php endif;?></button>
		        </div>
		    </fieldset>
		</form>    
    
    </div>
    <div class="pure-u-1-5"></div>
</div>
