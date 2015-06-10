<?php
/**
 * Date: 2014-10-14
 * Author: Awei.tian
 * function: 
 */
require_once dirname(dirname(__FILE__))."/privilege.php";
require_once dirname(dirname(dirname(__FILE__)))."/widgets/uiconfigOp.php";
require_once dirname(dirname(dirname(__FILE__)))."/datasrc/DataSrcPath.php";
require_once dirname(dirname(dirname(__FILE__)))."/datasrc/path2sid.php";
class privConf extends privilege{
	private $tpl;
	private $pgloc;
	private $wtypeid;
	private $nssid;
	public $action = "/sea/debug.php?p=/test/priv_conf/update";
	public $path2sid;
	/**
	 * @var pathDeco
	 */
	public $pathDeco;
	public function __construct(){
		$this->tpl =  ENTRY_PATH."/app/privilege/conf/tpl";
		$this->path2sid = new path2sid();
	}
	public function ui($pgloc,$wtypeid,$wsrcpath,$conf,$comment=""){
		switch ($wtypeid){
			case "table":
			case "calc":
			case "spancalc":
				break;
			default:
				throw new Exception("invalid widget type id");
		}
		$this->action = $action;
		$this->wtypeid = $wtypeid;
		$datasrcpath = new DataSrcPath($wsrcpath);
		if($datasrcpath->getPathMode() != DataSrcPath::DATASRC_MODE){
			throw new Exception("invalid datasrc path");
		}
		$dstypeid = $datasrcpath->getDatasrcTypeId();
		$nssid = $this->path2sid->getNssidByPath($datasrcpath->getNodePath()."#".$datasrcpath->getNameSpaceId());
		$this->nssid = $nssid;
		switch ($dstypeid) {
			case "22ap":
				if($wtypeid == "table"){
					return $this->_conf_table_22ap();
				}else{
					return $this->_conf_calc_22ap();
				}
			case "23ldp":
				if($wtypeid == "table"){
					return $this->_conf_table_23ldp();
				}else{
					return $this->_conf_spancalc_23ldp();
				}
			case "22tp":
				return $this->_conf_table_22tp();
			case "23tpe":
				return $this->_conf_table_23tpe();
			default:
				throw new Exception("invalid args.");
				break;
		}
	}
	/**
	 * add without data
	 * update on had data
	 */
	public function update($pgloc,$wtypeid,$wsrcpath,$conf,$comment=""){
		
	}
	private function _conf_table_22ap(){
		$path = $this->tpl."/".$this->wtypeid."/22ap.tpl";
		return strtr(file_get_contents($path), array(
			"{action}" => $this->action,
			"{widgetsid}"
				
		));
	}
	private function _conf_calc_22ap(){
		
	}
	private function _conf_table_23ldp(){
		
	}
	private function _conf_spancalc_23ldp(){
		
	}
	private function _conf_table_22tp(){
		
	}
	private function _conf_table_23tpe(){
		
	}
}