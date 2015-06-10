<?php
/**
 * @author:awei.tian
 * @date: 2015-5-5
 * @functions:
 */
?>
<div id="g-nav-menu">
<ul class="m-list2 f-cb">
<?php foreach ($data as $path):?>
<li class="nav-menu-item">
<a href="<?php print ENTRY_HOME?>/<?php print SVC_NAME;print $path?>"><?php $arr=explode("/", $path); print end($arr)?></a>
</li>
<?php endforeach;?>
</ul>

</div>