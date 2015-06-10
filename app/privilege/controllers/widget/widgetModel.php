<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */

require_once ENTRY_PATH."/app/api/privilege/data/widgetApi.php";
require_once ENTRY_PATH."/app/api/privilege/data/orderTplApi.php";
require_once ENTRY_PATH."/app/widgets/table/widget_table.php";
require_once ENTRY_PATH."/app/data/datakey/listDk.php";
require_once ENTRY_PATH."/app/data/confkey/listCk.php";
class widgetModel extends pmodel{
	public function __construct(){
		$this->_initdb();
	}
	public function getData($path){
		$api = new widgetApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"nodepath" => $path,
		));
		return $api->invoke();
	}
	/**
	 * @return affected roaws
	 * @param unknown_type $path
	 */
	public function remove($path,$order){
//		var_dump($path,$order);exit;
		$api = new widgetApi();
		$api->setMethod("delete");
		$api->setArgs(array(
			"path" => $path,
			"order" => $order,
		));
		return $api->invoke();
	}
	public function append($path,$order,$typeid,$datasrcpath,$confpath,$ordertpl,$comment){
// 		var_dump($path,$order,$typeid,$datasrcpath,$confpath,$comment);exit;
		$api = new widgetApi();
		$api->setMethod("post");
		$api->setArgs(array(
			"path"=>$path,
			"order"=>$order,
			"typeid"=>$typeid,
			"datasrcpath"=>$datasrcpath,
			"confpath"=>$confpath,
			"ordertpl"=>$ordertpl,
			"comment"=>$comment
		));
		return $api->invoke();
	}
	public function update($path,$old_order,$new_order,$typeid,$datasrcpath,$confpath,$ordertpl,$comment){
		$api = new widgetApi();
		$api->setMethod("put");
		$api->setArgs(array(
			"path"=>$path,
			"old_order"=>$old_order,
			"new_order"=>$new_order,
			"typeid"=>$typeid,
			"datasrcpath"=>$datasrcpath,
			"confpath"=>$confpath,
			"ordertpl"=>$ordertpl,
			"comment"=>$comment
		));
		return $api->invoke();
	}
	public function info($path,$order){
		$api = new widgetApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"path" => $path,
			"order"=> $order
		));
		return $api->invoke();
	}
	public function autoCompleteDk($cur){
		$cur = explode("_", $cur);
		if(count($cur) == 2){
			$cur = $cur[1];
		}else{
			$cur = $cur[0];
		}
		$demo = new listDk();
		return $demo->getDsList($cur);
	}
	public function autoCompleteCk($cur){//var_dump($cur);exit;
		$demo = new listCk();
		return $demo->getCkList($cur);
	}
	public function getAllOrderTpl(){
		$api = new orderTplApi();
		$api->setMethod("get");
		$tpl = $api->invoke();
		$ret = array();
		foreach ($tpl as $row){
			$ret[] = $row["name"];
		}
		return $ret;		
	}
	public function defaultValue($nodepath){
		$api = new widgetApi();
		$api->setMethod("get");
		$api->setScenario("maxorder");
		$api->setArgs(array(
				"path" => $nodepath,
		));
		$mo = $api->invoke();
		if(!$mo)$mo = 1;
		else
			$mo = (int)$mo + rand(10, 25);
// 		$api = new orderTplApi();
// 		$api->setMethod("get");
// 		$tpl = $api->invoke();
// 		if(!empty($tpl)){
// 			$tpl = $tpl[0]["name"];
// 		}else{
// 			$tpl = "";
// 		}
		return array(
			"order" => $mo,
			"typeid" => "table_22tp",
			"datasrcpath" => "",
			"confpath" => "",
			"ordertpl" => "",
			"comment" => ""
		);
	}
}