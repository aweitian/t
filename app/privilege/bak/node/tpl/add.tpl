<h2>当前路径:{nav}</h2>
<div class="form">
    <form name="" action="{action}" method="post">
    <input type="hidden" value="{nodepath}" name="nodepath">
        <fieldset>
            <legend>Add a node</legend>
            <div class="formitm">
                <label class="lab">结点路径：</label>
                <div class="input-container">
                    <input name="key" type="text" class="input"/>
                    <p>包括字母，数字,字母要小写</p>
                </div>
            </div>
            <div class="formitm">
                <label class="lab">结点名称：</label>
                <div class="input-container">
                    <input name="name" type="text" class="input"/>
                    <p>25个字符以内</p>
                </div>
            </div>
            <div class="formitm formit1"><button class="btn" type="submit">添加</button></div>
        </fieldset>
    </form>
</div>