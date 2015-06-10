<?php
/**
 * Date: 2015-1-5
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/widgets/calc/widget_calc.php";
require_once ENTRY_PATH."/app/widgets/html/widget_html.php";
require_once ENTRY_PATH."/app/widgets/spancalc/widget_spancalc.php";
require_once ENTRY_PATH."/app/widgets/table/widget_table.php";
class appController extends Controller{
	public static function _checkPrivilege(message $msg,identityToken $it){
		return true;
	}
	public function getCtrlPath(){
		$msg = tian::$context->getMessage();
		return $msg->getModuleLoc()."/".$msg->getControl();
	}
}