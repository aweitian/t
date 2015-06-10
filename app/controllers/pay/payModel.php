<?php
/**
 * Date: 2015-1-26
 * Author: Awei.tian
 * function: 
 */
class payModel extends appModel{
	
	public function getHotData(){
		$dataApi = new datasrchotApi();
		$dataApi->setMethod("get");
		$dataApi->setArgs(array(
				"path"=>"/?hot/"
		));
		$data = $dataApi->invoke();
// 		var_dump($data);exit;
		$datasrc = new DataSrc_hot($data);
		
		$confApi = new conftablehotApi();
		$confApi->setMethod("get");
		$confApi->setArgs(array(
				"path"=>"/?hot/"
		));
		$conf = $confApi->invoke();
		$confsrc = new conf_table_hot($conf);
		
		$data = new uipatch_table($datasrc,$confsrc);
		return $data->getData();
	}
}