<?php
//处理HTTP post data
//重新计算价格
require_once ENTRY_PATH."/app/data/order/orderInfo.php";
require_once ENTRY_PATH."/app/api/privilege/data/orderApi.php";
require_once ENTRY_PATH."/app/data/order/orderOp.php";
class orderSubscribe{
	public function __construct(){
		
	}
	public function est($msg){
		if(!isset($msg["c"])){
			throw new Exception("invalid c argc", 0x9);
			return ;
		}
// 		var_dump($msg["c"]);exit;
		switch ($msg["c"]){
			case "calcJS":
				$this->_check(array("np","ns","wo","amt"), $msg);
				$locPrice = array("amount"=>$msg["amt"]);//unit 会在ORDERINFO内部自动填充
				break;
			case "calc":
				$this->_check(array("np","ns","wo","amount"), $msg);
				//使用POST提交,不知道NS的NAME是多少,固需要一个字段来描述NS的NAME有哪些
				$msg["ns"] = $this->_get_ns($msg);
				$locPrice = array(
					"amount"=>$msg["amount"]
					//unit 会在ORDERINFO内部自动填充
				);
				break;
			case "spancalcJS":
				$this->_check(array("np","ns","wo","cur","dst"), $msg);
				$locPrice = array(
					"start"=>$msg["cur"],
					"end"=>$msg["dst"]
					//unit 会在ORDERINFO内部自动填充
				);
				break;
			case "spancalc":
				$this->_check(array("np","ns","wo","cs","ds"), $msg);
				$msg["ns"] = $this->_get_ns($msg);
				$locPrice = array(
					"start"=>$msg["cs"],
					"end"=>$msg["ds"]
					//unit 会在ORDERINFO内部自动填充
				);
				break;
			case "tbJS":
			case "tb":
				$this->_check(array("np","ns","wo","tt"), $msg);
				$locPrice = $msg["tt"];
				break;
			default:
				throw new Exception("Invalid argus.Code:3",3);
				return ;
		}
		$oderinfo = new orderInfo();
		return $oderinfo->prebi($msg["np"],$msg["wo"],$msg["ns"],$locPrice);
	}
	/**
	 * 
	 * @param unknown $msg
	 * @throws Exception
	 * @return array(
	 *  "id"=>22
	 * 	"title"=>..
	 * 	"price"=>22,
	 *  "pmtype"=>pp
	 * )
	 */
	public function subscribe($msg){
		if(!isset($msg["qs"],$msg["pmtype"])){
			throw new Exception("require payment type.", 0x9);
			return ;
		}
		$ip = tian::$context->getIdentityToken()->getIp();
//		var_dump($ip);exit;
		$pmtype = $msg["pmtype"];
		$msg_locprice = httpDataConverter::formToArray(urldecode($msg["qs"]));
		// 		var_dump($msg["c"]);exit;
		switch ($msg_locprice["c"]){
			case "calcJS":
				$this->_check(array("np","ns","wo"), $msg_locprice);
				$locPrice = array("amount"=>$msg_locprice["localprice"]);
				break;
			case "calc":
				$this->_check(array("np","ns","wo","amount"), $msg_locprice);
				//使用POST提交,不知道NS的NAME是多少,固需要一个字段来描述NS的NAME有哪些
				$msg_locprice["ns"] = $this->_get_ns($msg_locprice);
				$locPrice = array(
					"amount"=>$msg_locprice["amount"]
					//unit 会在ORDERINFO内部自动填充
				);
				break;
			case "spancalcJS":
				$this->_check(array("np","ns","wo","cur","dst"), $msg_locprice);
				$locPrice = array(
						"start"=>$msg_locprice["cur"],
						"end"=>$msg_locprice["dst"]
						//unit 会在ORDERINFO内部自动填充
				);
				break;
			case "spancalc":
				$this->_check(array("np","ns","wo","cs","ds"), $msg_locprice);
				$msg_locprice["ns"] = $this->_get_ns($msg_locprice);
				$locPrice = array(
						"start"=>$msg_locprice["cs"],
						"end"=>$msg_locprice["ds"]
						//unit 会在ORDERINFO内部自动填充
				);
				break;
			case "tbJS":
			case "tb":
				$this->_check(array("np","ns","wo","tt"), $msg_locprice);
				$locPrice = $msg_locprice["tt"];
				break;
			default:
				throw new Exception("Invalid argus.Code:3",3);
				return ;
		}
// 		var_dump($locPrice);exit;
		$oderinfo = new orderInfo();
		$info = $oderinfo->prebi($msg_locprice["np"],$msg_locprice["wo"],$msg_locprice["ns"],$locPrice,false);
		$op = new orderOp();
		$dlvArr = array();
		foreach ($info["delivery"]["data"] as $dlvkey => $dlv){
			$key = "delivery_".$dlvkey;
			if(!isset($msg[$key])){
				throw new Exception("Require ".$dlv["name"], 1);
				return ;
			}
			$dlvArr[$dlvkey] = $msg[$key];
		}
// 		var_dump($info);exit;
		$ret = $op->add(
			$pmtype,
			$this->_search_eml($msg),
			$info["dt"],
			$info["title"],
			$info["price"],
			$info["np"],
			$info["wo"],
			$this->_g_locprice_str($locPrice),
			$dlvArr,
			$ip
		);
		if($ret > 0){
			return array(
				"id"=>$ret,
				"title"=>$info["title"],
				"price"=>$info["price"],
				"pmtype"=>$pmtype
			);
		}
		throw new Exception("An error has occured.please contact us via email:awei.tian@qq.com", 5);
	}
	
	
	
	
	private function _g_locprice_str($locprice){
		if(is_string($locprice))return $locprice;
		if(is_array($locprice)){
			if(array_key_exists("amount", $locprice)){
				return "Amount:".$locprice["amount"];
			}else if(array_key_exists("start", $locprice) && array_key_exists("end", $locprice)){
				return "current:".$locprice["start"].",destination:".$locprice["end"];
			}
		}
		return "notfound";
	}
	private function _search_eml($msg){
		if(isset($msg["delivery_email"])){
			return $msg["delivery_email"];
		}else if($msg["delivery_eml"]){
			return $msg["delivery_eml"];
		}
		return "err@qq.cc";
	}
	private function _get_ns($msg){
		$nsArr = explode(",", $msg["ns"]);
		$ns = "";
		foreach ($nsArr as $item){
			//加 _ 和tpl.php函数add_prefix_forname呼应
			if(!isset($msg["_".$item])){
				throw new Exception("Invalid argus.Code:2",1);
				return ;
			}
			$ns .= "/".$msg["_".$item];
		}
		if($ns == "")$ns = "/";
		return $ns;
	}
	private function _check($arg,$arr,$msg=""){
		foreach ($arg as $a){
			if(!isset($arr[$a])){
				throw new Exception($msg == "" ? ("Invalid qs.".$a) : $msg, 0x9);
				return ;
			}			
		}
	}
}