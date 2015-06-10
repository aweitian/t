<?php
/**
 * @author awei.tian
 * date: 2013-9-18
 * 说明:
 */
class debugController extends appController{
	public static function _checkPrivilege(message $msg,identityToken $it){
		return true;
	}
	
	public function __construct(){
		$this->_loadView();
		$this->_loadModel();
		$this->_init();
	}
	
	public function welcomeAction(message $msg){
		//list all leaf
		require_once ENTRY_PATH."/app/api/privilege/data/nodeApi.php";
		$demo = new nodeApi();
		$demo->setMethod("get");
		$demo->setScenario("listAllLeaf");
		$demo->setArgs(array(
			"nodepath"=>"/"
		));
		var_dump($demo->invoke());
	}
	
	public function orderpreAction(){
		require_once ENTRY_PATH."/app/data/order/orderInfo.php";
		$oderinfo = new orderInfo();
		var_dump($oderinfo->prebi("/", 2, "/", "wsx", "pl"));
	}
	public function testppAction(){
		require_once ENTRY_PATH."/app/payment/ppipn/ppipn.php";
		$demo = new ppipn(
				"xlong928_business@gmail.com", "return_url", "cancal_rul", "notify_url");
		echo $demo->pay("test", 12.45, array("item_number"=>"db table insert id"));
	}
	public function testppnofity(){
		require_once ENTRY_PATH."/app/payment/ppipn/ppipn.php";
		$demo = new ppipn(
				"xlong928_business@gmail.com", "return_url", "cancal_rul", "notify_url");
		echo $demo->notify(array($this,"_pp_ok"), array($this,"_pp_fail"));
	}
	private function _pp_ok($post_data,$response_text){
		//更新表ID = $post_data["item_number"]的记录为成功 
	}
	private function _pp_fail($post_data,$response_text){
		//更新表ID = $post_data["item_number"]的记录为失败
	}	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function testmfAction(){
		$this->view->testMF();
	}
	public function testuiAction(){
		$this->view->testui();
	}	
	
	public function hotAction(message $msg){
		require_once ENTRY_PATH."/app/uipatch/table/uipatch_table.php";
		require_once ENTRY_PATH."/app/api/privilege/data/datasrc/datasrchotApi.php";
		require_once ENTRY_PATH."/app/api/privilege/data/conf/conftablehotApi.php";
		
		
		$dataApi = new datasrchotApi();
		$dataApi->setMethod("get");
		$dataApi->setArgs(array(
			"path"=>"/?hot/"
		));
		$data = $dataApi->invoke();
		$datasrc = new DataSrc_hot($data);
		
		$confApi = new conftablehotApi();
		$confApi->setMethod("get");
		$confApi->setArgs(array(
			"path"=>"/?hot/"
		));
		$conf = $confApi->invoke();
		$confsrc = new conf_table_hot($conf);
		
		$demo = new uipatch_table($datasrc,$confsrc);
		var_dump($demo->getData()) ;
	}
	public function htmlAction(message $msg){
		require_once ENTRY_PATH."/app/widgets/html/widget_html.php";
		$demo = new widget_html("/ui/axz",24);
		var_dump($demo->getHTML());
	}
	
	
	
	
	
	public function loginAction(message $msg){
		require_once ENTRY_PATH."/app/uipatch/member/login.php";
		$demo = new uipatch_login(array(
			"usr"=>array(
				"value"=>"uu",
				"placeholder"=>"username",
				"class"=>"lcxx"
			)
		));
		var_dump($demo->getData());
	}
	
	
	
	public function tabletpAction(message $msg){
		$demo = new widget_table("/azxs/q", 38);
// 		var_dump($demo->getHTML());exit;
		$this->view->spancalc($demo->getHTML());
	}
	public function tableapAction(message $msg){
		$demo = new widget_table("/azxs/q", 51);
// 		var_dump($demo->getHTML());exit;
		$this->view->spancalc($demo->getHTML());
	}
	public function tableldAction(message $msg){
		$demo = new widget_table("/azxs/q", 64);
// 		var_dump($demo->getHTML());exit;
		$this->view->spancalc($demo->getHTML());
	}
	public function tabletpeAction(message $msg){
		$demo = new widget_table("/azxs/q", 74);
// 		var_dump($demo->getHTML());exit;
		$this->view->spancalc($demo->getHTML());
	}
	
	
	public function orderSubscribeAction(message $msg){
		require_once ENTRY_PATH."/app/data/order/orderOp.php";
		$op = new orderOp();
		$ret = $op->add("paypal","eml@aa.com", "pl", "3 g", "1.1", "/ui/axz", 48, "hi", array (
		    'eml' => "email@hi.com",
		    'tt' => "a"
		  ),
		"127.0.0.1");
		var_dump($ret);
	}	
	
	
	
	public function table22apAction(message $msg){
		require_once ENTRY_PATH."/app/widgets/table/widget_table.php";
		$demo = new widget_table("/world of warcraft/us/gold", 4);
		print $demo->getHTML();
	}
	public function calcAction(message $msg){
		$calc = new widget_calc("/ui/axz", 48);
		if(isset($msg["?ns"])){
			$calc->uipatch_nsselector->setCurrentKeypath($msg["?ns"]);
			echo json_encode($calc->uipatch_nsselector->getData());
			return ;
		}
		$this->view->spancalc($calc->getHTML());
	}
	public function spancalcAction(message $msg){
		$spancalc = new widget_spancalc("/world of warcraft/us/pl", 12);
		if(isset($msg["?ns"])){
			$spancalc->uipatch_nsselector->setCurrentKeypath($msg["?ns"]);
			echo json_encode(array(
					"nsdata"=>$spancalc->uipatch_nsselector->getData(),
					"data"=>$spancalc->getData()
			));
			return ;
		}
		$this->view->spancalc($spancalc->getHTML());
	}
}