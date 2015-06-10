<?php
/**
 * @Author:aweitian
 * @Date:2014-10-15
 *
 */
class privilegeController extends authenticateControllerRest {
	public static function _checkPrivilege(message $msg,identityToken $it){
		return true;
	}
	public function nodeAction(Message $msg) {
		$this->_restInvoke("/privilege/data/nodeApi");
	}
	public function nodeTypeAction(Message $msg) {
		$this->_restInvoke("/privilege/data/typeApi");
	}
	public function nodeLabelAction(Message $msg) {
		$this->_restInvoke("/privilege/data/labelApi");
	}
	public function dataKeysAction(Message $msg) {
		$this->_restInvoke("/privilege/data/dataKeysApi");
	}
	public function namespaceAction(Message $msg) {
		$this->_restInvoke("/privilege/data/namespaceApi");
	}
	public function datasrc22apAction(Message $msg) {
		$this->_restInvoke("/privilege/data/datasrc/datasrc22apApi");
	}
	public function datasrc22ldAction(Message $msg) {
		$this->_restInvoke("/privilege/data/datasrc/datasrc22ldApi");
	}
	public function datasrc22tpAction(Message $msg) {
		$this->_restInvoke("/privilege/data/datasrc/datasrc22tpApi");
	}
	public function datasrc23ldpAction(Message $msg) {
		$this->_restInvoke("/privilege/data/datasrc/datasrc23ldpApi");
	}
	public function datasrc23ltpeAction(Message $msg) {
		$this->_restInvoke("/privilege/data/datasrc/datasrc23tpeApi");
	}
	public function datasrchotAction(Message $msg) {
		$this->_restInvoke("/privilege/data/datasrc/datasrchotApi");
	}
	public function datasrchtmlAction(Message $msg) {
		$this->_restInvoke("/privilege/data/datasrc/datasrchtmlApi");
	}
	public function confkeyAction(Message $msg) {
		$this->_restInvoke("/privilege/data/confkeyApi");
	}
	public function confcalc22apAction(Message $msg) {
		$this->_restInvoke("/privilege/data/conf/confcalc22apApi");
	}
	public function confspancalc22ldAction(Message $msg) {
		$this->_restInvoke("/privilege/data/conf/confspancalc22ldApi");
	}
	public function confspancalc23ldpAction(Message $msg) {
		$this->_restInvoke("/privilege/data/conf/confspancalc23ldpApi");
	}
	public function conftable22apAction(Message $msg) {
		$this->_restInvoke("/privilege/data/conf/conftable22apApi");
	}
	public function conftable22ldAction(Message $msg) {
		$this->_restInvoke("/privilege/data/conf/conftable22ldApi");
	}
	public function conftable22tpAction(Message $msg) {
		$this->_restInvoke("/privilege/data/conf/conftable22tpApi");
	}
	public function conftable23ldpAction(Message $msg) {
		$this->_restInvoke("/privilege/data/conf/conftable23ldpApi");
	}
	public function conftable23tpeAction(Message $msg) {
		$this->_restInvoke("/privilege/data/conf/conftable23tpeApi");
	}
	public function conftablehotAction(Message $msg) {
		$this->_restInvoke("/privilege/data/conf/conftablehotApi");
	}
	public function confAction(Message $msg) {
		$this->_restInvoke("/privilege/data/confApi");
	}
	public function widgetAction(Message $msg) {
		$this->_restInvoke("/privilege/data/widgetApi");
	}
	public function datasrcAction(Message $msg) {
		$this->_restInvoke("/privilege/data/datasrcApi");
	}
	public function dataAction(Message $msg) {
		$this->_restInvoke("/privilege/data/dataApi");
	}
	public function orderFieldAction(Message $msg) {
		$this->_restInvoke("/privilege/data/orderFieldApi");
	}
	public function orderTplAction(Message $msg) {
		$this->_restInvoke("/privilege/data/orderTplApi");
	}
	public function deliveryAction(Message $msg) {
		$this->_restInvoke("/privilege/data/deliveryApi");
	}
	public function orderAction(Message $msg) {
		$this->_restInvoke("/privilege/data/orderApi");
	}
	public function memberAuthAction(Message $msg) {
		$this->_restInvoke("/session/memberAuthApi");
	}
	public function feedbackAction(Message $msg) {
		$this->_restInvoke("/privilege/data/feedbackApi");
	}
	public function memberAction(Message $msg) {
		$this->_restInvoke("/privilege/data/memberApi");
	}
	public function newsAction(Message $msg) {
		$this->_restInvoke("/privilege/data/newsApi");
	}
	private function _restInvoke($apiPath){
		try{
			if($ret = $this->restInvoke($apiPath)){
				$this->ok($ret);
			}else{
				$this->fail("Request failed");
			}
		}catch (Exception $e){
			require_once LIB_PATH."/db/mysql/mysqlPdoBase.php";
			if($e->getCode() == mysqlPdoBase::NONERRCODE){
				return $this->fail("No matched records to op");
			}
			if(APP_DEBUG){
				$this->fail(tianException::info($e));
			}else{
				$this->fail($e->getMessage());
			}
	
		}		
	}
}

?>
