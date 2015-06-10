<?php
/**
 * @author:awei.tian
 * @date: 2014-11-18
 * @functions:
 */
require_once ENTRY_PATH."/app/data/conf/base/calc_22ap.php";
require_once ENTRY_PATH."/app/data/conf/base/spancalc_22ld.php";
require_once ENTRY_PATH."/app/data/conf/base/spancalc_23ldp.php";
require_once ENTRY_PATH."/app/data/conf/base/table_22ap.php";
require_once ENTRY_PATH."/app/data/conf/base/table_22ld.php";
require_once ENTRY_PATH."/app/data/conf/base/table_22tp.php";
require_once ENTRY_PATH."/app/data/conf/base/table_23ldp.php";
require_once ENTRY_PATH."/app/data/conf/base/table_23tpe.php";
require_once ENTRY_PATH."/app/data/conf/base/table_hot.php";
require_once ENTRY_PATH."/app/data/conf/base/html.php";
class conf{
	public static $typeArr = array (
		"table_22tp" => "table_22tp_name",
		"table_23tpe" => "table_23tpe_name",
		"table_22ap" => "table_22ap_name",
		"table_23ldp" => "table_23ldp_name",
		"table_22ld" => "table_22ld_name",
		"spancalc_23ldp" => "spancalc_23ldp_name",
		"spancalc_22ld" => "spancalc_22ld_name",
		"calc_22ap" => "calc_22ap_name", 
		"table_hot" => "table_hot_name" ,
		"html" => "table_html_name" 
	);
	public static function getDefaultConf($type){
		switch ($type) {
			case "html":
				return conf_html::getDefaultConf();
			case "table_hot":
				return conf_table_hot::getDefaultConf();
			case "table_22tp":
				return conf_table_22tp::getDefaultConf();
			case "table_23tpe":
				return conf_table_23tpe::getDefaultConf();
			case "table_22ap":
				return conf_table_22ap::getDefaultConf();
			case "table_23ldp":
				return conf_table_23ldp::getDefaultConf();
			case "table_22ld":
				return conf_table_22ld::getDefaultConf();
			case "spancalc_23ldp":
				return conf_spancalc_23ldp::getDefaultConf();
			case "spancalc_22ld":
				return conf_spancalc_22ld::getDefaultConf();
			case "calc_22ap":
				return conf_calc_22ap::getDefaultConf();
			default:
				throw new Exception("invalid type", 0x2356);
			break;
		}
	}
	public static function create($type,$conf){
		switch ($type) {
			case "html":
				return new conf_html($conf);
			case "table_hot":
				return new conf_table_hot($conf);
			case "table_22tp":
				return new conf_table_22tp($conf);
			case "table_23tpe":
				return new conf_table_23tpe($conf);
			case "table_22ap":
				return new conf_table_22ap($conf);
			case "table_23ldp":
				return new conf_table_23ldp($conf);
			case "table_22ld":
				return new conf_table_22ld($conf);
			case "spancalc_23ldp":
				return new conf_spancalc_23ldp($conf);
			case "spancalc_22ld":
				return new conf_spancalc_22ld($conf);
			case "calc_22ap":
				return new conf_calc_22ap($conf);
			default:
				throw new Exception("invalid type", 0x2356);
				break;
		}
	}
}
