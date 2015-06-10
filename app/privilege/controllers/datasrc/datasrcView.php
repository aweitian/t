<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */

class datasrcView extends pview{
	public function __construct(){
	}
	public function add($path,$data){
		$this->content = $this->_list($path,ENTRY_HOME."/priv/datasrc/append",$data);
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function edit($path,$data){
		$this->content = $this->_list($path,ENTRY_HOME."/priv/datasrc/update",$data);
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	private function _list($path,$submit_url,$data){
		ob_start();
		include_once dirname(__FILE__)."/tpl/item.tpl.php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
	
}