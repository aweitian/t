<?php
/**
 * Date: 2015-1-6
 * Author: Awei.tian
 * function: 
 */
require_once dirname(__FILE__)."/newsOpValidator.php";
class newsOp{
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
	 * @return nsid
	 */
	public function add($title,$content,$lnk,$sldimg,$sldflg,$sldorder){
		if(!newsOpValidator::isValidTitle($title)){
			throw new Exception("invalid title",0x1);
		}
		if(!newsOpValidator::isValidContent($content)){
			throw new Exception("invalid content",0x1);
		}
		if(!newsOpValidator::isValidLnk($lnk)){
			throw new Exception("invalid link",0x1);
		}
		if(!newsOpValidator::isValidSlideImg($sldflg, $sldimg)){
			throw new Exception("invalid slide image",0x1);
		}
		if(!newsOpValidator::isValidSlideOrder($sldorder)){
			throw new Exception("invalid order",0x1);
		}
		$sid = $this->pdo->insert("insert into `tny_news` (
			`title`,`content`,`lnk`,`sldimg`,`sldflg`,`sldorder`,`date`
		) values (
			:title,:content,:lnk,:sldimg,:sldflg,:sldorder,:date
		)",array(
			"title"=>$title,
			"content"=>$content,
			"lnk"=>$lnk,
			"sldimg"=>$sldimg,
			"sldflg"=>$sldflg,
			"sldorder"=>$sldorder,
			"date"=>date("Y-m-d"),
		));
		if($sid>0){
			return $sid;
		}
		$info = $this->pdo->getErrorInfo();
		throw new Exception($info[2],$info[0]);
	}
	public function remove($sid){
		return $this->pdo->exec("DELETE FROM `tny_news` WHERE `sid`=:sid", array(
			"sid"=>$sid
		));
	}
	public function trunOnFlag($sid){
		return $this->pdo->exec("update `tny_news` set `sldflg` = 1 WHERE `sid`=:sid", array(
			"sid"=>$sid
		));
	}
	public function trunOffFlag($sid){
		return $this->pdo->exec("update `tny_news` set `sldflg` = 0 WHERE `sid`=:sid", array(
			"sid"=>$sid
		));
	}
	public function update($sid,$title,$content,$lnk,$sldimg,$sldflg,$sldorder){
		$row = $this->pdo->exec("update `tny_news` set
			`title`=:title,
			`content`=:content,
			`lnk`=:lnk,
			`sldimg`=:sldimg,
			`sldflg`=:sldflg,
			`sldorder`=:sldorder
			where `sid` = :sid	
		",array(
			"title"=>$title,
			"content"=>$content,
			"lnk"=>$lnk,
			"sldimg"=>$sldimg,
			"sldflg"=>$sldflg,
			"sldorder"=>$sldorder,
			"sid"=>$sid
		));
		if($row>0){
			return $row;
		}
		$info = $this->pdo->getErrorInfo();
		throw new Exception($info[2],$info[0]);
	}
}