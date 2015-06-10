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
$bakconf=conf_table_22tp::getDefaultConf(); 
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
		<input type="hidden" name="typeid" value="table_22tp">
		    <fieldset>
		    	<div class="pure-control-group">
		           <label>表格标题:</label>
		           <?php if ($mode=="show"):?>
		           <?php echo empty($conf)?$bakconf["tableCaption"]:$conf["tableCaption"];?>
		           <?php else:?>
		     	 		<input value="<?php echo empty($conf)?$bakconf["tableCaption"]:$conf["tableCaption"];?>" type="text" placeholder='例如:Mats sales' name="tableCaption">
		     		<?php endif;?>
		        </div>
		        <div class="pure-control-group">
		           <label>标题类型:</label>
		           <?php if ($mode=="show"):?>
		           <?php echo (empty($conf)?$bakconf["titleType"]:$conf["titleType"]) == "text" ? "文字" : "图片";?>
		           <?php else:?>
		          	 <select name="titleType">
		     	 		<option value="text"<?php echo (empty($conf)?$bakconf["titleType"]:$conf["titleType"]) == "text"?" selected":""?>>文字</option>
		     	 		<option value="img"<?php echo (empty($conf)?$bakconf["titleType"]:$conf["titleType"]) == "img"?" selected":""?>>图片</option>
		     	 		</select>
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
