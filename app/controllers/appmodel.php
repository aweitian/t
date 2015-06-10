<?php
/**
 * @author:awei.tian
 * @date: 2014-11-15
 * @functions:
 */
class appModel extends model{
	public function getCtrlPath(){
		$msg = tian::$context->getMessage();
		return $msg->getModuleLoc()."/".$msg->getControl();
	}
}