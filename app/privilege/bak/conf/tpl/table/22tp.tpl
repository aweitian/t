<!--
/**
 * Date: 2014-10-10
 * Author: Awei.tian
 * function: 
 */
-->
<div class="form">
    <form name="" action="{action}" method="post">
    <input type="hidden" value="{widgetsid}" name="widgetsid">
    <input type="hidden" value="table" name="wdgtypeid">
    <input type="hidden" value="22tp" name="dstypeid">
        <fieldset>
            <legend>配置</legend>
            <div class="formitm">
                <label class="lab">路径：</label>
                <div class="input-container">
                	{deco}
                    <input type="hidden" name="path" class="input" value="{loc}"/>
                </div>
            </div>
            <div class="formitm">
                <label class="lab">表格标题：</label>
                <div class="input-container">
                    <input name="tableCaption" value="{tableCaption}" type="text" class="input"/>
                    <p>20个字符以内</p>
                </div>
            </div>
            <div class="formitm">
                <label class="lab">标题类型：</label>
                <div class="input-container">
                  		图片: <input {imgchecked} name="titleType" value="img" type="radio" class="input"/>
                  		 文字: <input {textchecked} name="titleType" value="text" type="radio" class="input"/>
                </div>
            </div>
            <div class="formitm">
                <label class="lab">注释：</label>
                <div class="input-container">
                    <textarea name="comment" class="input">{comment}</textarea>
                </div>
            </div>
            <div class="formitm formit1"><button class="btn" type="submit">设置</button></div>
        </fieldset>
    </form>
</div>`