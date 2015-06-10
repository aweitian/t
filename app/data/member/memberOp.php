<?php
/**
 * Date: 2015-1-6
 * Author: Awei.tian
 * function: 
 */
require_once dirname(__FILE__)."/memberOpValidator.php";
class memberOp{
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
	public function add($email,$nknme,$pswod,$fname,$lname,$squst,$sqkey,$phone,$mssnn,$aimmm,$yahoo){
		if(!memberOpValidator::isValidEml($email)){
			throw new Exception("invalid email",0x1);
		}
		if(!memberOpValidator::isValidSqust($squst)){
			throw new Exception("invalid security question",0x1);
		}
		if(!memberOpValidator::isValidSqkey($sqkey)){
			throw new Exception("invalid security answer",0x1);
		}
		if(!memberOpValidator::isValidPwd($pswod)){
			throw new Exception("password length must be over 3 chars",0x1);
		}

		$sid = $this->pdo->insert("insert into `tny_member` (
			`member_email`,`member_nknme`,`member_pswod`,`member_fname`,`member_lname`,`member_squst`,`member_sqkey`,`member_phone`,`member_mssnn`,`member_aimmm`,`member_yahoo`
		) values (
			:member_email,:member_nknme,:member_pswod,:member_fname,:member_lname,:member_squst,:member_sqkey,:member_phone,:member_mssnn,:member_aimmm,:member_yahoo
		)",array(
			"member_email"=>$email,
			"member_nknme"=>$nknme,
			"member_pswod"=>app::calcPwd($pswod),
			"member_fname"=>$fname,
			"member_lname"=>$lname,
			"member_squst"=>$squst,
			"member_sqkey"=>$sqkey,
			"member_phone"=>$phone,
			"member_mssnn"=>$mssnn,
			"member_aimmm"=>$aimmm,
			"member_yahoo"=>$yahoo,
		));
		if($sid>0){
			return $sid;
		}
		$info = $this->pdo->getErrorInfo();
		throw new Exception($info[2],$info[0]);
	}
	/**
	 * @return 返回影响的行数
	 * @param string $sid
	 * @throws Exception
	 */
	public function removeBySid($sid){
		return $this->pdo->exec("delete from `tny_member` where `id`=:id", array(
			"id"=>$sid
		));
	}
	public function removeByEml($eml){
		return $this->pdo->exec("delete from `tny_member` where `member_email`=:eml", array(
				"eml"=>$eml
		));
	}
	
	public function updatePwdByEml($eml,$oldpwd,$newpwd){
		$row = $this->pdo->exec("update `tny_member` set `member_pswod` = :nwpwd
				where `member_pswod`=:oldpwd and `member_email`=:eml", array(
			"nwpwd" => app::calcPwd($newpwd),
			"oldpwd" => app::calcPwd($oldpwd),
			"eml" => $eml
		));
		return $row;
	}
	public function resetPwd($sid,$newpwd){
		$row = $this->pdo->exec("update `tny_member` set `member_pswod` = :nwpwd
				where `id`=:sid", array(
			"nwpwd" => app::calcPwd($newpwd),
			"sid" => $sid
		));
		return $row;
	}
	
	public function update($email,$nknme,$fname,$lname,$squst,$sqkey,$phone,$mssnn,$aimmm,$yahoo){
		return $this->pdo->exec("update `tny_member` set
			`member_nknme`=:member_nknme,
			`member_fname`=:member_fname,
			`member_lname`=:member_lname,
			`member_squst`=:member_squst,
			`member_sqkey`=:member_sqkey,
			`member_phone`=:member_phone,
			`member_mssnn`=:member_mssnn,
			`member_aimmm`=:member_aimmm,
			`member_yahoo`=:member_yahoo
		where `member_email`=:member_email
		", array(
			"member_email"=>$email,
			"member_nknme"=>$nknme,
			"member_fname"=>$fname,
			"member_lname"=>$lname,
			"member_squst"=>$squst,
			"member_sqkey"=>$sqkey,
			"member_phone"=>$phone,
			"member_mssnn"=>$mssnn,
			"member_aimmm"=>$aimmm,
			"member_yahoo"=>$yahoo,
		));
	}
	
	public function updateEml($sid,$pwd,$eml){
		return $this->pdo->exec("update `tny_member` set `member_email`=:eml 
				where `id` = :sid and `member_pswod` = :pwd", array(
			"sid"=>$sid,
			"eml"=>$eml,
			"pwd"=>app::calcPwd($pwd)
		));
	}
	
	public function updatePwdBySk($eml,$q,$a,$nwpwd){
		return $this->pdo->exec("update `tny_member` set `member_pswod`=:pwd
				where `member_email` = :eml and `member_squst` = :q and `member_sqkey`=:a", array(
				"eml"=>$eml,
				"q"=>$q,
				"a"=>$a,
				"pwd"=>app::calcPwd($nwpwd)
		));
	}
	public function updateCnsm($eml,$cnsm){
		return $this->pdo->exec("update `tny_member` set `member_cnsum`=:cnsm
				where `member_email` = :eml", array(
				"eml"=>$eml,
				"cnsm"=>$cnsm,
		));
	}
	public function updateCnsmRankVid($eml,$cnsm,$rank,$vid){
		return $this->pdo->exec("update `tny_member` 
				set 
				`member_cnsum`=:cnsm,
				`member_ranks`=:rank,
				`member_vipid`=:vid
				where `member_email` = :eml", array(
				"eml"=>$eml,
				"cnsm"=>$cnsm,
				"rank"=>$rank,
				"vid"=>$vid,
		));
	}
}