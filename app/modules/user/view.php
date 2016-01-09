<?php
/**
 * Date: 2016-01-04
 * Author: Awei.tian
 * Description: 
 */
class userView extends view{
	public function getList($data){
		return $this->fetch("list",$data);
	}
}