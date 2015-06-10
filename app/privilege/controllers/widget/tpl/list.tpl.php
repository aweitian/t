<?php 
//"wretwer":{"nt":"folder","order":"0","type":0,"label":[0],"type_deco":"pl","label_deco":"gold"}
require_once ENTRY_PATH."/app/data/datasrc/dataSrc.php";
function subPath($p,$k){
	return $p."".$k;
}
function navPath($path){
	$cur = "";
	$html = "<a href='".ENTRY_HOME."/priv/node?nodepath=".urlencode("/")."'>///</a>";
	if($path == "/?"){
		return $html;
	}
	$path = rtrim($path,"?");
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
	<a style="margin-left:25px;margin-right:25px;" href="<?php echo ENTRY_HOME;?>/priv/datakey?nodepath=<?php echo urlencode($path);?>">
		<i class="icon-data"></i>数据列表
	</a>
</caption>
    <thead>
	    <tr>
	    	<td colspan="5">
	    	
	    		<a href="<?php echo ENTRY_HOME;?>/priv/datakey/add?path=<?php echo urlencode($path);?>">
		    		<button class="pure-button">
				    	<i class="icon-plus"></i>
				    	添加
					</button></a>
				
				<!--<a href="<?php echo ENTRY_HOME;?>/priv/node?nodepath=<?php echo urlencode(rtrim($path,"?"));?>">
					<button class="pure-button">
				    	<i class="icon-folder"></i>
				    	返回到结点
					</button></a>-->
			</td>
	    </tr>
        <tr>
        	<th>名字</th>
            <th>数据类型</th>
            <th>路径装饰</th>
            <th>备注</th>
            <th>操作</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($data as $key => $item):?>
        <tr>
        	<td><a href="<?php echo ENTRY_HOME;?>/priv/namespace/?path=<?php echo urlencode(subPath($path, $key)."/");?>"><span class="icon-database"></span> <?php echo $key;?></a></td>
            <td><?php echo dataSrc::$typeArr[$item["dstype"]];?>:(<?php echo $item["dstype"];?>)</td>
            <td><?php echo $item["deco"];?></td>
            <td><?php echo $item["comment"];?></td>
            <td><a href="<?php echo ENTRY_HOME;?>/priv/datakey/remove?path=<?php echo urlencode(subPath($path, $key));?>" onclick="return confirm('?')">删除</a> | <a href="<?php echo ENTRY_HOME;?>/priv/datakey/edit?path=<?php echo urlencode(subPath($path, $key));?>">编辑</a> | <a href="<?php echo ENTRY_HOME;?>/priv/datakey/editdstype?path=<?php echo urlencode(subPath($path, $key));?>">修改数据类型</a></td>
        </tr>
	<?php endforeach;?>
    </tbody>
</table>