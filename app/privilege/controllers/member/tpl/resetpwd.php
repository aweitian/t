<?php
/**
 * Date:2015年5月5日
 * Author:Awei.tian
 * Function:
 */
// var_dump($data);exit;
?>
<div style="width:512px;margin:128px auto;">
<form class="pure-form pure-form-stacked" action="<?php print ENTRY_HOME?>/priv/member/resetpwd" method="post">
    <fieldset>
        <legend>重置会员密码</legend>
		<input name="sid" type="hidden" value="<?php print $data["id"]?>">
		<input name="eml" type="hidden" value="<?php print $data["member_email"]?>">
        <label for="email">EMAIL:<?php print $data["member_email"]?></label>
        <div>
        	<br>
        </div>
		<label for="email">新密码为</label>
        <div>
        	<input name="pwd">
        </div>

        
        <button type="submit" class="pure-button pure-button-primary">提交</button>
    </fieldset>
</form>
</div>