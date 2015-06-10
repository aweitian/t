<?php
/**
 * Date: 2014-10-15
 * Author: Awei.tian
 * function: 
 */
require_once API_PATH."/aApi.php";
require_once ENTRY_PATH."/app/uipatch/table/uipatch_table.php";
require_once ENTRY_PATH."/app/data/datakey/datakeyInfo.php";
require_once ENTRY_PATH."/app/data/conf/base/conf.php";
require_once ENTRY_PATH."/app/data/confkey/confkeyInfo.php";
require_once ENTRY_PATH."/app/data/datasrc/DataSrcPath.php";
require_once ENTRY_PATH.'/app/data/datasrc/dataSrc.php';
require_once ENTRY_PATH.'/app/data/datasrc/op/datasrc_22apInfo.php';
require_once ENTRY_PATH.'/app/data/datasrc/op/datasrc_22ldInfo.php';
require_once ENTRY_PATH.'/app/data/datasrc/op/datasrc_22tpInfo.php';
require_once ENTRY_PATH.'/app/data/datasrc/op/datasrc_23ldpInfo.php';
require_once ENTRY_PATH.'/app/data/datasrc/op/datasrc_23tpeInfo.php';

require_once ENTRY_PATH.'/app/data/conf/op/calc_22apInfo.php';
require_once ENTRY_PATH.'/app/data/conf/op/spancalc_22ldInfo.php';
require_once ENTRY_PATH.'/app/data/conf/op/spancalc_23ldpInfo.php';
require_once ENTRY_PATH.'/app/data/conf/op/table_22apInfo.php';
require_once ENTRY_PATH.'/app/data/conf/op/table_22ldInfo.php';
require_once ENTRY_PATH.'/app/data/conf/op/table_22tpInfo.php';
require_once ENTRY_PATH.'/app/data/conf/op/table_23ldpInfo.php';
require_once ENTRY_PATH.'/app/data/conf/op/table_23tpeInfo.php';
class tableUiApi extends aApi{
	private $ui;
	public function __construct(){
		
	}
	/**
	 * @return bool
	 * @see IApi::invoke()
	 */
	public function invoke(){
		if($this->isGet()){
			return $this->_list();
		}else if($this->isPost()){
			//return $this->_add();
		}else if($this->isPut()){
			//return $this->_update();
		}else if($this->isDelete()){
			//return $this->_remove();
		}
	}
	/**
	 * datasrc path
	 * config  path
	 */
	private function _list(){
		if(!isset($this->args["datasrc_path"])){
			throw new Exception("require datasrc path");
		}
		if(!isset($this->args["conf_path"])){
			throw new Exception("require config path");
		}
		
		$dsp_dsrc = new DataSrcPath($this->args["datasrc_path"]);
		$dsp_conf = new DataSrcPath($this->args["conf_path"]);
		$datakeyInfo = new datakeyInfo($dsp_dsrc->getDatakeyPath());
// 		$this->ui = new uipatch_table();
// 		array
// 		'key' => string 'xxoo' (length=4)
// 		'dstype' => string '22tp' (length=4)
// 		'deco' => string '' (length=0)
// 		'comment' => string 'test' (length=4)
		$row_ds = $datakeyInfo->getInfo();
		if(!array_key_exists($row_ds["dstype"], dataSrc::$typeArr)){
			throw new Exception("invalid dstype", 0x147);
		}
		$cls_dsinfo = "datasrc_".$row_ds["dstype"]."Info";
		$cls_dsbase = "DataSrc_".$row_ds["dstype"]."";
		$dsinfo = new $cls_dsinfo($this->args["datasrc_path"]);
		$ds_data = $dsinfo->getData();
		
		$confInfo = new confkeyInfo($this->args["conf_path"]);
		$row_conf = $confInfo->getInfo();
		if(!array_key_exists($row_conf["typeid"], conf::$typeArr)){
			throw new Exception("invalid typeid", 0x148);
		}
		$cls_confinfo = $row_conf["typeid"]."Info";
		$cls_confbase = "conf_".$row_conf["typeid"];
		$confinfo = new $cls_confinfo($this->args["conf_path"]);
		$conf_data = $confinfo->getConf();
		
		$this->ui = new uipatch_table(new $cls_dsbase($ds_data), new $cls_confbase($conf_data));
		return $this->ui->getHTML();
	}
	/**
	 * path
	 * @return number >0 ok
	 */
	private function _add(){
	}
	private function _update(){
	}
	private function _remove(){
	}
}