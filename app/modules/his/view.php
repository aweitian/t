<?php
/**
 * Date: 2016-01-01
 * Author: Awei.tian
 * Description: 
 */
class hisView extends view{
	public function getList($data){
		return $this->fetch("list",$data);
	}
}