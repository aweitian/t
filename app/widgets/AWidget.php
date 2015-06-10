<?php
/**
 * Date: 2014-9-16
 * Author: Awei.tian
 * function: 
 */
abstract class AWidget{
 	public function getId(){
 		return substr(get_class($this),7);
 	}
 	abstract public function getHTML();
	abstract public function getSupportedDatasrctypeids(); 
}