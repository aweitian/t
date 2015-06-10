<?php
/**
 * @author:awei.tian
 * @date: 2014-11-15
 * @functions:
 */
class pview extends view{
	public $content;
	public function showOk($info,$url=null,$count=null){
		ob_start();
		include_once ENTRY_PATH."/app/privilege/tpl/ok.tpl.php";
		$this->content = ob_get_contents();
		ob_end_clean();
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
		return;
	}
	public function showFail($error,$url=null,$count=null){
		if($error instanceof Exception){
			if($error->getCode() == mysqlPdoBase::NONERRCODE){
				$error = "此次操作没有改变数据库";				
			}else{
				if(APP_DEBUG){
					$format = '[%d]: %s <br> %s';
					$error = sprintf($format, $error->getLine(), $error->getMessage(),$error->getFile());	
				}else{
					$format = '[%d]: %s';
					$error = sprintf($format, $error->getCode(), $error->getMessage());	
				}
			}
		}
		ob_start();
		include_once ENTRY_PATH."/app/privilege/tpl/fail.tpl.php";
		$this->content = ob_get_contents();
		ob_end_clean();
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
		return;
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