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
$bakconf=conf_table_23tpe::getDefaultConf(); 
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
		<input type="hidden" name="typeid" value="table_23tpe">
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
		           <label>标题类型:</label>
		           <?php if ($mode=="show"):?>
		           <?php echo (empty($conf)?$bakconf["titleType"]:$conf["titleType"]) == "text" ? "文字" : "图片";?>
		           <?php else:?>
		          	 <select name="titleType">
		     	 		<option value="text"<?php echo (empty($conf)?$bakconf["titleType"]:$conf["titleType"]) == "text"?" selected":""?>>文字</option>
		     	 		</select>
		     		<?php endif;?>
		        </div>
		        <div class="pure-control-group">
		           <label>额外列类型:</label>
		           <?php if ($mode=="show"):?>
		           <?php echo (empty($conf)?$bakconf["extraShowMode"]:$conf["extraShowMode"]) == "text" ? "文字" : "图标";?>
		           <?php else:?>
		          	 <select name="extraShowMode">
		     	 		<option value="text"<?php echo (empty($conf)?$bakconf["extraShowMode"]:$conf["extraShowMode"]) == "text"?" selected":""?>>文字</option>
		     	 		<option value="icon"<?php echo (empty($conf)?$bakconf["extraShowMode"]:$conf["extraShowMode"]) == "icon"?" selected":""?>>图标</option>
		     	 		</select>
		     		<?php endif;?>
		        </div>
		        <div class="pure-control-group">
		           <label>图标列模板:</label>
		           <?php if ($mode=="show"):?>
		           <?php echo htmlspecialchars(empty($conf)?$bakconf["iconPlaceHolder"]:$conf["iconPlaceHolder"]);?>
		           <?php else:?>
		          	 <textarea name="iconPlaceHolder"><?php echo empty($conf)?$bakconf["iconPlaceHolder"]:$conf["iconPlaceHolder"]?></textarea>
		     		<?php endif;?>
		        </div>
		        <div class="pure-control-group">
		           <label>额外列摆放顺序:</label>
		           <?php if ($mode=="show"):?>
		           <?php echo (empty($conf)?$bakconf["extraShowMask"]:$conf["extraShowMask"]);?>
		           <?php else:?>
		          	 <select name="extraShowMask">
		     	 		<option value="etp"<?php echo (empty($conf)?$bakconf["extraShowMask"]:$conf["extraShowMask"]) == "etp"?" selected":""?>>etp</option>
		     	 		<option value="tep"<?php echo (empty($conf)?$bakconf["extraShowMask"]:$conf["extraShowMask"]) == "tep"?" selected":""?>>tep</option>
		     	 		<option value="tpe"<?php echo (empty($conf)?$bakconf["extraShowMask"]:$conf["extraShowMask"]) == "tpe"?" selected":""?>>tpe</option>
		     	 		</select>
		     		<?php endif;?>
		        </div>	
		        <div class="pure-control-group">
		           <label>额外列标题:</label>
		           <?php if ($mode=="show"):?>
		           <?php echo empty($conf)?$bakconf["extraCaption"]:$conf["extraCaption"];?>
		           <?php else:?>
		     	 		<input value="<?php echo empty($conf)?$bakconf["extraCaption"]:$conf["extraCaption"];?>" type="text" placeholder='例如:Mats sales' name="extraCaption">
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
