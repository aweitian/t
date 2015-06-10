<?php
/**
 * @Author:tanxun
 * @Date:2014��3��18��
 *
 */
 class blacklistApi{
 	private $_args;
	private $_method;
	private $_url;
	private $config;
	/**
	 * @var IDb
	 */
	private $db;
	/**
	 * @var IPdoBase 
	 */
	private $pdo;
	public function __construct(){
		$this->db=tian::$context->getDb();
		$this->pdo=$this->db->getPdoBase();
//		exec,insert,fetch,fetchall
	}
	public function invoke(){
		if($this->_method!="get"){
			return $this->_failRet("invalid method");
		}
		if(!isset($this->_args["ip"])){
			$ip=$this->_args["ip"];
		}
		if(!isset($this->_args["label"])){
			$label=$this->_args["label"];
		}
		$pdo=tian::$context->getDb()->getPdoBase(); 
		$time=date('Y-m-d');
		$ret=$pdo->fetchAll("select * from blacklist where date=:date and ip=:ip and label=:label", array("date"=>$time,"ip"=>$this->args["ip"],"label"=>$this->args["label"]));
		$count=count($ret);
		return $this->_okRet($count);
	}
	
	public function add(){
		if($this->_method!="post"){
			return $this->_failRet("invalid method");
		}
		if(!isset($this->_args["ip"])){
			$ip=$this->_args["ip"];
		}
		if(!isset($this->_args["label"])){
			$label=$this->_args["label"];
		}
		$pdo=tian::$context->getDb()->getPdoBase(); 
		$time=date('Y-m-d');
		$count=$pdo->fetchAll("insert blacklist (label,ip,date) values (:label,:ip,:date)", array("label"=>$this->args["label"],"ip"=>$this->args["ip"],"date"=>$time));
		if($count>0){
		return $this->_okRet($count);
		}
		else{
		return $this->_failRet($count);	
		}
	}
	
 	public function setArgs($args){
		$this->_args=$args;
	}
	public function setMethod($method){
		$this->_method=$method;
	}
	public function setUrl($url){
		$this->_url=$url;
	}
 
	
	private function _failRet($message){
		return json_encode(array("msg"=>"no","message"=>$message));
	}
	private function _okRet($cnt){
		return json_encode(array("msg"=>"ok","message"=>$cnt));
	}
 	
 }
 
?>
