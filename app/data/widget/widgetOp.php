<?php
/**
 * Date: 2014-10-17
 * Author: Awei.tian
 * function: 
 */
require_once dirname(__FILE__)."/widgetInfo.php";
require_once dirname(__FILE__)."/widgetOpRegexp.php";
require_once ENTRY_PATH."/app/data/datasrc/pathDbHelper.php";
require_once ENTRY_PATH."/app/data/conf/base/conf.php";
class widgetOp{
	/**
	 *
	 * @var IDb
	 */
	public $db;
	/**
	 * @var IPdoBase
	 */
	public $pdo;


	public function __construct(){
		$this->_initdb();
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}
	/**
	 * @return npsid
	 */
	public function add($path,$order,$typeid,$datasrcpath,$confpath,$ordertpl,$comment){
		$helper = new pathDbHelper();
		
		$nsid = $helper->getNsidByPath($path);
		$dkrow = $helper->getDatakeyInfoByPath($datasrcpath);
		$cfrow = $helper->getConfInfoByPath($confpath);
		$dksid = $dkrow["sid"];
		$cfsid = $cfrow["sid"];
		if(!array_key_exists($typeid, conf::$typeArr)){
			throw new Exception("invalid typeid", 0x785214);
		}
		if(!widgetOpRegexp::isMatchedTDC($typeid,$dkrow["dstype"],$cfrow["typeid"])){
			throw new Exception("types are not matched.", 0x7854);
		}
		$insertid = $this->pdo->insert("insert into `tny_fs_widget_struct`
		(`nsid`,`order`,`typeid`,`dksid`,`confid`,`ordertpl`,`comment`) 
		values 
		(:nsid,:order,:typeid,:dksid,:confid,:ordertpl,:comment)", array(
			"nsid"=>$nsid,
			"order"=>$order,
			"typeid"=>$typeid,
			"dksid"=>$dksid,
			"confid"=>$cfsid,
			"ordertpl"=>$ordertpl,
			"comment"=>$comment
		));
		return $insertid;
	}
	/**
	 * @return 返回影响的行数
	 * @param unknown $nodepath
	 * @param unknown $name
	 * @throws Exception
	 */
	public function update($path,$oldorder,$neworder,$typeid,$datasrcpath,$confpath,$ordertpl,$comment){
		$helper = new pathDbHelper();
		
		$nsid = $helper->getNsidByPath($path);
		$dkrow = $helper->getDatakeyInfoByPath($datasrcpath);
		$cfrow = $helper->getConfInfoByPath($confpath);
		$dksid = $dkrow["sid"];
		$cfsid = $cfrow["sid"];
		if(!array_key_exists($typeid, conf::$typeArr)){
			throw new Exception("invalid typeid", 0x785214);
		}
		if(!widgetOpRegexp::isMatchedTDC($typeid,$dkrow["dstype"],$cfrow["typeid"])){
			throw new Exception("types are not matched.", 0x7854);
		}
		$row = $this->pdo->exec("update `tny_fs_widget_struct`
		set 
		`order`=:new_order,
		`typeid`=:typeid,
		`dksid`=:dksid,
		`confid`=:confid,
		`ordertpl`=:ordertpl,
		`comment`=:comment
		where 
		`nsid`=:nsid and
		`order`=:old_order", array(
			"nsid"=>$nsid,
			"new_order"=>$neworder,
			"old_order"=>$oldorder,
			"typeid"=>$typeid,
			"dksid"=>$dksid,
			"confid"=>$cfsid,
			"ordertpl"=>$ordertpl,
			"comment"=>$comment
		));
		return $row;	
	}
	/**
	 * @return 返回影响的行数
	 * @param unknown $nodepath
	 * @throws Exception
	 */
	public function remove($path,$order){
		$helper = new pathDbHelper();
		$nsid = $helper->getNsidByPath($path);
		$row = $this->pdo->exec("delete from `tny_fs_widget_struct` where `nsid`=:nsid and
		`order`=:order", array(
			"nsid"=>$nsid,
			"order"=>$order,
		));
		return $row;
	}
}