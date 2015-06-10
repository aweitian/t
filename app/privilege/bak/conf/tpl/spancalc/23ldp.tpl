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
    <input type="hidden" value="spancalc" name="wdgtypeid">
    <input type="hidden" value="23ldp" name="dstypeid">
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
                <label class="lab">JS本地化：</label>
                <div class="input-container">
                    <input {checked} name="jscache" type="text" class="checkbox"/>
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