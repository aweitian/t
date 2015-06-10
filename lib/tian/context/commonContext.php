<?php
/**
 * @author awei.tian
 * date: 2013-9-17
 * 说明:上下文环境，在有的框架中这叫application
 * 我觉得到context更好点
 * 它实现框架逻辑，也是插件的注册点
 */
require_once LIB_PATH.'/context/AContext.php';
class commonContext extends AContext{
	public function __construct(){
		require_once  LIB_PATH."/log/fileLog.php";
		require_once LIB_PATH.'/kv/mysql/mysqlkv.php';
		$this->loadView();
		$this->loadModel();
	}

	public function getCache(){
		
	}
	public function loadModel(){
		C::addAutoloadPath("model", LIB_PATH."/mvc/model/model.php");
	}
	public function loadView(){
		C::addAutoloadPath("view", LIB_PATH."/mvc/view/commonview.php");
	}
	public function getDb(){
		require_once LIB_PATH."/db/commonDb.php";
		if(is_null($this->db)){
			$this->db=new commonDb();
		}
		return $this->db;
	}
	public function getKv(){
		if(is_null($this->kv)){
			$this->kv=new mysqlKv();
		}
		return $this->kv;
	}
	public function loadLog(){
		C::addAutoloadPath("view", LIB_PATH."/log/fileLog.php");
	}
}