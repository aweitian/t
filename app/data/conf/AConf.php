<?php
class AConf{
	public $conf;
	public $rawData;
	public function getId(){
		return substr(get_class($this),5);
	}
}