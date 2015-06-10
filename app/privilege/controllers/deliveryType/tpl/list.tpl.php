<?php 
//"wretwer":{"nt":"folder","order":"0","type":0,"label":[0],"type_deco":"pl","label_deco":"gold"}
require_once ENTRY_PATH."/app/data/datasrc/dataSrc.php";
require_once ENTRY_PATH."/lib/tian/formUI/fieldsManifest.php";

//var_dump($data);exit;
?>
<script>
function deletedt(){
	if(!$("#dtval").val())return false;
	if(!confirm("sure?"))return false;

	window.location = "<?php echo ENTRY_HOME?>/priv/deliveryType/remove?name="+$("#dtval").val();
	return true;
}

</script>

<table class="pure-table pure-table-bordered pure-table-striped table100">
<caption>
	发货地址类型列表
</caption>
    <thead>
	    <tr>
	    	<td colspan="7">
	    		<a href="<?php echo ENTRY_HOME;?>/priv/deliveryType/add">
		    		<button class="pure-button">
				    	<i class="icon-plus"></i>
				    	添加
					</button></a>
					
					
				<input id="dtval" class="tbhd-input" placeholder="输入类型名称">
				<button class="pure-button" onclick="return deletedt()">
					<i class="icon-uniE64C"></i>
					删除
				</button>
			</td>
	    </tr>
        <tr>
            <th>类型名称</th>
            <th>字段名</th>
            <th>是否可用</th>
            <th>顺序</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($data as $item):?>
        <tr>
        	<td><?php echo $item["name"];?></td>
            <td><?php echo $item["ofname"];?></td>
            <td><?php echo $item["enable"]=="on"?"是":"否";?></td>
            <td><?php echo $item["order"];?></td>
        </tr>
	<?php endforeach;?>
    </tbody>
</table>