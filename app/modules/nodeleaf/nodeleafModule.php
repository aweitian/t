<?php
/**
 * Date: 2015-1-23
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/interfaces/IOp.php";
require_once ENTRY_PATH."/app/data/widget/widgetInfo.php";
require_once ENTRY_PATH."/app/widgets/table/widget_table.php";
require_once ENTRY_PATH."/app/widgets/spancalc/widget_spancalc.php";
require_once ENTRY_PATH."/app/widgets/calc/widget_calc.php";
require_once ENTRY_PATH."/app/widgets/html/widget_html.php";
require_once ENTRY_PATH."/app/data/node/nodeInfo.php";
class nodeleafModule{
	/**
	 * @var identityToken
	 */
	private $idtoken;
	public function __construct(){
		$this->idtoken = tian::$context->getIdentityToken();
	}


	public function allLeaves(){
		$this->helper = new nodeInfo("/");
		return $this->helper->getAllLeaves();
	}
	public function checkNodeExists($np){
		try{
			new nodeInfo($np);
			return true;			
		}catch (Exception $e){
			return false;
		}

	}
	/**
	 * 
	 * @param string $typeid
	 * @return string widget type or empty string
	 */
	public static function ti2wt($typeid){
		switch ($typeid){
			case "table_22tp":
			case "table_23tpe":
			case "table_22ap":
			case "table_23ldp":
			case "table_22ld":
			case "table_hot":
				return "table";
			case "spancalc_23ldp":
			case "spancalc_22ld":
				return "spancalc";
			case "calc_22ap":
				return "calc";
			case "html":
				return "html";
			default:
				return "";
		}
	}
}