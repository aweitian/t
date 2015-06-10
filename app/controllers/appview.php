<?php
/**
 * @author:awei.tian
 * @date: 2014-11-15
 * @functions:
 */
require_once ENTRY_PATH."/app/interfaces/IUi.php";

class appView extends view{
	public $content;
	/**
	 * @return IUi
	 */
	public $ui;
	public function __construct(){
		$theme = app::$theme;
		$ui_loc = ENTRY_PATH."/themes/".$theme."/ui.php";
		if(!file_exists($ui_loc)){
			throw new Exception("invalid theme name:".$theme,5);
		}
		require_once $ui_loc;
		if(!class_exists("ui")){
			throw new Exception("invalid ui file",5);
		}
		$rc = new ReflectionClass("ui");
		if(!$rc->implementsInterface("IUi")){
			throw new Exception("ui must be implements interface:IUi",1);
		}
		$this->ui = $rc->newInstance();
	}
	public function getCtrlPath(){
		$msg = tian::$context->getMessage();
		return $msg->getModuleLoc()."/".$msg->getControl();
	}
	public function fetch($vars,$tpl){
		ob_start();
		extract($vars);
		include $this->getCtrlPath()."/tpl/".$tpl.".php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
}