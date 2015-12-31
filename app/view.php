<?php
/**
 * Date: 2015年12月31日
 * Author: Awei.tian
 * Description: 
 */
class view{
	protected $html;
	public function wrap($content,$title=""){
		ob_start();
		include 'template/layout.php';
		$this->html = ob_get_contents();
		ob_end_clean();
		return $this;
	}
	public function fetch($tpl,$data=array(),$ext='.tpl.php'){
		$ctl = App::$router->getController();
		ob_start();
		if(strpos($tpl,'/') !== 0){
			$tpl = FILE_SYSTEM_ENTRY."/app/modules/".$ctl."/tpl/".$tpl.$ext;
		}
		include $tpl;
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
	public function show(){
		print $this->html;
		exit;
	}
}