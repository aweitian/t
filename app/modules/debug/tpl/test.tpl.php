<?php
/**
 * Date: 2016年1月3日
 * Author: Awei.tian
 * Description: 
 */
/**
 * @var Pagination
 */
$page = $data;
function pageUrl($p){
	return App::url_ca("debug")."?pn=".$p;
}
/**
 * 
 * @param Pagination $page
 * @return string
 */
function showRear($page){
	$html = '';
	$i=0;
	if ($page->getStartPage()>1){
		$html .= '<li><a href="'.pageUrl(1).'">'.(1).'</a></li>';
		if ($page->getStartPage()>2) {
			$html .= '<li><a>...</a></li>';
		}
	}
	for ($i=$page->getStartPage();$i<$page->getStartPage()+$page->getPageBtnLen();$i++)
		$html .= '<li><a href="'.pageUrl($i).'">'.($i).'</a></li>';
	
	$i--;
	if ($i<$page->getMaxPage()-1){
		$html .= '<li><a>...</a></li>';
	}
	if ($i<$page->getMaxPage()){
		$html .= '<li><a href="'.pageUrl($page->getMaxPage()).'">'.($page->getMaxPage()).'</a></li>';
	}
	return $html;
	
}
?>
<nav>

  <ul class="pagination">
  <?php if($page->hasPre()):?>
    <li>
      <a href="<?php print App::url_ca("debug")."?pn=".$page->getPre()?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <?php endif;?>
    <?php print showRear($page)?>

    <?php if($page->hasNext()):?>
    <li>
      <a href="<?php print App::url_ca("debug")."?pn=".$page->getNext()?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
     <?php endif;?>
  </ul>
</nav>