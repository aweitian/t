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
                    <input type="hidden" name="titleType" class="input" value="text"/>
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
                <label class="lab">等级划分：</label>
                <div class="input-container">
                  	<input name="span" type="text" value="{span}" class="input"/>
                    <p>30,50,60</p>
                </div>
            </div>
            <div class="formitm">
                <label class="lab">自动划分：</label>
                <div class="input-container">
                  	<input name="spanNum" type="text" value="{spanNum}" class="input"/>
                    <p>如果上面没填，就使用这个数字比如总共60级，这个地方填3，那就变成20,40,60</p>
                </div>
            </div>
            <div class="formitm">
                <label class="lab">计算器数据：</label>
                <div class="input-container">
                  	<input name="showCalcData" {showCalcDatachecked} type="checkbox" class="input"/>
                    <p>选中为显示</p>
                </div>
            </div>
            <div class="formitm">
                <label class="lab">A-B数据：</label>
                <div class="input-container">
                  	<input name="showA2B" {showA2Bchecked} type="checkbox" class="input"/>
                    <p>选中为显示</p>
                </div>
            </div>
            <div class="formitm">
                <label class="lab">0-Z数据：</label>
                <div class="input-container">
                  	<input name="showZero2End" {showZero2Endchecked} type="checkbox" class="input"/>
                    <p>选中为显示</p>
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