<?php
/**
 * Date:2015年5月6日
 * Author:Awei.tian
 * Function:
 */
//var_dump($data);exit;
?>
<div class="m-panel" id="g-register">
<div class="head">Login:</div>

	<div class="m-form">
		<div id="member-login">
		<form action="<?php print ENTRY_HOME?>/member/login" method="post">
		<fieldset>
		<?php foreach ($data as $k => $item):?>
		<div class="formitm">
			<label class="lab"><?php print $k?></label>

			<div class="ipt"><?php print str_replace(">"," class='u-ipt'>",$item)?></div>
		<?php endforeach;?>
		<div class="formitm formitm-1">
			<button class="u-btn" type="submit">Submit</button> 
		</div>
		</fieldset>
		</form>
		<br>
		<br>
		<br>
		<br>
		<br>
		<p style="padding-left:50px;">
			<a href="<?php print ENTRY_HOME?>/member/register"><i class="icon-arrow-right"></i> Register</a>
			<br>
			<br>
			<a href="<?php print ENTRY_HOME?>/member/forgotpwd"><i class="icon-arrow-right"></i> Forgot Password?</a>
		</p>
		<br>
		<br>
		</div>
	</div>
</div>
