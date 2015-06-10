<?php
/**
 * Date: 2015-1-26
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/uipatch/pagination/uipatch_pagination.php";
$pagination = new uipatch_pagination($data["cnt"], 0, 10, 5);
// $pagination = new uipatch_pagination(25, 0, 10, 5);
$page_data = $pagination->getData();
// var_dump($data);


// array(9) {
//       ["id"]=>
//       string(1) "2"
//       ["title"]=>
//       string(8) "hi again"
//       ["contt"]=>
//       string(24) "leave a message balabala"
//       ["email"]=>
//       string(6) "a@b.cc"
//       ["ipars"]=>
//       string(9) "127.0.0.1"
//       ["pictt"]=>
//       string(5) "face1"
//       ["reply"]=>
//       string(3) "lol"
//       ["times"]=>
//       string(19) "2015-01-22 16:01:36"
//       ["nname"]=>
//       string(2) "ui"
//     }
?>
<div class="col-2 col-offset-10"><a href=""><i class="icon-uniE62A"></i> Post a feedback</a></div>

<?php if($page_data["maxPage"]>0):?>
<div class="feedback-item">
<?php foreach ($data["data"] as $item):?>
<div class="feedback-name"><?php print $item["nname"]?></div>
<div class="feedback-title"><?php print $item["title"]?></div>
<div class="feedback-date"><?php print $item["times"]?></div>
<?php if($item["reply"] != ""):?>
<div class="feedback-date"><?php print $item["reply"]?></div>
<?php endif;?>
<?php endforeach;?>
</div>

<?php else:?>
no feedback.
<?php endif;?>


<?php if($page_data["maxPage"]>1):?>
<div class="pagination">
<?php print $cur+1?> of <?php print $page_data["maxPage"]?>

<?php for($i=0;$i<$page_data["maxPage"];$i++):?>
<?php if($i+$page_data["start"] == $cur +1):?>
	<?php print $i+$page_data["start"]?>
<?php else:?>
	<a href="<?php echo ENTRY_HOME?>/feedback?page=<?php print $i+$page_data["start"]?>"><?php print $i+$page_data["start"]?></a>
<?php endif;?>
<?php endfor;?>
</div>
<?php endif;?>