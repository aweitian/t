<?php
/**
 * Date: 2015-1-23
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/interfaces/IOp.php";
require_once ENTRY_PATH."/app/data/order/orderInfo.php";
require_once ENTRY_PATH."/app/data/order/orderOp.php";
require_once ENTRY_PATH."/app/data/oplog/oplogInfo.php";
require_once ENTRY_PATH."/app/data/oplog/oplogOp.php";
require_once ENTRY_PATH."/app/data/widget/widgetInfo.php";
class orderModule implements IOp{
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
		$this->conf = require ENTRY_PATH."/app/conf/order.php";
		$this->idtoken = tian::$context->getIdentityToken();
	}
	
	
	
	public function getRemainTryTimes(){
		return $this->conf["max_order_subscribe_times"] - $this->getOPFailCnt();
	}
	public function getOpType(){
		return "order_subscribe";
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