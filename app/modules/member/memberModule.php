<?php
/**
 * Date: 2015-1-23
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/interfaces/IOp.php";
require_once ENTRY_PATH."/app/data/member/memberInfo.php";
require_once ENTRY_PATH."/app/data/member/memberOp.php";
require_once ENTRY_PATH."/app/data/oplog/oplogInfo.php";
require_once ENTRY_PATH."/app/data/oplog/oplogOp.php";
class memberModule implements IOp{
	private $conf;
	/**
	 * @var identityToken
	 */
	private $idtoken;
	private $opsid;
	private $oplog;
	public $errorMsg;
	public $remain_times = 0;
	public function __construct(){
		$this->conf = require ENTRY_PATH."/app/conf/member.php";
		$this->idtoken = tian::$context->getIdentityToken();
	}

	/**
	 * 
	 * @param string $email
	 * @param string $nknme
	 * @param string $pswod
	 * @param string $fname
	 * @param string $lname
	 * @param string $squst
	 * @param string $sqkey
	 * @param string $phone
	 * @param string $mssnn
	 * @param string $aimmm
	 * @param string $yahoo
	 * @return boolean
	 */
	public function register($email,$nknme,$pswod,$fname,$lname,$squst,$sqkey,$phone,$mssnn,$aimmm,$yahoo){
		$this->remain_times = $this->getRemainTryTimes();
		if($this->remain_times<=0){
			$this->errorMsg="Exceed Max Register times.";
			return false;
		}
		$this->opStart();
		$mop = new memberOp();
		try{
			$mop->add($email, $nknme, $pswod, $fname, $lname, $squst, $sqkey, $phone, $mssnn, $aimmm, $yahoo);
			$this->opUpdate();
			return true;
		}catch (Exception $e){
			if($e->getCode() == 23000){
				$this->errorMsg = "You typed email has been token";
				return false;
			}else{
				$this->errorMsg = $e->getMessage();
			}
			return false;
		}
	}
	public function getRemainTryTimes(){
		return $this->conf["max_register_times"] - $this->getOPFailCnt();
	}
	public function getOpType(){
		return "member_register";
	}
	public function opStart(){
		$this->oplog = new oplogOp();
		$this->opsid = $this->oplog->add($this->getOpType(), $this->idtoken->getIp());
	}
	public function opUpdate(){
		if($this->opsid){
			$this->oplog->update($this->opsid);
		}
	}
	public function getOPFailCnt(){
		$priv = new oplogInfo();
		return $priv->getCnt($this->getOpType(), $this->idtoken->getIp());
	}
}