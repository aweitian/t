<?php
/**
 * Date: 2014-9-25
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
class widget_spancalc extends AWidget{
	
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
	
	
	
	/**
	 * @var conf_spancalc_22ld
	 */
	public $conf_spancalc_22ld;
	
	private $dataType;
	private $confType;
	public $order;
	public $path;

	/**
	 * @param string $nodepath
	 * @param unknown $config
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
//		var_dump($config);exit;
//		var_dump($info["typeid"]);exit;

		if($info["typeid"] == "spancalc_22ld"){
			$this->conf_spancalc_22ld = new conf_spancalc_22ld($config["conf"]);
		}else{
			$this->conf_spancalc_22ld = new conf_spancalc_23ldp($config["conf"]);
		}
		$this->confType = $config["type"];
		$this->order = $order;
		$this->path = $nodepath;
	}
	public function getSupportedDatasrctypeids(){
		return array("spancalc");
	}
	public function getJsData(){
		app::addWidgetDep("spancalc");//addDependentJs($path)
		return json_encode($this->DataSrc_nsdata->data);
	}
	public function getJsUnit(){
		$conf = $this->conf_spancalc_22ld->conf;
		return $conf["unit"];
	}
	public function getHTML(){
		return $this->_wrap_data();
	}
	public function setCurrentNamespace($path){
		$this->uipatch_nsselector->setCurrentKeypath($path);
	}
	public function getData(){
		return $this->_getspanhtml();
	}
	private function _wrap_data(){
		ob_start();
		require dirname(__FILE__)."/tpl.php";
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	private function _getspanhtml(){
		$ret = array();
		$dat = $this->DataSrc_nsdata->getData($this->uipatch_nsselector->getCurrentKeypathStr());
		switch ($this->dataType){
			case "22ld":
				$this->unit = $this->conf_spancalc_22ld->conf["unit"];
				break;
			case "23ldp":
				$this->unit = 0;
				break;
			default:
				throw new Exception("invalid datasrc typeid");
		}
		$start = START_LEVEL;
		$end = $dat[count($dat)-1][0];
		$ret["current"] = array();
		$ret["current"]["name"] = "Current";
		
		$html = "<select name='cs'>";
		for($i=$start;$i<=$end-1;$i++){
			$html .= "<option value='".$i."'>".$i."</option>";
		}
		
		$html .= "</select>";
		$ret["current"]["html"] = $html;
		
		$ret["destination"] = array();
		$ret["destination"]["name"] = "Destination";
		$html = "<select name='ds'>";
		for($i=$start+1;$i<=$end;$i++){
			$html .= "<option value='".$i."'>".$i."</option>";
		}
		
		$html .= "</select>";
		$ret["destination"]["html"] = $html;
		return $ret;
	}
	
	private function _getnamespacehtml(){
		return $this->uipatch_nsselector->getData();
	}
}