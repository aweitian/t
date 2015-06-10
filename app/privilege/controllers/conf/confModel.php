<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */

require_once ENTRY_PATH."/app/api/privilege/data/confApi.php";

class confModel extends pmodel{
	public function __construct(){
		$this->_initdb();
	}
	public function getData($path){
		$api = new confApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"path" => $path,
		));
		return $api->invoke();
	}
	/**
	 * @return affected roaws
	 * Enter description here ...
	 * @param unknown_type $path
	 */
	public function remove($path){
		$api = new confApi();
		$api->setMethod("delete");
		$api->setArgs(array(
			"path" => $path,
		));
		return $api->invoke();
	}
	public function append($msg){
		$api = new confApi();
		$api->setMethod("post");
		$api->setArgs($this->_build_post_data($msg));
		return $api->invoke();
	}
	public function update($msg){
		$api = new confApi();
		$api->setMethod("put");
		$msg["span"] = explode(",", $msg["span"]);
		$api->setArgs($this->_build_post_data($msg));
// 		var_dump($this->_build_post_data($msg));exit;
		return $api->invoke();
	}
	public function info($path){
		$api = new confsApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"path" => $path,
		));
		return $api->invoke();
	}
	public function defaultValue(){
		return array(
			"key" => "",
			"dstype" => "",
			"deco" => "",
			"comment" => ""
		);
	}
//build post data
	private function _build_post_data($msg){
		if(!isset($msg["typeid"])){
			throw new Exception("invalid form format", 0x92);
		}
		switch ($msg["typeid"]){
			case "calc_22ap":
			case "spancalc_22ld":
				return array(
					"path" => $msg["path"],
					"data" =>json_encode(array(
						"unit" => $msg["unit"],
						"cachejs" => $msg["cachejs"]=="1"?true:false,
						"comment" => $msg["comment"],
					))
				);
			case "spancalc_23ldp":
				return array(
					"path" => $msg["path"],
					"data" =>json_encode(array(
						"cachejs" => $msg["cachejs"]=="1"?true:false,
						"comment" => $msg["comment"],
					))
				);
			case "table_22ap":
				return array(
					"path" => $msg["path"],
					"data" =>json_encode(array(
						"mutistyle" => $msg["mutistyle"],
						"comment" => $msg["comment"],
						"unit" => $msg["unit"],
						"tableCaption" => $msg["tableCaption"],
						"showType" => $msg["showType"],
						"gridCol" => $msg["gridCol"],
						"titleType" => $msg["titleType"],
					))
				);
			case "table_22ld":
				return array(
					"path" => $msg["path"],
					"data" =>json_encode(array(
						"mutistyle" => $msg["mutistyle"],
						"comment" => $msg["comment"],
						"unitprice" => $msg["unitprice"],
						"tableCaption" => $msg["tableCaption"],
						"showType" => $msg["showType"],
						"gridCol" => $msg["gridCol"],
						"span" => $msg["span"],
						"spanNum" => $msg["spanNum"],
						"titleType" => $msg["titleType"],
						"showCalcData" => $msg["showCalcData"]=="1"?true:false,
						"showZero2End" => $msg["showZero2End"]=="1"?true:false,
						"showA2B" => $msg["showA2B"]=="1"?true:false,
					))
				);
			case "table_22tp":
				return array(
					"path" => $msg["path"],
					"data" =>json_encode(array(
						"mutistyle" => $msg["mutistyle"],
						"comment" => $msg["comment"],
						"tableCaption" => $msg["tableCaption"],
						"showType" => $msg["showType"],
						"gridCol" => $msg["gridCol"],
						"titleType" => $msg["titleType"],
					))
				);
			case "table_23ldp":
				return array(
					"path" => $msg["path"],
					"data" =>json_encode(array(
						"mutistyle" => $msg["mutistyle"],
						"comment" => $msg["comment"],
						"tableCaption" => $msg["tableCaption"],
						"showType" => $msg["showType"],
						"gridCol" => $msg["gridCol"],
						"span" => $msg["span"],
						"spanNum" => $msg["spanNum"],
						"titleType" => $msg["titleType"],
						"showCalcData" => $msg["showCalcData"]=="1"?true:false,
						"showZero2End" => $msg["showZero2End"]=="1"?true:false,
						"showA2B" => $msg["showA2B"]=="1"?true:false,
					))
				);
			case "table_23tpe":
				return array(
					"path" => $msg["path"],
					"data" =>json_encode(array(
						"mutistyle" => $msg["mutistyle"],
						"comment" => $msg["comment"],
						"tableCaption" => $msg["tableCaption"],
						"showType" => $msg["showType"],
						"gridCol" => $msg["gridCol"],
						"titleType" => $msg["titleType"],
						"extraShowMode" => $msg["extraShowMode"],
						"iconPlaceHolder" => $msg["iconPlaceHolder"],
						"extraShowMask" => $msg["extraShowMask"],
						"extraCaption" => $msg["extraCaption"],
					))
				);
			default:
				throw new Exception("invalid form format", 0x92);
		}
		
	}	
}