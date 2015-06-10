<?php
/**
 * Date: 2015-1-26
 * Author: Awei.tian
 * function: 
 */

// var_dump($data);

?>
<div style="width:512px;margin:128px auto;">
<form class="pure-form pure-form-stacked" action="<?php print ENTRY_HOME?>/priv/feedback/reply" method="post">
    <fieldset>
         <legend>留言回复</legend>
		<input name="sid" type="hidden" value="<?php print $data["id"]?>">
        <label for="email">标题</label>
        <div>
        	<?php print $data["title"]?>
        </div>
		<label for="email">内容</label>
        <div>
        	<?php print $data["contt"]?>
        </div>
		<label for="email">回复</label>
        <div>
        	<textarea name="reply"><?php print $data["reply"]?></textarea>
        </div>
        
        <button type="submit" class="pure-button pure-button-primary">提交</button>
    </fieldset>
</form>

</div>
