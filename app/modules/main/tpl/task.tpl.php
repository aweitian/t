<?php
/**
 * Date: 2016年1月9日
 * Author: Awei.tian
 * Description: 
 */
$data = explode("\n", $data);

?>
<div class="container">
<div class="row">
<div class="col-md-12">
<form id="taskform">
<input type="submit" value="开始任务" class="btn btn-default">
<table class="table table-striped table-condensed">
<thead>
<tr>
	<th><input type="checkbox" checked id="reversechk" title="反选"></th>
	<th>状态</th>
	<th>地址</th>
</tr>
</thead>
<tbody>
<!-- glyphicon glyphicon-ok-sign text-success -->
<!-- glyphicon glyphicon glyphicon-info-sign text-danger -->
<?php foreach ($data as $key=>$item):?>
<tr>
	<td><input<?php if(!Validator::isUrl($item)):?> disabled<?php else:?> checked<?php endif;?> type="checkbox" value="<?php print $key?>"><input type="hidden" name="url<?php print $key?>" value="<?php print trim($item)?>"></td>
	<td><span class="glyphicon glyphicon-question-sign text-muted"></span></td>
	<td><?php print trim($item)?></td>	
</tr>
<?php endforeach;?>
</tbody>

</table>

</form>

	


</div><!-- col-md-12 -->
</div><!-- row -->
</div><!-- container -->


<script>
$("#reversechk").click(function(){
	var m = this;
	$("input[type=checkbox]").each(function(){
		if(m == this)return;
		this.checked = this.disabled?false : !this.checked;
	});
});


$("#taskform").submit(function(){
	var data = {};var m = this;
	$("input[type=checkbox]").each(function(){
		if(this.checked && this.getAttribute("value")){
			data[this.value] = m["url"+this.value]["value"];
		}
	});
	$.post("<?php print HTTP_ENTRY?>/api",{url:data},function(result){
		alert(result);
	});
	return false;
});

</script>