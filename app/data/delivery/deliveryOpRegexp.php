<?php
/**
 * Date: 2014-12-30
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/orderTpl/orderTplOp.php";
require_once ENTRY_PATH."/app/data/orderTpl/orderTplInfo.php";
class deliveryOpRegexp{
	public static function isValidData($name,$data){
// 		var_dump($name);exit;
		if(!orderTplOpRegexp::isValidorderTplKey($name)){
			return false;
		}
		if(!tian::$context->getDb()->getDbInfo()->tableExists("tny_delivery_".$name)){
			return false;
		}
		$helper = new orderTplInfo();
		$fields = $helper->getDeliveryInfos($name);
// 		var_dump($fields);exit;
		if(!is_array($data))return false;
		foreach ($fields as $field){
			if(!array_key_exists($field["key"], $data)){
				return false;
			}
		}
		return true;
	}
}