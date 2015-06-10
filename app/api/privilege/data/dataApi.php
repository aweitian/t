<?php
/**
 * @author:awei.tian
 * @date: 2014-11-24
 * @functions:return datasrc_nsdata
 */
require_once API_PATH."/aApi.php";
require_once DATA_PATH."/datakey/datakeyInfo.php";
require_once DATA_PATH."/datakey/datakeyOp.php";
require_once ENTRY_PATH."/app/data/datasrc/DataSrcPath.php";
require_once ENTRY_PATH.'/app/data/datasrc/DataSrc_nsdata.php';
require_once ENTRY_PATH.'/app/data/datasrc/op/datasrc_nsdataInfo.php';
class dataApi extends aApi{
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
			return 0;
		}else if($this->isPut()){
			return 0;
		}else if($this->isDelete()){
			return 0;
		}
	}
	/**
	 * path
	 */
	private function _list(){
		if(isset($this->args["path"])){
//			var_dump($this->args["path"]);exit;
			$this->datasrc = new DataSrcPath($this->args["path"]);
			if($this->datasrc->getPathMode() != DataSrcPath::DATA_MODE){
				throw new Exception("path should be data mode", 0x2);
			}
			$this->helper = new datasrc_nsdataInfo($this->args["path"]."/");
			return $this->helper->getData();
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