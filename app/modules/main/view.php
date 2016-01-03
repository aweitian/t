<?php
/**
 * Date: 2015-12-31
 * Author: Awei.tian
 * Description: 
 */
class mainView extends view{
	public function getList($data){
		return $this->fetch("list",$data);
	}
	public function detail($data){
		return $this->fetch("detail",$data);
	}
}