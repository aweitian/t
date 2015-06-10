<?php
/**
 * Date:2015年5月5日
 * Author:Awei.tian
 * Function:
 */
// var_dump($data);exit;
?>
<div style="width:512px;margin:128px auto;">
<form class="pure-form pure-form-stacked" action="<?php print ENTRY_HOME?>/priv/member/update" method="post">
    <fieldset>
        <legend>修改会员消费金额</legend>
		<input name="eml" type="hidden" value="<?php print $data["member_email"]?>">
        <label for="email">EMAIL:<?php print $data["member_email"]?></label>
        <div>
        	<br>
        </div>
		<label for="email">VIP ID</label>
        <div>
        	<input name="vid" value="<?php print $data["member_vipid"]?>">
        </div>
		<label for="email">金额</label>
        <div>
        	<input name="cnsm" value="<?php print $data["member_cnsum"]?>">
        </div>
		<label for="email">级别</label>
        <div>
        	<select name="rank">
        	<option value="member"<?php if($data["member_ranks"] == "member")echo " selected"?>>member</option>
        	<option value="copper"<?php if($data["member_ranks"] == "copper")echo " selected"?>>copper</option>
        	<option value="silver"<?php if($data["member_ranks"] == "silver")echo " selected"?>>silver</option>
        	<option value="golden"<?php if($data["member_ranks"] == "golden")echo " selected"?>>golden</option>
        	</select>
        </div>
        
        <button type="submit" class="pure-button pure-button-primary">提交</button>
    </fieldset>
</form>
</div>