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
    <input type="hidden" value="22ap" name="dstypeid">
        <fieldset>
            <legend>配置</legend>
            <div class="formitm">
                <label class="lab">路径：</label>
                <div class="input-container">
                	{deco}
                    <input type="hidden" name="path" class="input" value="{loc}"/>
                    <input type="hidden" name="titleType" class="input" value="text"/>
                </div>
            </div>
            <div class="formitm">
                <label class="lab">表格标题：</label>
                <div class="input-container">
                    <input name="tableCaption" type="text" class="input" value="{tableCaption}"/>
                    <p>20个字符以内</p>
                </div>
            </div>
            <div class="formitm">
                <label class="lab">显示类型：</label>
                <div class="input-container">
                  		 网格: <input {gridchecked} name="showType" value="grid" type="radio" class="input"/>
                  		 表格: <input {tablechecked} name="showType" value="table" type="radio" class="input"/>
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
</div>