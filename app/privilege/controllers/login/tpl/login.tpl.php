<?php


?>
<form action="<?php print ENTRY_HOME;?>/priv/login" method="post">

<table>
<caption>Login</caption>
<tr>
	<td>Name</td>
	<td><?php print $loginuidata["Name"]?></td>
</tr>
<tr>
	<td>Password</td>
	<td><?php print $loginuidata["Password"]?></td>
</tr>
<?php if(isset($loginuidata["Verification code"])):?>
<tr>
	<td>Verification code:</td>
	<td><?php print $loginuidata["Verification code"]?><?php print $loginuidata["code_img"]?></td>
</tr>
<?php endif;?>
<tr>
	<td colspan="2"><input type="submit" value="submit"></td>
</tr>
</table>
</form>
