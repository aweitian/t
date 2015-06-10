<?php
/**
 * Date: 2015-1-5
 * Author: Awei.tian
 * function: 
 */
class orderView extends appView{
	public function pribiUi($rawQueryString,$data){
		$main = $this->fetch(array("data"=>$data,"rawQueryString" => $rawQueryString), "pribi.tpl");
		$this->ui->wrap(array("content"=>$main),"layout");
	}
}