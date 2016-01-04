<?php
/**
 * Date: 2015-12-31
 * Author: Awei.tian
 * Description: 
 */
class debugView extends view{
	public function test($data){
		$this->wrap(
				$this->hideHeader()->hideFooter()->fetch("test",$data)
		)->show();
	}
}