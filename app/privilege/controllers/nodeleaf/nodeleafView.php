<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */
class nodeleafView extends pview{
	public function __construct(){
	}
	public function showList($path,$data){
		$this->content = $this->listnodeleaf($path,$data);
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function add($path,$append_path,$types,$labels,$default){
		$this->content = $this->nodeleafUI($path,$append_path,$types,$labels,$default,"add");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function edit($path,$append_path,$types,$labels,$default){
		$this->content = $this->nodeleafUI($path,$append_path,$types,$labels,$default,"edit");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	
	private function nodeleafUI($path,$append_path,$types,$labels,$defaultValue,$mode){
		ob_start();
		include_once dirname(__FILE__)."/tpl/item.tpl.php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
	private function listnodeleaf($path,$data){
		ob_start();
		include_once dirname(__FILE__)."/tpl/list.tpl.php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
	
}