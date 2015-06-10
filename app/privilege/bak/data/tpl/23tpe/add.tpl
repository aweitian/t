<script src="/sea/public/js/privilege/datasrc/23tpe.js"></script>
<script>
function showSampleData(){
	$(".input-textarea").val('[["wow gold 10g","require level 50+",20],["aion pl svr 1-50","require gold 10",50],["wow gears","",7.3],["test","",12]]');
}
</script>
<style>
a.helper{
	font-size:12px;
	margin-right:18px;
}
</style>
<div class="form">
    <form name="" action="{action}" method="post">
    <input type="hidden" value="{dsnsid}" name="dsnsid">
        <fieldset>
            <legend>添加数据:[标题,价格,额外信息]</legend>
            <div class="formitm">
                <label class="lab">路径：</label>
                <div class="input-container">
                	{deco}
                    <input type="hidden" name="path" class="input" value="{loc}"/>
                </div>
            </div>
            <div class="formitm">
                <label class="lab">数据：</label>
                <div class="input-container">
                    <textarea name="data" class="input-textarea"></textarea>
                    <br>
                    <a class="helper" href="javascript:void(0)" onclick="showSampleData()">样品数据</a>
                    <a class="helper" href="javascript:void(0)" onclick="">数据压缩</a>
                    <a class="helper" href="javascript:void(0)" onclick="">数据格式化</a>
                </div>
            </div>
            <div class="formitm formit1"><button class="btn" type="submit">添加</button></div>
        </fieldset>
    </form>
</div>