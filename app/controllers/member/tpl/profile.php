<?php
/**
 * Date: 2015-1-26
 * Author: Awei.tian
 * function: 
 */
// var_dump($data);exit;
?>
<div style="width:50%;margin:32px auto;">
<table class="m-table">
           <caption>Your profile</caption>
           <tbody>
            <tr>
                <td>Email：</td>
                <td>
                    <?php print $data["member_email"]?>
                </td>
            </tr>
            <tr>
                <td>Your consume：</td>
                <td>
                    <?php print $data["member_cnsum"]?>
                </td>
            </tr>
            <tr>
                <td>Name：</td>
                <td>
                    <?php print $data["member_fname"]." ".$data["member_fname"] ?>
                </td>
            </tr>
            <tr>
                <td>Security question：</td>
                <td>
                    <?php print $data["member_squst"]?>
                </td>
            </tr>
            <tr>
                <td>Security answer：</td>
                <td>
                    <?php print substr($data["member_sqkey"], 0,3)."***"?>
                </td>
            </tr>
            <tr>
                <td>Your member rank：</td>
                <td>
                    <?php print $data["member_ranks"]?>
                </td>
            </tr>
            <tr>
                <td>VIP ID：</td>
                <td>
                    <?php print $data["member_vipid"]?>
                </td>
            </tr>
            <tr>
                <td>Phone：</td>
                <td>
                    <?php print $data["member_phone"]?>
                </td>
            </tr>
            <tr>
                <td>MSN：</td>
                <td>
                    <?php print $data["member_mssnn"]?>
                </td>
            </tr>
            <tr>
                <td>AIM：</td>
                <td>
                    <?php print $data["member_aimmm"]?>
                </td>
            </tr>
            <tr>
                <td>Yahoo：</td>
                <td>
                    <?php print $data["member_yahoo"]?>
                </td>
            </tr>
<tr>
	<td colspan="2" align="center"><a href="<?php print tian::$context->getRequest()->frontUrl()?>">Back</a></td>
</tr>          
           
           </tbody>
 
</table>

</div>

 


