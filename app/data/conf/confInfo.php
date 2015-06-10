<?php
/**
 * Date: 2014-12-1
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/datasrc/pathDbHelper.php";
require_once ENTRY_PATH."/app/data/datasrc/DataSrcPath.php";
require_once ENTRY_PATH."/app/data/conf/base/conf.php";
class confInfo{
	/**
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
	public $dataSrcPath;
	/**
	 * @var pathDbHelper
	 */
	public $pathDbHelper;
	private $helper;
	public function __construct(){
		$this->_initdb();
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}
	/**
	 *
	 * @return bool
	 * @param string path
	 * @param data
	 */
	public function getConf($path){
//		var_dump($path);exit;
		$this->dataSrcPath = new DataSrcPath($path);
		$this->pathDbHelper = new pathDbHelper();
		if($this->dataSrcPath->getPathMode()!=DataSrcPath::DATA_MODE){
			throw new Exception("invalid path mode",0x52);
		}
		$confkey_metadata = $this->pathDbHelper->getConfInfoByPath($path);
		if(!array_key_exists($confkey_metadata["typeid"],conf::$typeArr)){
			throw new Exception("invalid path", "0x9");
		}
		require_once ENTRY_PATH."/app/data/conf/op/".$confkey_metadata["typeid"]."Info.php";
		$cls = $confkey_metadata["typeid"]."Info";
		$this->helper = new $cls($path);
		return array("type"=>$confkey_metadata["typeid"],"conf"=>$this->helper->getConf());
	}
}