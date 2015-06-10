<?php
/**
 * Date: 2015-1-26
 * Author: Awei.tian
 * function: 
 */

// var_dump($data);exit;

?>

<form class="pure-form pure-form-stacked" action="<?php print ENTRY_HOME?>/priv/news/<?php if($mode == "edit"):?>update<?php else:?>append<?php endif;?>" method="post">
    <fieldset>
        <legend>新闻<?php if($mode == "edit"):?>编辑#<?php print $data["sid"]?><?php else:?>添加<?php endif;?></legend>
		<?php if($mode == "edit"):?>
		<input name="sid" type="hidden" value="<?php print $data["sid"]?>">
		<?php endif;?>
        <label>标题</label>
        <div>
        	<input name="title" type="text" value="<?php print $data["title"]?>">
        </div>
		<label>内容</label>
        <div>
        	<textarea rows="8" cols="50" name="content"><?php print $data["content"]?></textarea>
        </div>
        <!-- -->
        <label>是否为图片新闻</label>
        <div>
        	<input name="sldflg" type="radio" value="1"<?php if($data["sldflg"] == 1)print " checked"?>>是
        	<input name="sldflg" type="radio" value="0"<?php if($data["sldflg"] == 0)print " checked"?>>否
        </div>        
         

        <label>图片名</label>
        <div>
        	<input name="sldimg" type="text" value="<?php print $data["sldimg"]?>">
        </div>
        <label>图片链接</label>
        <div>
        	<input name="lnk" type="text" value="<?php print $data["lnk"]?>">
        </div>
		<label>图片顺序</label>
        <input name="sldorder" type="text" value="<?php print $data["sldorder"]?>">
        
        <button type="submit" class="pure-button pure-button-primary">提交</button>
    </fieldset>
</form>
