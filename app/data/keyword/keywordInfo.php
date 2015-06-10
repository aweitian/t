<?php
/**
 * Date: 2015-1-6
 * Author: Awei.tian
 * function: 
 */
class keywordInfo{
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
	public function rowNum(){
		$row = $this->pdo->fetch("select count(`sid`) as c from `tny_keyword`", array(
		));
		return $row["c"];
	}
	public function all($offset,$len){
		$row = $this->pdo->fetchAll("select * from `tny_keyword` limit :offset,:len", array(
				"offset"=>$offset,
				"len"=>$len
		));
		return $row;
	}
	public function infoById($sid){
		$row = $this->pdo->fetch("select * from `tny_keyword` where `sid`=:sid", array(
				"sid"=>$sid
		));
		return $row;
	}
	public function getOriByAlias($als){
		$row = $this->pdo->fetch("select `ori` from `tny_keyword` where `als`=:als", array(
				"als"=>$als
		));
		return $row;
	}
	public function getAliasByOri($ori){
		$row = $this->pdo->fetch("select `als` from `tny_keyword` where `ori`=:ori", array(
				"ori"=>$ori
		));
		return $row;
	}
}