<?php 


?><table class="pure-table pure-table-bordered pure-table-striped table100">
	<caption>
		节点类型管理
	</caption>
    <thead>
	    <tr>
	    	<td colspan="5">
	    	
	    		<a href="<?php echo ENTRY_HOME;?>/priv/nodetype/add">
		    		<button class="pure-button">
				    	<i class="icon-plus"></i>
				    	添加
					</button></a>
			</td>
	    </tr>
        <tr>
            <th>类型</th>
            <th>操作</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($data as $key => $item):?>
        <tr>
            <td><?php echo $item;?></td>
            <td><a href="<?php echo ENTRY_HOME;?>/priv/nodetype/remove?tk=<?php echo $key;?>" onclick="return confirm('?')">删除</a> | <a href="<?php echo ENTRY_HOME;?>/priv/nodetype/edit?tk=<?php echo $key;?>">编辑</a></td>
        </tr>
	<?php endforeach;?>
    </tbody>
</table>