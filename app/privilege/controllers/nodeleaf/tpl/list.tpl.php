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
//	$leaf = array_pop($data);
	foreach ($data as $v){
		$cur = $cur."/".$v;
		$html .= " > <a href='".ENTRY_HOME."/priv/node?nodepath=".urlencode($cur)."'>". $v . "</a>";
	}
//	$cur = $cur."/".$leaf;
//	$html .= " > <a href='".ENTRY_HOME."/priv/nodeleaf?nodepath=".urlencode($cur)."'>". $leaf . "</a>";
	return $html;
}
?><table class="pure-table pure-table-bordered pure-table-striped table100">
	<caption>
		当前路径:<?php echo navPath($path);?> 
	</caption>
    <thead>
	    <tr>
	    	<td colspan="6">
	    		<a href="<?php echo ENTRY_HOME;?>/priv/widget/add?path=<?php echo urlencode($path);?>">
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
				
				
				<span style="margin-left:25px"><a href="<?php print ENTRY_HOME?>/<?php print SVC_NAME?><?php echo $path;?>">查看前台效果</a> <?php echo $path;?></span>
			</td>
	    </tr>
        <tr>
        	<th>注释</th>
        	<th>组件类型</th>
            <th>数据源</th>
            <th>配置源</th>
            <th>顺序</th>
            <th>操作</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($data as $key => $item):?>
        <tr>
        	<td><?php echo $item["comment"];?></td>
        	<td><?php echo $item["typeid"];?></td>
            <td>
            	<a href="<?php echo ENTRY_HOME;?>/priv/namespace?path=<?php echo urlencode($item["datasrcpath"]."/");?>">
            		<?php echo $item["datasrcpath"];?>
            	</a>
            	
            </td>
            <td>
            	<a href="<?php echo ENTRY_HOME;?>/priv/conf?path=<?php echo urlencode($item["confpath"]."");?>">
            		<?php echo $item["confpath"];?>
            	</a>
            </td>
            <td><?php echo $item["order"];?></td>
            <td>
            	<a href="<?php echo ENTRY_HOME;?>/priv/widget/remove?order=<?php echo $item["order"]?>&path=<?php echo urlencode($path);?>" onclick="return confirm('?')">
            		删除
            	</a>
            	 | 
            	<a href="<?php echo ENTRY_HOME;?>/priv/widget/edit?order=<?php echo $item["order"]?>&path=<?php echo urlencode($path);?>">
            		编辑
            	</a>
            </td>
        </tr>
	<?php endforeach;?>
    </tbody>
</table>