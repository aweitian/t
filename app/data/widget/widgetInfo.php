<?php
/**
 * Date: 2014-9-26
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/datasrc/pathDbHelper.php";
class widgetInfo{
	/**
	 *
	 * @var IDb
	 */
	public $db;
	/**
	 * @var IPdoBase
	 */
	public $pdo;
	/**
	 * @var DataSrcPath
	 */
	public $nodepath;
	
	public function __construct(){
		$this->_initdb();
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}
	public function getInfo($nodepath,$order){
		$row = $this->pdo->fetch("
		SELECT `tny_fs_widget_struct`.`nsid`,
			`tny_fs_widget_struct`.`order`,
			`tny_fs_widget_struct`.`typeid`,
			`tny_fs_widget_struct`.`dksid`,
			`tny_fs_widget_struct`.`confid`,
			`tny_fs_widget_struct`.`ordertpl`,
			`tny_fs_widget_struct`.`comment`
			FROM `tny_fs_widget_struct`
			LEFT JOIN `tny_fs_node_struct` ON `tny_fs_node_struct`.`sid` = `tny_fs_widget_struct`.`nsid`
			WHERE `tny_fs_node_struct`.`path` = :nodepath
			AND `tny_fs_widget_struct`.`order` = :order
		", array(
			"nodepath"=>$nodepath,
			"order"=>$order
		));
		if(empty($row))return $row;
		$helper = new pathDbHelper();
		try{
			$datasrcpath = $helper->getPathByDksid($row["dksid"]);
		}catch (Exception $e){
			$datasrcpath = "";
		}
		try{
			$confpath = $helper->getPathByCfsid($row["confid"]);
		}catch (Exception $e){
			$confpath = "";
		}
		$row["datasrcpath"] = $datasrcpath;
		$row["confpath"]    = $confpath;
		
		return $row;
	}
	public function getWidgets($nodepath){
		$row = $this->pdo->fetchAll("
		SELECT `tny_fs_widget_struct`.`nsid`,
			`tny_fs_widget_struct`.`order`,
			`tny_fs_widget_struct`.`typeid`,
			`tny_fs_widget_struct`.`dksid`,
			`tny_fs_widget_struct`.`confid`,
			`tny_fs_widget_struct`.`ordertpl`,
			`tny_fs_widget_struct`.`comment`
			FROM `tny_fs_widget_struct`
			LEFT JOIN `tny_fs_node_struct` ON `tny_fs_node_struct`.`sid` = `tny_fs_widget_struct`.`nsid`
			WHERE `tny_fs_node_struct`.`path` = :nodepath
			ORDER BY `tny_fs_widget_struct`.`order` ASC
		", array(
			"nodepath"=>$nodepath,
		));
		if(empty($row))return $row;
		$helper = new pathDbHelper();
		foreach ($row as &$item){
			try{
				$datasrcpath = $helper->getPathByDksid($item["dksid"]);
			}catch (Exception $e){
				$datasrcpath = "";
			}
			try{
				$confpath = $helper->getPathByCfsid($item["confid"]);
			}catch (Exception $e){
				$confpath = "";
			}
			$item["datasrcpath"] = $datasrcpath;
			$item["confpath"]    = $confpath;
		}
		return $row;
	}
	public function getMaxOrder($nodepath){
		$row = $this->pdo->fetch("
		SELECT MAX(`tny_fs_widget_struct`.`order`) as o
			FROM `tny_fs_widget_struct`
			LEFT JOIN `tny_fs_node_struct` ON `tny_fs_node_struct`.`sid` = `tny_fs_widget_struct`.`nsid`
			WHERE `tny_fs_node_struct`.`path` = :nodepath
		", array(
						"nodepath"=>$nodepath,
				));
		if(empty($row))return 1;
		if(is_null($row["o"]))return 1;
		return $row["o"];
	}
	public function exists($nodepath){
		$row = $this->pdo->fetch("SELECT * FROM tny_fs_node_struct WHERE  `path` = :nodepath", array(
				"nodepath"=>$nodepath,
		));
		if(empty($row)){
			return false;
		}
		return true;
	}
}