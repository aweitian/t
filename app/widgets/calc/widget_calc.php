<?php
/**
 * Date: 2014-9-25
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/widgets/AWidget.php";
require_once ENTRY_PATH."/app/interfaces/IOrder.php";
require_once ENTRY_PATH."/app/uipatch/nsselector/uipatch_nsselector.php";
require_once ENTRY_PATH."/app/api/privilege/data/widgetApi.php";
require_once ENTRY_PATH."/app/api/privilege/data/dataApi.php";
require_once ENTRY_PATH."/app/api/privilege/data/confApi.php";
class widget_calc extends AWidget{
	public $ordertype;
	
	
	
	/**
	 * @var uipatch_nsselector
	 */
	public $uipatch_nsselector;
	
	
	
	/**
	 * @var DataSrc_nsdata
	 */
	public $DataSrc_nsdata;
	
	
	
	/**
	 * @var conf_calc_22ap
	 */
	public $config;
	
	private $dataType;
	private $confType;
	public $order;
	public $path;
	/**
	 * 
	 * @param numberic $order
	 * @param string $path
	 */
	public function __construct($path,$order){
		$api = new widgetApi();
		$api->setArgs(array(
			"path"=>$path,
			"order"=>$order
		));
		$api->setMethod("get");
		$info = $api->invoke();
// 		var_dump($info);exit;
		$datasrc_path = $info["datasrcpath"];
		$this->ordertype = $info["ordertpl"];
		$datasrcApi = new dataApi();
		$datasrcApi->setMethod("get");
		$datasrcApi->setArgs(array(
			"path"=>$datasrc_path
		));
// 		var_dump($datasrcApi->invoke());exit;
		$this->DataSrc_nsdata = new DataSrc_nsdata($datasrcApi->invoke());
		$data = $this->DataSrc_nsdata->data;
		
//		var_dump($data);exit;
		$this->dataType = $data["dsType"];
		$this->uipatch_nsselector = new uipatch_nsselector(new DataSrc_ns($data,"rawdata"));
		
		
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
		$this->config = new conf_calc_22ap($config["conf"]);
		$this->confType = $config["type"];
		$this->order = $order;
		$this->path = $path;
	}
	public function getJsData(){
		return json_encode($this->DataSrc_nsdata->data["datasrc"]);
	}
	public function getJsUnit(){
		return json_encode($this->config->conf["unit"]);
	}
	public function getNsDeco(){
		return $this->uipatch_nsselector->getCurrentNamespaceWrap();
	}
	public function setNsPath($path){
		return $this->uipatch_nsselector->setCurrentKeypath($path);
	}
	public function getData(){
		return $this->uipatch_nsselector->getData();
	}
	public function getHTML(){
		return $this->_wrap_data();
	}
	public function getOrderType(){
		return $this->ordertype;
	}
	public function getSupportedDatasrctypeids(){
		return array("calc");
	}
	public function setCurrentNamespace($path){
		$this->uipatch_nsselector->setCurrentKeypath($path);
	}
	private function _wrap_data(){
		ob_start();
		require dirname(__FILE__)."/tpl.php";
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}