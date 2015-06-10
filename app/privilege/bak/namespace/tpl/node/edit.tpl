<div class="form">
    <form name="" action="{action}" method="post">
    <input type="hidden" value="{nssid}" name="nssid">
        <fieldset>
            <legend>Add a namespace node</legend>
            <div class="formitm">
                <label class="lab">命名空间名：</label>
                <div class="input-container">
                    <input name="key" type="text" class="input" value='{key}' readonly/><a href="javascript:;" onclick="javascript:void((function(x){x.previousSibling.readOnly=false;return 0;})(this));">修改</a>
                    <p>必填:包括字母，数字,字母要小写(修改它可以导致以前使用的路径失效)</p>
                </div>
            </div>
            <div class="formitm">
                <label class="lab">命名装饰：</label>
                <div class="input-container">
                    <input name="deco" type="text" class="input" value='{deco}'/>
                    <p>1. 512个字符以内</p>
                    <p>2. 常见于分类组合框的左边一排文字</p>
                    <p>3. 格式为:/aaaa/bbbb,/aaa/cc/bb</p>
                    <p>4. 匹配的时候查找路径长度大于等于自己的</p>
                </div>
            </div>
            <div class="formitm">
                <label class="lab">注释：</label>
                <div class="input-container">
                    <input name="comment" type="text" class="input" value='{comment}'/>
                    <p>25个字符以内</p>
                </div>
            </div>
            <div class="formitm formit1"><button class="btn" type="submit">更新</button></div>
        </fieldset>
    </form>
</div>