<?php
/**
 * @author:awei.tian
 * @date: 2014-11-24
 * @functions:
 */
require_once API_PATH."/aApi.php";
require_once DATA_PATH."/datakey/datakeyInfo.php";
require_once DATA_PATH."/datakey/datakeyOp.php";
require_once ENTRY_PATH."/app/data/datasrc/DataSrcPath.php";
require_once ENTRY_PATH.'/app/api/privilege/data/datasrc/datasrc22apApi.php';
require_once ENTRY_PATH.'/app/api/privilege/data/datasrc/datasrc22ldApi.php';
require_once ENTRY_PATH.'/app/api/privilege/data/datasrc/datasrc22tpApi.php';
require_once ENTRY_PATH.'/app/api/privilege/data/datasrc/datasrc23ldpApi.php';
require_once ENTRY_PATH.'/app/api/privilege/data/datasrc/datasrc23tpeApi.php';
require_once ENTRY_PATH.'/app/api/privilege/data/datasrc/datasrchtmlApi.php';
require_once ENTRY_PATH.'/app/api/privilege/data/datasrc/datasrchotApi.php';
require_once ENTRY_PATH.'/app/api/privilege/data/datasrc/datasrcofhintApi.php';
require_once ENTRY_PATH.'/app/data/datasrc/dataSrc.php';
class datasrcApi extends aApi{
	private $helper;
	/**
	 * @var DataSrcPath
	 */
	private $datasrc;
	public function __construct(){
		
	}
	/**
	 * @return bool
	 * @see IApi::invoke()
	 */
	public function invoke(){
		if($this->isGet()){
			return $this->_list();
		}else if($this->isPost()){
			return $this->_add();
		}else if($this->isPut()){
			return $this->_update();
		}else if($this->isDelete()){
			return $this->_remove();
		}
	}
	/**
	 * path
	 */
	private function _list(){
		if(isset($this->args["path"])){
//			var_dump($this->args["path"]);exit;
			$this->datasrc = new DataSrcPath($this->args["path"]);
			$this->helper = new datakeyInfo($this->datasrc->getDatakeyPath());
			$tmp = $this->helper->getInfo();
			$dstype = $tmp["dstype"];
			$cls = "datasrc".$dstype."Api";
			$this->helper = new $cls();
			$this->helper->setMethod("get");
			$this->helper->setArgs($this->args);
			return array(
				"data"=>$this->helper->invoke(),
				"type"=>$dstype
			);
		}else{
			throw new Exception("invalid path", 0x15);			
		}
	}
	/**
	 * path
	 * @return number >0 ok
	 */
	private function _add(){
		//var_dump($this->args);exit;
		if(!isset($this->args["path"])){
			throw new Exception("invalid args: path", 0x1);
		}
		if(!isset($this->args["dstype"])){
			throw new Exception("invalid args: dstype", 0x2);
		}
		if(!array_key_exists($this->args["dstype"], dataSrc::$typeArr)){
			throw new Exception("invalid args: dstype", 0x2);
		}
		if(!isset($this->args["data"])){
			throw new Exception("invalid args: data", 0x3);
		}
		$cls = "datasrc".$this->args["dstype"]."Api";
//		var_dump($cls);exit();
		$this->helper = new $cls();
		$this->helper->setMethod("post");
		$this->helper->setArgs($this->args);
		return $this->helper->invoke();
	}
	private function _update(){
		if(!isset($this->args["path"])){
			throw new Exception("invalid args: path", 0x1);
		}
		if(!isset($this->args["dstype"])){
			throw new Exception("invalid args: dstype", 0x2);
		}
		if(!array_key_exists($this->args["dstype"], dataSrc::$typeArr)){
			throw new Exception("invalid args: dstype", 0x2);
		}
		if(!isset($this->args["data"])){
			throw new Exception("invalid args: data", 0x3);
		}
		$cls = "datasrc".$this->args["dstype"]."Api";
		$this->helper = new $cls();
		$this->helper->setMethod("put");
		$this->helper->setArgs($this->args);
		return $this->helper->invoke();
	}
	private function _remove(){
		if(!isset($this->args["path"])){
			throw new Exception("invalid args: path", 0x1);
		}
		if(!isset($this->args["dstype"])){
			throw new Exception("invalid args: dstype", 0x2);
		}
		if(!array_key_exists($this->args["dstype"], dataSrc::$typeArr)){
			throw new Exception("invalid args: dstype", 0x2);
		}
		$cls = "datasrc".$this->args["dstype"]."Api";
		$this->helper = new $cls();
		$this->helper->setMethod("delete");
		$this->helper->setArgs($this->args);
		return $this->helper->invoke();
	}
}