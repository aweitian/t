<?php
/**
 * Date:2015年5月6日
 * Author:Awei.tian
 * Function:
 */
// var_dump($data);exit;
$required = array(
	"Email","Your Password","Security question","Security answer","Repeat Password"
);
?>
<script>
function m_check(form){
	if(form.pswod.value != form.pswod1.value){
		alert("password does not matched.");
		return false;
	}
	if(form.pswod.value == ""){
		alert("password is required.");
		return false;
	}
	if(form.email.value == ""){
		alert("email is required.");
		return false;
	}
	if(form.squst.value == ""){
		alert("Security question is required.");
		return false;
	}
	if(form.sqkey.value == ""){
		alert("Security answer is required.");
		return false;
	}
	return true;
}
</script>
<div class="m-panel" id="g-register">
<div class="head">Your Login:</div>
<div class="m-form">

<form action="<?php print ENTRY_HOME?>/member/register" method="post" onsubmit="return m_check(this)">
<fieldset>
<?php if($errorMsg!=""):?><p style="color:red;padding:8px;text-align:center;font-size:20px;"><?php print print "Error:".$errorMsg;?></p><?php endif;?>
<?php foreach ($data as $k => $item):?>

<div class="formitm">
	<label class="lab"><?php print $k?></label>
 	<div class="ipt">
		<?php print str_replace(">"," class='u-ipt'>",$item)?>
		<?php if(in_array($k, $required)):?> <span class="domain">*(required)</span><?php endif;?>
	</div>
</div>
<?php endforeach;?>
<div class="formitm formitm-1"><button class="u-btn" type="submit">Submit</button> <a href="<?php print ENTRY_HOME?>/member/login">Login</a></div>
</fieldset>
</form>

</div>
</div>