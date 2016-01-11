<?php
/**
 * Date: 2016-01-09
 * Author: Awei.tian
 * Description: 
 */
class apiView extends view{
	public function output($data){
		exit(json_encode($data));
	}
}