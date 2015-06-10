<!--
/**
 * Date: 2014-10-10
 * Author: Awei.tian
 * function: 
 */
-->
<div class="form">
    <form name="" action="{action}" method="post">
    <input type="hidden" value="{dsnsid}" name="dsnsid">
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
                  	 图片： <input name="titleType" {t_imgchecked} type="radio" value="img" class="input"/>
                  	 文字： <input name="titleType" {t_textchecked} type="radio" value="text" class="input"/>
                    <p>如果选择为图片，把数据源的TITLE列解释为图片路径</p>
                </div>
            </div>
            <div class="formitm">
                <label class="lab">额外模式：</label>
                <div class="input-container">
                  	 图标： <input name="extraShowMode" {e_iconchecked} type="radio" value="icon" class="input"/>
                  	 文字： <input name="extraShowMode" {e_textchecked} type="radio" value="text" class="input"/>
                    <p>额外列的解释方式</p>
                </div>
            </div>
            <div class="formitm">
                <label class="lab">图标点位符：</label>
                <div class="input-container">
                  	 模板： <input name="iconPlaceHolder" type="radio" value="{iconPlaceHolder}" class="input"/>
                    <p>模板中要包含:{placeholder}</p>
                </div>
            </div>
            <div class="formitm">
                <label class="lab">数据源列掩码：</label>
                <div class="input-container">
                  	 掩码： <select name="extraShowMask">
                  	 <option value="etp"{etpselected}>etp</option>
                  	 <option value="tep"{tepselected}>tep</option>
                  	 <option value="tpe"{tpeselected}>tpe</option>
                  	 </select>
                    <p>列的解释方式</p>
                </div>
            </div>
            <div class="formitm">
                <label class="lab">extraCaption：</label>
                <div class="input-container">
                  	 extraCaption： <input name="extraCaption" value="{extraCaption}" type="text" value="" class="input"/>
                    <p>extraCaption</p>
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