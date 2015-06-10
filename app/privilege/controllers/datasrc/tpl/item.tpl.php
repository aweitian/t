<?php 
//"wretwer":{"nt":"folder","order":"0","type":0,"label":[0],"type_deco":"pl","label_deco":"gold"}
require_once ENTRY_PATH.'/app/data/datasrc/dataSrc.php';
function subPath($p,$k){
	if(substr($p,-1)=="/")return $p.$k;
	return $p."/".$k;
}
function navPath(DataSrcPath $path,pview $view){
	$cur = "";
	$part_node = "<a href='".ENTRY_HOME."/priv/node?nodepath=".urlencode("/")."'>///</a>";
	if($path->getNodePath() == "/"){
		$part_node .= "";
	}else{
		$data = explode("/", trim($path->getNodePath(),"/"));
		foreach ($data as $v){
			$cur = $cur."/".$v;
			$part_node .= " > <a href='".ENTRY_HOME."/priv/node?nodepath=".urlencode($cur)."'>". $v . "</a>";
		}		
	}
	return $part_node;
}
function nspath(DataSrcPath $path,pview $view){
	$cur = "";
	$part_ns = "<a href='".ENTRY_HOME."/priv/namespace?path=".urlencode($path->getNodePath()."?".$path->getDatakey()."/")."'>///</a>";
	if($path->getNsPath() == "/"){
		$part_ns .= "";
	}else{
		$data = explode("/", trim($path->getNsPath(),"/"));
		foreach ($data as $v){
			$cur = $cur."/".$v;
			$part_ns .= " > <a href='".ENTRY_HOME."/priv/namespace?path=".urlencode($path->getNodePath()."?".$path->getDatakey().$cur)."'>". $v . "</a>";
		}		
	}
	return $part_ns;
}
?><script type="text/javascript">
<!--
var sampleData = <?php echo json_encode(dataSrc::$samples[$data["type"]])?>;
var bak;
function checkdatavalid(){
	if(sampleData.constructor && (sampleData.constructor == Array||sampleData.constructor == Object)){
		var d = $("#data").val();
		try{
			d = JSON.parse(d);
		}catch(e){}
		return (d&&typeof d == "object")
	}else{
		return true;
	}
}
function formatData(){
	var d = $("#data").val();
	var fd = JSON.beauty(JSON.parse(d),true,1,true)
	$("#data").val(fd);
}
function compressData(){
	var bd = $("#data").val();
	if(checkdatavalid()){
		var fd = JSON.stringify(JSON.parse(bd),true,1,true);
		if(fd)return $("#data").val(fd);
	}else{
		$("#data").val(bd);
	}
	alert("数据有格式错误")
}
function showSampleData(o){
	if($(o).attr("ut") == "sample"){
		bak = $("#data").val();
		if(sampleData.constructor && (sampleData.constructor == Array||sampleData.constructor == Object)){
			$("#data").val(JSON.stringify(sampleData,true,1,true));
		}else{
			$("#data").val(sampleData);
		}
		
		$(o).html('<i class="icon-arrow-left"></i> 恢复数据');
		$(o).attr("ut","retrieve");
	}else{
		$(o).html('<i class="icon-uniE603"></i> 样品数据');
		$("#data").val(bak);;
		$(o).attr("ut","sample");
	}
}
function checksubmit(){
	if(!checkdatavalid()){
		alert("数据有格式错误,不能提交");
		return false;
	}
	return true;
}
//-->
</script>
<script type="text/javascript" src="<?php echo ENTRY_HOME;?>/static/js/privilege/json_beauty.js"></script>
<!--<script type="text/javascript" src="<?php echo ENTRY_HOME;?>/static/codeBrush/shCore.js"></script>-->
<!--<script type="text/javascript" src="<?php echo ENTRY_HOME;?>/static/codeBrush/shBrushJScript.js"></script>-->
<!--<link type="text/css" rel="stylesheet" href="<?php echo ENTRY_HOME;?>/static/codeBrush/shCoreDefault.css"/>-->
<table class="pure-table pure-table-bordered pure-table-striped table100">
<caption>
	结点路径:<?php echo navPath($path,$this);?>
	<a style="margin-left:25px;margin-right:25px;" href="<?php echo ENTRY_HOME;?>/priv/datakey?nodepath=<?php echo urlencode($path->getNodePath()."?");?>">
		<i class="icon-data"></i>数据列表
	</a>
	[ <?php echo $path->getDatakey()?> ]路径下数据:
	<?php echo nspath($path,$this);?>
	
</caption>
    <thead>
        <tr>
        	<th>数据源(<?php echo dataSrc::$typeArr[$data["type"]]?>#<?php echo $data["type"]?>)<!--  路径:<span style="margin-left:25px;"><?php echo $path->toString();?></span>--></th>
        </tr>
    </thead>

    <tbody>
        <tr>
        	<td align="center">
	        	<form onsubmit="return checksubmit()" action="<?php echo $submit_url;?>" method="post">
	        		<input type="hidden" name="path" value="<?php echo $path->toString()?>">
	        		<input type="hidden" name="dstype" value="<?php echo $data["type"]?>">
	        		<textarea id="data" name="data" rows="8" cols="88"><?php echo $data["type"]=="html"?$data["data"]:json_encode($data["data"]);?></textarea>
	        		<br>
	        		<button class="pure-button" type="submit">
				    	<i class="icon-uniE629"></i>
				    	<?php if(empty($data["data"])):?>添加<?php else:?>更新<?php endif;?>
					</button>
					
	        		<button type="button" class="pure-button" onclick="formatData()">
				    	<i class="icon-uniE643"></i>
				    	格式化
					</button>
					
	        		<button type="button" class="pure-button" onclick="compressData()">
				    	<i class="icon-uniE64F"></i>
				    	代码压缩
					</button>
					
	        		<button ut="sample" type="button" class="pure-button" onclick="showSampleData(this)">
				    	<i class="icon-uniE603"></i>
				    	样品数据
					</button>
					<p>
						小提示:代码压缩没有问题,表示数据没有格式问题
					</p>        	
	        	
	        	
	        	</form>

        	</td>
        </tr>
    </tbody>
</table>