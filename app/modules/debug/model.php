<?php
/**
 * Date: 2016-01-09
 * Author: Awei.tian
 * Description: 
 */
class debugModel extends model{
	public function __construct(){
		parent::__construct();
	}
	public function test(){
		return "hi";
	}
}