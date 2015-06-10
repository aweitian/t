<?php 
//"wretwer":{"nt":"folder","order":"0","type":0,"label":[0],"type_deco":"pl","label_deco":"gold"}

function subPath($p,$k){
	if(substr($p,-1)=="/")return $p.$k;
	return $p."/".$k;
}
function navPath(DataSrcPath $path,namespaceView $view){
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
function nspath(DataSrcPath $path,namespaceView $view){
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
?><table class="pure-table pure-table-bordered pure-table-striped table100">
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
	    	<td colspan="5">
	    	
	    		<a href="<?php echo ENTRY_HOME;?>/priv/namespace/add?path=<?php echo urlencode($path->toString());?>">
		    		<button class="pure-button">
				    	
				    	<i class="icon-plus"></i>
				    	添加
					</button></a>

			</td>
	    </tr>
        <tr>
        	<th>名字</th>
            <th>#Order</th>
            <th>操作</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($data as $item):?>
        <tr>
        	<td><a <?php if($item["nt"] == "file"):?>href="<?php echo ENTRY_HOME;?>/priv/datasrc/?path=<?php echo urlencode(subPath($path->toString(), $item["key"]));?>"<?php else:?>href="<?php echo ENTRY_HOME;?>/priv/namespace/?path=<?php echo urlencode(subPath($path->toString(), $item["key"]));?>"<?php endif;?>><span class="<?php if($item["nt"] == "file"):?>icon-description<?php else:?>icon-archive<?php endif;?>"></span> <?php echo $item["key"];?></a></td>
            <td><?php echo $item["order"];?></td>
            <td><a href="<?php echo ENTRY_HOME;?>/priv/namespace/remove?path=<?php echo urlencode(subPath($path->toString(), $item["key"]));?>" onclick="return confirm('?')">删除</a> | <a href="<?php echo ENTRY_HOME;?>/priv/namespace/edit?path=<?php echo urlencode(subPath($path->toString(), $item["key"]));?>">编辑</a></td>
        </tr>
	<?php endforeach;?>
    </tbody>
</table>