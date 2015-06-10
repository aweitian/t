<?php
/**
 * Date: 2014-12-29
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/delivery/deliveryInfo.php";
require_once ENTRY_PATH."/app/data/datasrc/pathDbHelper.php";
require_once ENTRY_PATH."/app/data/datasrc/DataSrcNsdata.php";
require_once ENTRY_PATH."/app/data/widget/widgetInfo.php";
require_once ENTRY_PATH."/app/uipatch/delivery/uipatch_delivery.php";
require_once ENTRY_PATH."/app/data/orderTpl/orderTplInfo.php";
require_once ENTRY_PATH."/app/data/conf/base/conf.php";
require_once ENTRY_PATH."/app/data/conf/op/spancalc_22ldInfo.php";
require_once ENTRY_PATH."/app/data/datasrc/op/datasrc_hotInfo.php";
require_once ENTRY_PATH."/app/data/datasrc/op/datasrc_ofhintInfo.php";
class orderInfo{
	/**
	 * @var IDb
	 */
	public $db;
	/**
	 * @var IPdoBase
	 */
	public $pdo;
	public $pathDbHelper;
	public function __construct(){
		$this->_initdb();
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
		$this->pathDbHelper = new pathDbHelper();
	}
	/**
	 * 
	 * @param unknown $nodepath
	 * @param unknown $wo
	 * @param unknown $ns
	 * @param unknown $locInfo
	 * @throws Exception
	 * @return return array(
				"title"=>$t,
				"price"=>$p,
				"ns"=>$ns,
				"np"=>$nodepath,
				"dt"=>$delivery_type,
				"wo"=>$wo,
				"delivery"=>$ui->getData()
		);
	 */
	public function prebi($nodepath,$wo,$ns,$locInfo,$dlvHint = true){
		if($nodepath == "/" && $wo == 0)return $this->_hot_prebi($nodepath, $wo, $ns, $locInfo);
// 		var_dump($nodepath,$wo,$ns,$locInfo);exit;
		$wginfo = new widgetInfo();
		$wginfoData = $wginfo->getInfo($nodepath, $wo);
		if(empty($wginfoData)){
			throw new Exception("invalid widgit or order",0x90);
		}
		$delivery_type = $wginfoData["ordertpl"];
		$dkpath = $this->pathDbHelper->getPathByDksid($wginfoData["dksid"]);
		$nspath = $dkpath.$ns;
// 		var_dump($locInfo);exit;
		$ds_data = new DataSrcNsdata($nspath);
		$data = $ds_data->getData();
		if(empty($data)){
			throw new Exception("invalid dksid or ns path",0x90);
		}
		/**
		 * NS最后一个路径为da 字段的值
		 * 正确的应该是和NS一样的路径,只是路径的由da组成
		 */
// 		var_dump($data);exit;
		$rc = new ReflectionClass("DataSrc_".$data["dstype"]);
		if (!$rc->implementsInterface('IOrder')){
			throw new Exception("datasrc does not support iorder interface.",0x9);
		}
// 		var_dump($wginfoData["typeid"],$wginfoData["confid"]);exit;			
		switch ($wginfoData["typeid"]){
			//22AP类型单位不影响价格,为什么要从数据库中读取?
			//因为有可能单位是1K,而用户提交为10K,影响了标题
			case "table_22ld":
				$conf =$this->pdo->fetch("select `unitprice` from `tny_fs_conf_".$wginfoData["typeid"]."` where `csid`=:csid", array(
						"csid"=>$wginfoData["confid"]
				));
				$locInfo["unit"] = $conf["unitprice"];
				break;
			case "spancalc_22ld":
			case "table_22ap":
			case "calc_22ap":
				$conf =$this->pdo->fetch("select `unit` from `tny_fs_conf_".$wginfoData["typeid"]."` where `csid`=:csid", array(
					"csid"=>$wginfoData["confid"]
				));
				$locInfo["unit"] = $conf["unit"];
				break;
		}
// 		var_dump($locInfo);exit;		
		$ds=$rc->newInstance($data["data"]);
		$p = $ds->getPrice($locInfo);
		if(is_array($p) && array_key_exists("price", $p) && array_key_exists("day", $p)){
			$t = $ds->getTitle($locInfo);
			$t.= "(".$p["day"]." day(s))" ;
			$p = $p["price"];
		}else{
			$t = $ds->getTitle($locInfo);
		}
		$dl_def = array();
		if($dlvHint){//est
			$helper = new orderTplInfo();
			$dlv_data = $helper->getDeliveryInfos($delivery_type);
			$path = $nodepath;
			foreach ($dlv_data as &$item){
				if($item["typ"] == "input_str"){
					//根据实际情况处理需要的字段
					if($item["key"] == $data["da"]){
						$tmp = explode("/", $ns);
						$dl_def[$item["key"]] = end($tmp);
					}
					if($item["key"] == "servername"){
						
						while(!DataSrcPath::isRootPath(DataSrcPath::getParentPath($path))){
							//echo $path."<br>";
							try{
								$ofhint = new datasrc_ofhintInfo($path."?".$item["key"]."/");
								$d = $ofhint->getData();
								if($d){
									if(datasrc_ofhintInfo::isCutInheritLinkArr($d)){
										break;
									}else{
										$item["len"] = join(",",$ofhint->getData());
									}
								}
								
							}catch (Exception $e){
								if($e->getCode() != 0x441){
									throw $e;
								}
							}
							$path = DataSrcPath::getParentPath($path);	
						}
					}
				}
			}
			$ui = new uipatch_delivery($delivery_type,$dlv_data,$dl_def);			
		}else{//subscribe
			$helper = new orderTplInfo();
			$dlv_data = $helper->getDeliveryInfos($delivery_type);
			$ui = new uipatch_delivery($delivery_type,$dlv_data);
		}

		
// 		var_dump($dlv_data);exit();
		
		return array(
				"title"=>$t,
				"price"=>$p,
				"ns"=>$ns,
				"np"=>$nodepath,
				"dt"=>$delivery_type,
				"wo"=>$wo,
				"delivery"=>$ui->getData()
		);
	}
	private function _hot_prebi($nodepath,$wo,$ns,$locInfo){
		$delivery_type = $ns;
		$helper = new datasrc_hotInfo("/?hot/");
		$data = $helper->getData();
		foreach ($data as $item){
			if($locInfo == $item[0]){
				$p = $item[2];
				$t = $item[0];
				
				$helper = new orderTplInfo();
				$ui = new uipatch_delivery($delivery_type,$helper->getDeliveryInfos($delivery_type));
				return array(
						"title"=>$t,
						"price"=>$p,
						"ns"=>$ns,
						"np"=>$nodepath,
						"dt"=>$delivery_type,
						"wo"=>$wo,
						"delivery"=>$ui->getData()
				);
			}
		}
		throw new Exception("invalid locinfo",2);
	}
	public function info($sid){
		$row = $this->pdo->fetch("select * from `tny_order_his` where `sid`=:sid", array(
				"sid"=>$sid
		));
		return $row;
	}
	public function infoWithDelivery($sid){
		$row = $this->info($sid);
		if(empty($row))return $row;
		$helper = new deliveryInfo();
		$row["deliveryInfo"] = $helper->info($row["dt"], $row["dlvid"]);
		return $row;
	}
	public function all($offset,$len){
		$row = $this->pdo->fetch("select count(sid) as cnt from `tny_order_his` where 1", array());
		$cnt = $row["cnt"];
		if($cnt != 0){
			$data = $this->pdo->fetchAll("select `tny_order_his`.*,`tny_fs_node_struct`.`path` from `tny_order_his`
				left join `tny_fs_node_struct` on `tny_fs_node_struct`.`sid` = `tny_order_his`.`nsid`
					where 1 order by `sid` desc limit :offset,:length", array(
					'offset'=>(int)$offset,
					'length'=>(int)$len
			));
		}else{
			$data = array();
		}
		$helper = new deliveryInfo();
		foreach ($data as &$row){
			$row["deliveryInfo"] = $helper->info($row["dt"], $row["dlvid"]);
		}
		return array(
				"cnt"=>$cnt,
				"data"=>$data
		);
	}
	public function searchByEml($eml,$offset,$len){
		$row = $this->pdo->fetch("select count(id) as cnt from `tny_order_his`
				where
				`eml` = :eml
				", array(
							'eml'=>$eml
					));
		$cnt = $row["cnt"];
		if($cnt != 0){
			$data = $this->pdo->fetchAll("select * from `tny_order_his`
				where
				`eml` = :eml
				limit :offset,:length
				", array(
							'eml'=>$eml,
							'offset'=>(int)$offset,
							'length'=>(int)$len
					));
		}else{
			$data = array();
		}
		return array(
				"cnt"=>$cnt,
				"data"=>$data
		);
	}
	public function searchByDate($start,$end,$offset,$len){
		$row = $this->pdo->fetch("select count(id) as cnt from `tny_order_his`
				where
				`dtime` >= :start and `dtime` <= :end
				", array(
								'start'=>$start,
								'end'=>$end
						));
		$cnt = $row["cnt"];
		if($cnt != 0){
			$data = $this->pdo->fetchAll("select * from `tny_order_his`
				where
				`dtime` >= :start and `dtime` <= :end
				limit :offset,:length
				", array(
								'start'=>$start,
								'end'=>$end,
								'offset'=>(int)$offset,
								'length'=>(int)$len
						));
		}else{
			$data = array();
		}
		return array(
				"cnt"=>$cnt,
				"data"=>$data
		);
	}
	public function searchByDateEml($start,$end,$eml,$offset,$len){
		$row = $this->pdo->fetch("select count(id) as cnt from `tny_order_his`
				where
				`dtime` >= :start and `dtime` <= :end
				and `eml` = :eml
				", array(
								'start'=>$start,
								'end'=>$end,
								'eml'=>$eml,
						));
		$cnt = $row["cnt"];
		if($cnt != 0){
			$data = $this->pdo->fetchAll("select * from `tny_order_his`
				where
				`dtime` >= :start and `dtime` <= :end
					and `eml` = :eml
				limit :offset,:length
				", array(
								'start'=>$start,
								'end'=>$end,
								'eml'=>$eml,
								'offset'=>(int)$offset,
								'length'=>(int)$len
						));
		}else{
			$data = array();
		}
		return array(
				"cnt"=>$cnt,
				"data"=>$data
		);
	}
}