<?php
/**
 * Date: 2016-01-09
 * Author: Awei.tian
 * Description: 
 */
class mainView extends view{
	public function showTask($list){
		return $this->fetch("task",$list);
	}
}