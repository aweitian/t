<?php
/**
 * Date: 2015-1-5
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/widgets/AWidget.php";
require_once ENTRY_PATH."/app/interfaces/IOrder.php";
require_once ENTRY_PATH."/app/uipatch/table/uipatch_table.php";
require_once ENTRY_PATH."/app/uipatch/nsselector/uipatch_nsselector.php";
require_once ENTRY_PATH."/app/api/privilege/data/widgetApi.php";
require_once ENTRY_PATH."/app/data/datasrc/op/datasrc_htmlInfo.php";
require_once ENTRY_PATH."/app/api/privilege/data/dataApi.php";
require_once ENTRY_PATH."/app/api/privilege/data/confApi.php";
class widget_html extends AWidget{
		
	/**
	 * @var orderType
	 */
	public $ordertype;
	
	//AConfig
	public $config;
	public $data;
	private $dataType;
	private $confType;
	public $order;
	/**
	 * @param string $nodepath 只获取/np?k/的内容
	 * @param string $order
	 */
	public function __construct($nodepath,$order){
		$api = new widgetApi();
		$api->setArgs(array(
			"path"=>$nodepath,
			"order"=>$order
		));
		$api->setMethod("get");
		$info = $api->invoke();
//		var_dump($info);exit;
		$datasrc_path = $info["datasrcpath"]."/";
		$htmlInfo = new datasrc_htmlInfo($datasrc_path);
		$this->data = $htmlInfo->getData();
// 		var_dump($this->data);exit;
		//read config
		$config_path = $info["confpath"];
		$confApi = new confApi();
		$confApi->setMethod("get");
		$confApi->setArgs(array(
			"path"=>$config_path
		));
//		var_dump($config_path);exit;
		$config = $confApi->invoke();
		if(empty($config["conf"])){
			$config["conf"] = conf::getDefaultConf($config["type"]);
		}
// 		var_dump($config);exit;
		
		$this->confType = $config["type"];
		$this->order = $order;
		$this->config = conf::create($this->confType, $config["conf"]);
	}
	public function getSupportedDatasrctypeids(){
		return array("html");
	}
	public function getOrderType(){
		
	}
	public function getHTML(){
		return $this->data;
	}
}