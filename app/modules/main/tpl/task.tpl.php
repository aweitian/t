<?php
/**
 * Date: 2016年1月9日
 * Author: Awei.tian
 * Description: 
 */
$data = explode("\n", $data);
function formSubmitAction(){
	if(App::isPost()){
		return HTTP_ENTRY."/dl";
	}
	return HTTP_ENTRY."/";
}
function formSubmitMethod(){
	if(App::isPost()){
		return "get";
	}
	return "post";
}
function formSubmitBtnText(){
	if(App::isPost()){
		return "下载查询结果";
	}
	return "开始任务";
}
?>
<script type="text/javascript">
<!--
function updst(url,st){
	var ch = [
		"glyphicon glyphicon-ok-sign text-success",
		"glyphicon glyphicon-info-sign text-danger",
		"glyphicon glyphicon-minus-sign text-warning",
		"glyphicon glyphicon-remove-sign text-warning",
		"glyphicon glyphicon-question-sign text-muted"
	],th = [
		"没有发现负面信息",
		"存在负面信息",
		"抓取内容时出错",
		"无效的网址",
		"还未初始化"
	];
	$("form input[type=checkbox]").each(function(i,e){
		if(e.value == url){
			$(e).parent().next().find("span").attr("class",ch[st]).attr("title",th[st]);
		}

	})
}
//-->
</script>
<div class="container">
<div class="row">
<div class="col-md-12">
<form id="taskform" method="<?php print formSubmitMethod()?>" action="<?php print formSubmitAction()?>">
<input type="submit" value="<?php print formSubmitBtnText()?>" class="btn btn-default">
<?php if (!App::isPost()):?>
<a style="margin-left: 32px;font-size:12px;" href="<?php print HTTP_ENTRY?>/dl">下载最后一次查询结果</a>
<?php endif;?>
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
	<td><input<?php if(!Validator::isUrl($item)):?> disabled<?php else:?> checked<?php endif;?> type="checkbox" value="<?php print trim($item)?>" name="urls[]"></td>
	<td><span class="glyphicon glyphicon-question-sign text-muted"></span></td>
	<td><?php if(!Validator::isUrl($item)):?><?php print trim($item)?><?php else:?><a href="<?php print trim($item)?>" target="_blank"><?php print trim($item)?></a><?php endif;?></td>	
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
//  	var data = {};var m = this;
//  	$("input[type=checkbox]").each(function(){
//  		if(this.checked && this.getAttribute("value")){
//  			data[this.value] = m["url"+this.value]["value"];
//  		}
//  	});
//$.post("<?php print HTTP_ENTRY?>/api",{url:data},function(result){
//  		alert(result);
//  	});
<?php if(App::isPost()):?>
return true;
<?php else:?>
	return confirm("本次提交会清空上次查询结果，你确定要提交吗？");
<?php endif;?>
});

</script>