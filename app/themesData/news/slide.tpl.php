<?php
/**
 * Date:2015年5月6日
 * Author:Awei.tian
 * Function:
 */
// var_dump($data);exit;
//   array(4) {
//   [0]=>
//   array(8) {
//     ["sid"]=>
//     string(1) "4"
//     ["title"]=>
//     string(5) "awewe"
//     ["content"]=>
//     string(13) "csdfasdontent"
//     ["lnk"]=>
//     string(6) "/ep/gh"
//     ["sldimg"]=>
//     string(6) "zz.jpg"
//     ["sldflg"]=>
//     string(1) "1"
//     ["sldorder"]=>
//     string(1) "4"
//     ["date"]=>
//     string(10) "2015-01-26"
//   }
?>
	<div class="news-slder-frame css3-radius8 css3-box">
				<div id="news_slideBox" class="slideBox">
					<ul class="items">
					<?php foreach ($data as $item):?>
						<li><a title="<?php print $item["title"]?>" href="<?php print $item["lnk"]?>"><img src="<?php print ENTRY_HOME?>/uploads/slider/<?php print $item["sldimg"]?>"></a></li>
					<?php endforeach;?>
					</ul>
				</div>
			<script type="text/javascript">
				$('#news_slideBox').slideBox();
			</script>
		</div>