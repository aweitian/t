<?php
require_once DATASRC_PATH."/base/DataSrc_22ap.php";
require_once DATASRC_PATH."/base/DataSrc_22tp.php";
require_once DATASRC_PATH."/base/DataSrc_22ld.php";
require_once DATASRC_PATH."/base/DataSrc_23ldp.php";
require_once DATASRC_PATH."/base/DataSrc_23tpe.php";
require_once DATASRC_PATH."/base/DataSrc_hot.php";
require_once DATASRC_PATH."/base/DataSrc_html.php";
require_once DATASRC_PATH."/base/DataSrc_ofhint.php";
require_once DATASRC_PATH."/base/DataSrc_ns.php";
require_once DATASRC_PATH."/DataSrcPath.php";
class dataSrc{
	public static $typeArr = array(
			"22ap" => "22ap",
			"22ld" => "22ld",
			"22tp" => "22tp",
			"23ldp" => "23ldp",
			"23tpe" => "23tpe",
			"hot" => "hot",
			"html" => "html",
			"ofhint" => "order field hint",
	);
	public static $samples = array(
			"22ap" => array(
					array(5,10),
					array(10,20),
					array(15,29),
			),
			"22ld" => array(
					array(5,1),
					array(10,2),
					array(15,3),
			),
			"22tp" => array(
					array("wow lv1-10",10),
					array("sample title",20),
					array("test title",29),
					array("aion gold 50",29),
			),
			"23ldp" => array(
					array(5,1,10),
					array(10,2,19),
					array(15,3,28),
					array(50,30,270),
			),
			"23tpe" => array(
					array("wow lv1-10",10,"require gold 50"),
					array("sample title",20,"require level 5+"),
					array("test title",29,""),
					array("aion gold 50",29,"require something"),
			),
			"hot" => array(
					array("qaz","11","2","ico1","0","pl"),
					array("wsx","33","4","ico2","1","pl"),
					array("edc","44","6","ico3","2","pl"),
					array("wsxq","55","8","ico2","3","pl"),
					array("edcc","66","11","ico3","4","pl")
			),
			"html" => "<i>hi</i>",
			"ofhint" => array("svr1","svr2","svr3")
	);
	public static function cf2ds($cftype){
		switch ($cftype){
			case "html":
				return $cftype;
			default:
				$tmp = explode("_", $cftype);
				if(count($tmp)==2){
					return $tmp[1];
				}
				throw new Exception("invalid config type",6);
		}
	}
	public static function create($dstype,$data){
		switch ($dstype){
			case "22ap":
				return new DataSrc_22ap($data);
			case "22ld":
				return new DataSrc_22ld($data);
			case "22tp":
				return new DataSrc_22tp($data);
			case "23ldp":
				return new DataSrc_23ldp($data);
			case "23tpe":
				return new DataSrc_23tpe($data);
			case "hot":
				return new DataSrc_hot($data);
			case "html":
				return new DataSrc_html($data);
			case "ofhint":
				return new DataSrc_ofhint($data);
		}
		throw new Exception("invalid ds type",0x90);
	}
	
}