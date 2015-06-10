<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */
require_once ENTRY_PATH."/app/data/datasrc/op/datasrc_nsdataInfo.php";
require_once ENTRY_PATH."/app/data/datasrc/DataSrc_nsdata.php";
require_once ENTRY_PATH."/app/uipatch/nsselector/uipatch_nsselector.php";
require_once ENTRY_PATH."/app/api/privilege/data/confApi.php";
require_once ENTRY_PATH."/app/api/privilege/data/orderTplApi.php";
require_once ENTRY_PATH."/app/uipatch/delivery/uipatch_delivery.php";
require_once ENTRY_PATH."/app/uipatch/pagination/uipatch_pagination.php";
class testController extends Controller{
	public static function _checkPrivilege(message $msg,identityToken $it){
		return true;
	}
	public function __construct(){
		$this->_init();
	}
	
	public function paginationAction(message $msg){
		$ui = new uipatch_pagination(13, 2,6,2,1);
	
		var_dump($ui->getData());
	}
	
	
	
	
	
	public function listDsAction(message $msg){
		$data = tian::$context->getDb()->getPdoBase()
		->fetchAll("SELECT CONCAT(`tny_fs_node_struct`.`path`,'?',`tny_fs_datakey_struct`.`key`,
			`tny_fs_ns_struct`.`path`) as p,
			`tny_fs_datakey_struct`.`dstype` as t,
			`tny_fs_datakey_struct`.`sid` as `dksid`
			FROM `tny_fs_ns_struct`
			LEFT JOIN `tny_fs_datakey_struct` ON `tny_fs_datakey_struct`.`sid` = `tny_fs_ns_struct`.`dksid`
			LEFT JOIN `tny_fs_node_struct` ON `tny_fs_node_struct`.`sid` = `tny_fs_datakey_struct`.`nsid`
			WHERE `tny_fs_ns_struct`.`nt` = 'file'", array());
		$this->view->showDs($data);
	}
	public function deliveryAction(message $msg){
		
		$dataApi = new orderTplApi();
		$dataApi->setArgs(array("name"=>"pl"))
		->setMethod("get");
		
		$data = $dataApi->invoke();
		
		var_dump($data);exit;
		$ui = new uipatch_delivery("pl",$data);
		
		var_dump($ui->getData());
	}
	public function welcomebakAction(message $msg){
		$demo = new datasrc_nsdataInfo("/?xxoo/");
		$data = $demo->getData("asc");
//		var_dump($data);
//		$test = new DataSrc_ns(DataSrc_ns::convertDbDataToNsdata($data));
		$test = new DataSrc_ns($data);
		$demo = new uipatch_nsselector($test);
		var_dump($demo->src->getAllLeafPath());
		$demo->setCurrentKeypath("/vb/vcc/vccf");
		print $demo->getHTML();
	}
	public function nsselAction(message $msg){
		$demo = new datasrc_nsdataInfo("/?xxoo/");
		$data = $demo->getData("asc");
//		var_dump($data);
//		$test = new DataSrc_ns(DataSrc_ns::convertDbDataToNsdata($data));
		$test = new DataSrc_ns($data);
		$demo = new uipatch_nsselector($test);
		var_dump($demo->src->getAllLeafPath());
		$demo->setCurrentKeypath("/vb/vcc/vccf");
		print $demo->getHTML();
	}
	public function datasrcAction(message $msg){
		$demo = new datasrc_nsdataInfo("/?xxoo/");
		$data = $demo->getData("asc");
//		var_dump($data);
//		$test = new DataSrc_ns(DataSrc_ns::convertDbDataToNsdata($data));
		$test = new DataSrc_nsdata($data);
		foreach ($test->getAllLeafPath() as $leaf){
			var_dump($test->getDatasrc($leaf));
			echo "<hr>";
		};
	}
//	public function welcomeAction(message $msg){
//		$demo = new datasrc_nsInfo("/?xxoo/vb");
//		var_dump($demo->getData());
//	}

}