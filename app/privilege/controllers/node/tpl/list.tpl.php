<?php 
//"wretwer":{"nt":"folder","order":"0","type":0,"label":[0],"type_deco":"pl","label_deco":"gold"}
function subPath($p,$k){
	if($p=="/")return $p.$k;
	return $p."/".$k;
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
?><table class="pure-table pure-table-bordered pure-table-striped table100">
	<caption>
		当前路径:<?php echo navPath($path);?> 
	</caption>
    <thead>
	    <tr>
	    	<td colspan="5">
	    	
	    		<a href="<?php echo ENTRY_HOME;?>/priv/node/add?path=<?php echo urlencode($path);?>">
		    		<button class="pure-button">
				    	<i class="icon-plus"></i>
				    	添加
					</button></a>
				
				<a style="margin-left:25px;margin-right:25px;" href="<?php echo ENTRY_HOME;?>/priv/datakey?nodepath=<?php echo urlencode($path."?");?>">
					<i class="icon-data"></i> 查看数据
				</a>
				
				<a style="margin-left:25px;margin-right:25px;" href="<?php echo ENTRY_HOME;?>/priv/confkey?path=<?php echo urlencode($path."?");?>">
					<i class="icon-settings"></i> 查看配置
				</a>
				
				<span style="margin-left:25px"><?php echo $path;?></span>
			</td>
	    </tr>
        <tr>
        	<th>名字</th>
            <th>#Order</th>
            <th>类型</th>
            <th>标签</th>
            <th>操作</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($data as $key => $item):?>
        <tr>
        	<td><a href="<?php echo ENTRY_HOME;?>/priv/node<?php echo $item["nt"] == "file"?"leaf":"";?>?nodepath=<?php echo urlencode(subPath($path, $key));?>"><span class="icon-<?php echo $item["nt"];?>"></span> <?php echo $key;?></a></td>
            <td><?php echo $item["order"];?></td>
            <td><?php echo $item["type_deco"];?></td>
            <td><?php echo $item["label_deco"];?></td>
            <td><a href="<?php echo ENTRY_HOME;?>/priv/node/remove?path=<?php echo urlencode(subPath($path, $key));?>" onclick="return confirm('?')">删除</a> | <a href="<?php echo ENTRY_HOME;?>/priv/node/edit?path=<?php echo urlencode(subPath($path, $key));?>">编辑</a></td>
        </tr>
	<?php endforeach;?>
    </tbody>
</table>