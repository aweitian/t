<?php 
//"wretwer":{"nt":"folder","order":"0","type":0,"label":[0],"type_deco":"pl","label_deco":"gold"}
require_once ENTRY_PATH."/app/data/datasrc/dataSrc.php";
require_once ENTRY_PATH."/lib/tian/formUI/fieldsManifest.php";

//var_dump($data);exit;
?><table class="pure-table pure-table-bordered pure-table-striped table100">
<caption>
	发货地址字段列表
</caption>
    <thead>
	    <tr>
	    	<td colspan="7">
	    		<a href="<?php echo ENTRY_HOME;?>/priv/delivery/add">
		    		<button class="pure-button">
				    	<i class="icon-plus"></i>
				    	添加
					</button></a>
			</td>
	    </tr>
        <tr>
        	<th>键值</th>
            <th>名称</th>
            <th>字段类型</th>
            <th>长度</th>
            <th>是否允许为空</th>
            <th>备注</th>
            <th>操作</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($data as $key => $item):?>
        <tr>
        	<td><?php echo $item["key"];?></td>
            <td><?php echo $item["val"];?></td>
            <td><?php echo fieldsManifest::$typeArr[$item["typ"]];?></td>
            <td><?php echo $item["len"];?></td>
            <td><?php echo $item["ept"];?></td>
            <td><?php echo $item["comment"];?></td>
            <td><a href="<?php echo ENTRY_HOME;?>/priv/delivery/remove?key=<?php echo $item["key"];?>" onclick="return confirm('?')">删除</a><!-- | <a href="<?php echo ENTRY_HOME;?>/priv/delivery/edit?key=<?php echo $item["key"];?>">编辑</a>--></td>
        </tr>
	<?php endforeach;?>
    </tbody>
</table>