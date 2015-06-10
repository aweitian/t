<?php
/**
 * Date: 2014-9-22
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/widgets/AWidget.php";
require_once ENTRY_PATH."/app/interfaces/IOrder.php";
require_once ENTRY_PATH."/app/uipatch/table/uipatch_table.php";
require_once ENTRY_PATH."/app/uipatch/nsselector/uipatch_nsselector.php";
require_once ENTRY_PATH."/app/api/privilege/data/widgetApi.php";
require_once ENTRY_PATH."/app/api/privilege/data/dataApi.php";
require_once ENTRY_PATH."/app/api/privilege/data/confApi.php";
class widget_table extends AWidget{
		
	/**
	 * @var orderType
	 */
	public $ordertype;
	
	
	
	/**
	 * @var uipatch_nsselector
	 */
	public $uipatch_nsselector;
	
	
	
	/**
	 * @var DataSrc_nsdata
	 */
	public $DataSrc_nsdata;
	
	//AConfig
	public $config;
	
	public $dataType;
	public $confType;
	public $order;
	public $path;
	/**
	 * @param string $nspath
	 * @param string $datasrctypeid
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
		$datasrc_path = $info["datasrcpath"];
		$datasrcApi = new dataApi();
		$datasrcApi->setMethod("get");
		$datasrcApi->setArgs(array(
			"path"=>$datasrc_path
		));
//		var_dump($datasrcApi->invoke());exit;
		$this->DataSrc_nsdata = new DataSrc_nsdata($datasrcApi->invoke());
		$data = $this->DataSrc_nsdata->data;
		
// 		var_dump($data);exit;
		$this->dataType = $data["dsType"];
		if(!in_array($this->dataType,$this->getSupportedDatasrctypeids())){
			throw new Exception("unknow datasrc type",1);
		}
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
		
		$this->confType = $config["type"];
		$this->order = $order;
		$this->path = $nodepath;
// 		var_dump($this->confType,$config["conf"]);exit;
		$this->config = conf::create($this->confType, $config["conf"]);
// 		var_dump($this->config);exit;
	}
	public function getSupportedDatasrctypeids(){
		return array("22tp","23tpe","22ap","23ldp","22ld","hot");
	}
	public function getOrderType(){
		
	}
	public function getPpType(){
		switch ($this->dataType){
			case "22ld":
			case "23ldp":
				return "spancalcJS";
			case "22ap":
				return "calcJS";
			default:
				return "tbJS";
		}
	}
	public function getHTML(){
		$html = array();
		$data = $this->DataSrc_nsdata->getAllLeafPath();
		
// 	var_dump($data);exit;
			
		foreach ($data as $path){
			if(!isset($this->config->conf["tableCaption"]) || $this->config->conf["tableCaption"] == ""){
				$this->config->conf["tableCaption"] = join("/", array_values(
					$this->DataSrc_nsdata->getCurrentNamespaceWrap($path)
				));
			}
			$ui = new uipatch_table(
				dataSrc::create($this->dataType, $this->DataSrc_nsdata->getData($path)),
				$this->config
			);
			$html[$path] = $ui->getData();
		}
// 		var_dump($this->config->conf);exit;
		ob_start();
		include dirname(__FILE__)."/tpl.php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
}