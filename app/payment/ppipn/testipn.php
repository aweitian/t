<?php
/**
 * @author awei.tian
 * date: 2013-10-14
 * 说明:
 */
?>
测试IPN，主要看看有没有语法错误
<form action="ipn.php?BAE_FORCE_DEBUG=on" method="post">
<input type="hidden" name="business" value="xlong928_business@gmail.com">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="return" value="http://0.paypalipn.duapp.com/success.php">
<input type="hidden" name="cancel_return" value="http://0.paypalipn.duapp.com/error.php">
<input type="hidden" name="notify_url" value="http://0.paypalipn.duapp.com/ipn.php">
<input type="hidden" name="currency_code" value="USD">
<input type="text" name="item_name" value="test ipn title">
<input type="text" name="amount" value="12.34">
<input type="hidden" name="item_number" value="4">
<div class="ppipnsubmitbtn"><input type="submit" value="Check out"></div>


</form>