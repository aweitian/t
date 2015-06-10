<?php
/**
 * Date: 2015-1-6
 * Author: Awei.tian
 * function: 
 */
class newsInfo{
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
	public function info($sid){
		return $this->pdo->fetch("select *
			from `tny_news` where `sid`=:sid", array(
				'sid'=>$sid,
		));
	}
	public function getSlideData(){
		$row = $this->pdo->fetchAll("select * from `tny_news`
				where
				`sldflg` = 1 and `sldimg` != ''
				order by `sldorder` DESC
				limit 0,10
		", array(
		));
		return $row;
	}
	public function all($offset,$len){
		$row = $this->pdo->fetch("select count(sid) as cnt from `tny_news` where 1", array());
		$cnt = $row["cnt"];
		if($cnt != 0){
			$data = $this->pdo->fetchAll("select * 
					from `tny_news` where 1 order by 
					`sldflg` DESC, `sldorder` DESC,`date` DESC
					 limit :offset,:length", array(
					'offset'=>(int)$offset,
					'length'=>(int)$len
			));
		}else{
			$data = array();
		}
		return array(
			"cnt"=>$cnt,
			"data"=>$data
		);
	}
}