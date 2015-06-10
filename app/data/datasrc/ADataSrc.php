<?php
require_once ENTRY_PATH.'/app/interfaces/IOrder.php';
class ADataSrc{
	public $data;
	public function getId(){
		return substr(get_class($this),8);
	}
}