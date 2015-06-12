<?php
/**
 * Date: 2014-11-28
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH.'/app/appConst.php';
require_once ENTRY_PATH.'/app/controllers/appController.php';
require_once ENTRY_PATH.'/app/controllers/appmodel.php';
require_once ENTRY_PATH.'/app/controllers/appview.php';

class app{
	public static $theme = "default";
	private static $Dep = array(
		"spancalc"=>false,
		"calc"=>false,
		"table"=>false
	);
	public static function calcPwd($pwd){
		return md5($pwd);
	}
	public static function isValidUnit($unit){
		return preg_match("/^(\d+\s*)?[a-z]+$/", $unit);
	}
	public static function calcUnit($unit,$acount){
		$ua = preg_replace("/[^\d]/","",$unit);
		if($ua == ""){
			$ua = 1;
		}else{
			$ua = (int)$ua;
		}
		return ($ua * $acount) . " " . preg_replace("/[^a-z]/","",$unit);
	}
	//spancalc
	public static function addWidgetDep($widgetid){
		if(isset(self::$Dep[$widgetid]))self::$Dep[$widgetid] = true;
	}
	public static function floatcmp($f1,$f2,$precision = 10) {// are 2 floats equal
		$e = pow(10,$precision);
		$i1 = intval($f1 * $e);
		$i2 = intval($f2 * $e);
		return ($i1 == $i2);
	}
	public static function floatgtr($big,$small,$precision = 10) {// is one float bigger than another
		$e = pow(10,$precision);
		$ibig = intval($big * $e);
		$ismall = intval($small * $e);
		return ($ibig > $ismall);
	}
	public static function floatgtre($big,$small,$precision = 10) {// is on float bigger or equal to another
		$e = pow(10,$precision);
		$ibig = intval($big * $e);
		$ismall = intval($small * $e);
		return ($ibig >= $ismall);
	}
	public static function pp($c,$np,$wid,$ns,$li){
		$url = ENTRY_HOME."/order/estimate?";
		$args = array();
		$args[] = "c=".$c;
		$args[] = "np=".urlencode($np);
		$args[] = "ns=".urlencode($ns);
		$args[] = "wo=".$wid;
		switch($c){
			case "tbJS":
			case "tb":
				$args[] = "tt=".urlencode($li);
				break;
			case "spancalcJS":
				$li = explode("-", $li);
				$args[] = "cur=".$li[0];
				$args[] = "dst=".$li[1];
				break;
			case "calcJS":
				$args[] = "amt=".$li;
				break;
		}
		return $url.join("&",$args);
	}
	public static function getBuyNowBtnHtml(){
		return '<button class="u-btn u-btn-c4">Buy now</button>';
	}
	public static function getPayMethods(){
		return array(
			"paypal",	
			"paysafecard",	
			"sofort",	
			"cashu",	
			"boleto_br",	
			"qiwi",	
			"onecard",	
		);
	}
	public static function isMobile(){
		$userAgent = tian::$context->getRequest()->getUserAgent();
		$userAgent = strtolower($userAgent);
		$keywords = array("android", "iphone", "ipod", "ipad", "windows phone", "mqqbrowser", "symbian", "blackberry", "ucweb", "linux; u;" ) ;
		foreach($keywords as $kw){
			if(strpos($userAgent, $kw) !== false)return true;
		}
		
		return false;
	}
// 	/**
// 	 * @param array $data 涓�淮鏁扮粍
// 	 * @param string $tpl 妯℃澘涓殑key,val灏嗕細琚浛鎹�
// 	 */
// 	public static function arrWrap($data,$tpl="<tr><td>key</td><td>val</td></tr>"){
// 		$ret="";
// 		foreach ($data as $key => $val){
// 			$ret .= strtr($tpl, array("key"=>$key,"val"=>$val));
// 		}
// 		return $ret;
// 	}
}