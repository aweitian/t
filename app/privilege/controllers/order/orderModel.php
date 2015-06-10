<?php
/**
 * @author:awei.tian
 * @date: 2015-4-9
 * @functions:
 */
require_once ENTRY_PATH.'/app/data/order/orderInfo.php';
class orderModel extends pmodel{
	public function getData($page){
		$info = new orderInfo();
		return $info->all($page * 10, 10);
	}
	public function getDataByCond($page,$cond){
		$info = new orderInfo();
		if(is_string($cond)){
			if(validator::isDate($cond)){
				return $info->searchByDate($cond." 0:0:0", $cond." 23:59:59", $page * 10, 10);
			}else if(validator::isEmail($cond)){
				return $info->searchByEml($cond, $page * 10, 10);
			}
		}else if(is_array($cond)){
			if(array_key_exists("eml", $cond) &&　array_key_exists("date", $cond)){
				if(validator::isEmail($cond["eml"]) && validator::isDate($cond["date"])){
					return $info->searchByDateEml(
							$cond["date"]." 0:0:0", 
							$cond["date"]." 23:59:59", 
							$cond["eml"], $page * 10, 10);
				}
			}
		}
		return $info->all($page * 10, 10);
	}
	public function remove($sid){
		$api = new orderApi();
		$api->setMethod("delete");
		$api->setArgs(array(
			"sid" => $sid
		));
		return $api->invoke();
	}
	public function getDataBySid($sid){
		$api = new orderApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"sid" => $sid
		));
		return $api->invoke();
	}
	public function reply($sid,$reply){
		$api = new orderApi();
		$api->setMethod("put");
		$api->setArgs(array(
				"sid" => $sid,
				"reply" => $reply
		));
		return $api->invoke();
	}
}