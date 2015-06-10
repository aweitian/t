<?php
/**
 * @author:awei.tian
 * @date: 2014-11-15
 * @functions:
 */
//type label为数据库中的原始值
//var_dump($defaultValue);exit;
require_once ENTRY_PATH.'/app/data/conf/base/conf.php';
require_once ENTRY_PATH.'/app/data/datasrc/DataSrcPath.php';
extract($data);
$datasrcpath = new DataSrcPath($path);
function subPath($p,$k){
	return $p."".$k;
}
function navPath($path){
	$cur = "";
	$html = "<a href='".ENTRY_HOME."/priv/node?nodepath=".urlencode("/")."'>///</a>";
	if($path == "/"){
		return $html;
	}
	$data = explode("/", trim($path,"/"));
	foreach ($data as $v){
		$cur = $cur."/".$v;
		$html .= " > <a href='".ENTRY_HOME."/priv/node?nodepath=".urlencode($cur)."'>". $v . "</a>";
	}
	return $html;
}
$bakconf=conf_table_23ldp::getDefaultConf(); 
$bakconf["span"] = join(",",$bakconf["span"]);
// var_dump($conf);exit;
?>
<div class="pure-g">
    <div class="pure-u-1-5"></div>
    <div class="pure-u-3-5">
    <br>
    	当前路径:<?php echo navPath($datasrcpath->getNodePath());?>
	<a style="margin-left:25px;margin-right:25px;" href="<?php echo ENTRY_HOME;?>/priv/confkey?path=<?php echo urlencode($datasrcpath->getNodePath()."?");?>">
		<i class="icon-uniE641"></i>配置列表
	</a>
	<a style="margin-left:25px;" href="<?php echo ENTRY_HOME;?>/priv/conf?path=<?php echo urlencode($path);?>">
		<i class="icon-uniE640"></i><?php echo $datasrcpath->getDatakey()?>
	</a>
		 <h3 style=""><?php echo conf::$typeArr[$type];?> 数据：( <?php if(empty($conf)):?>默认值  *<?php else:?>已添加<?php endif;?> )</h3>
		配置源路径:<span style="margin-left:25px;"><?php print $path?></span><hr>
		<form class="pure-form pure-form-aligned node-form" method="<?php if($mode =="show"):?>GET<?php else:?>POST<?php endif;?>" action="<?php echo $submit_path;?>">
		<input type="hidden" name="path" value="<?php echo $path;?>">
		<input type="hidden" name="typeid" value="table_23ldp">
		    <fieldset>
		    	<div class="pure-control-group">
		           <label>多表格显示方式:</label>
		           <?php $mutistyleKv = array("auto"=>"自动","expand"=>"折叠","collapse"=>"展开")?>
		           <?php if ($mode=="show"):?>
		           <?php echo $mutistyleKv[empty($conf)?$bakconf["mutistyle"]:$conf["mutistyle"]];?>
		           <?php else:?>
		     	 		<select name="mutistyle">
		     	 		<option value="auto"<?php echo (empty($conf)?$bakconf["mutistyle"]:$conf["mutistyle"]) == "auto"?" selected":""?>><?php print $mutistyleKv["auto"]?></option>
		     	 		<option value="expand"<?php echo (empty($conf)?$bakconf["mutistyle"]:$conf["mutistyle"]) == "expand"?" selected":""?>><?php print $mutistyleKv["expand"]?></option>
		     	 		<option value="collapse"<?php echo (empty($conf)?$bakconf["mutistyle"]:$conf["mutistyle"]) == "collapse"?" selected":""?>><?php print $mutistyleKv["collapse"]?></option>
		     	 		</select>
		           <?php endif;?>
		        </div>
		    	<div class="pure-control-group">
		           <label>表格标题:</label>
		           <?php if ($mode=="show"):?>
		           <?php echo empty($conf)?$bakconf["tableCaption"]:$conf["tableCaption"];?>
		           <?php else:?>
		     	 		<input value="<?php echo empty($conf)?$bakconf["tableCaption"]:$conf["tableCaption"];?>" type="text" placeholder='例如:Mats sales' name="tableCaption">
		     		<?php endif;?>
		        </div>
		        <div class="pure-control-group">
		           <label>内容显示方式:</label>
		           <?php if ($mode=="show"):?>
		           <?php echo (empty($conf)?$bakconf["showType"]:$conf["showType"]) == "grid" ? "网格":"表格";?>
		           <?php else:?>
		     	 		<select name="showType">
		     	 		<option value="grid"<?php echo (empty($conf)?$bakconf["showType"]:$conf["showType"]) == "grid"?" selected":""?>>网格</option>
		     	 		<option value="table"<?php echo (empty($conf)?$bakconf["showType"]:$conf["showType"]) == "table"?" selected":""?>>表格</option>
		     	 		</select>
		           <?php endif;?>
		        </div>
		        <div class="pure-control-group">
		           <label>网格列数:</label>
		           <?php if ($mode=="show"):?>
		           <?php echo empty($conf)?$bakconf["gridCol"]:$conf["gridCol"];?>
		           <?php else:?>
		     	 		<input value="<?php echo empty($conf)?$bakconf["gridCol"]:$conf["gridCol"];?>" type="text" placeholder='例如:3' name="gridCol">
		     		<?php endif;?>
		        </div>	
		    	<div class="pure-control-group">
		           <label>自定义级别分段:</label>
		           <?php if ($mode=="show"):?>
		           		<?php echo 
		     	 			empty($conf) ?
		     	 			$bakconf["span"]
		     	 			:
		     	 			(
		     	 				is_array($conf["span"]) 
		     	 				? join(",",$conf["span"]) 
		     	 				: $conf["span"]
		     	 			) ;?>
		           <?php else:?>
		     	 		<input value="<?php echo 
		     	 			empty($conf) ?
		     	 			$bakconf["span"]
		     	 			:
		     	 			(
		     	 				is_array($conf["span"]) 
		     	 				? join(",",$conf["span"]) 
		     	 				: $conf["span"]
		     	 			) ;?>" type="text" placeholder='例如:20,35,60' name="span">
		     		
		           <?php endif;?>
		        </div>
		    	<div class="pure-control-group">
		           <label>级别分段 <a href="#"><i class="icon-uniE686"></i></a>:</label>
		           <?php if ($mode=="show"):?>
		           <?php echo (empty($conf)?$bakconf["spanNum"]:$conf["spanNum"]);?>
		           <?php else:?>
		     	 		<input value="<?php echo empty($conf)?$bakconf["spanNum"]:$conf["spanNum"];?>" type="text" placeholder='例如:3' name="spanNum">
		           <?php endif;?>
		        </div>
		        <div class="pure-control-group">
		           <label>标题类型:</label>
		           <?php if ($mode=="show"):?>
		           <?php echo empty($conf)?$bakconf["titleType"]:$conf["titleType"];?>
		           <?php else:?>
		          	 <select name="titleType">
		     	 		<option value="text"<?php echo (empty($conf)?$bakconf["titleType"]:$conf["titleType"]) == "text"?" selected":""?>>文字</option>
		     	 		</select>
		     		<?php endif;?>
		        </div>
		        
		        <div class="pure-control-group">
		           <label>显示0-20,20-33,...:</label>
		           <?php if ($mode=="show"):?>
		           <?php echo (empty($conf)?$bakconf["showCalcData"]:$conf["showCalcData"]) == "1" ? "是":"否";?>
		           <?php else:?>
		     	 		<input value="1" name="showCalcData"<?php echo (empty($conf)?$bakconf["showCalcData"]:$conf["showCalcData"]) == "1" ? " checked":"";?> type="radio">是
		     	 		<input value="0" name="showCalcData"<?php echo (empty($conf)?$bakconf["showCalcData"]:$conf["showCalcData"]) == "1" ? "":" checked";?> type="radio">否
		     		<?php endif;?>
		        </div>
		        <div class="pure-control-group">
		           <label>显示0-A,0-B,...:</label>
		           <?php if ($mode=="show"):?>
		           <?php echo (empty($conf)?$bakconf["showZero2End"]:$conf["showZero2End"]) == "1" ? "是":"否";?>
		           <?php else:?>
		     	 		<input value="1" name="showZero2End"<?php echo (empty($conf)?$bakconf["showZero2End"]:$conf["showZero2End"]) == "1" ? " checked":"";?> type="radio">是
		     	 		<input value="0" name="showZero2End"<?php echo (empty($conf)?$bakconf["showZero2End"]:$conf["showZero2End"]) == "1" ? "":" checked";?> type="radio">否
		     		<?php endif;?>
		        </div>
		         <div class="pure-control-group">
		           <label>显示0-20-20-30,...:</label>
		           <?php if ($mode=="show"):?>
		           <?php echo (empty($conf)?$bakconf["showA2B"]:$conf["showA2B"]) == "1" ? "是":"否";?>
		           <?php else:?>
		     	 		<input value="1" name="showA2B"<?php echo (empty($conf)?$bakconf["showA2B"]:$conf["showA2B"]) == "1" ? " checked":"";?> type="radio">是
		     	 		<input value="0" name="showA2B"<?php echo (empty($conf)?$bakconf["showA2B"]:$conf["showA2B"]) == "1" ? "":" checked";?> type="radio">否
		     		<?php endif;?>
		        </div>
		        <div class="pure-control-group">
		           <label>备注:</label>
		           <?php if ($mode=="show"):?>
		           <?php echo empty($conf)?"default comment":$conf["comment"];?>
		           <?php else:?>
		     	 		<input value="<?php echo empty($conf)?"":$conf["comment"];?>" type="text" placeholder='comment' name="comment">
		     		<?php endif;?>
		        </div>
		        <div class="pure-controls">
		            <button type="submit" class="pure-button pure-button-primary">
		            <?php if(empty($conf)):?>添加<?php else:?>更新<?php endif;?>
		            </button>
		        </div>
		    </fieldset>
		</form>    
    
    </div>
    <div class="pure-u-1-5"></div>
</div>
