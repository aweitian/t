<?php
/**
 * @author awei.tian
 * date: 2013-10-8
 * 说明: sae kv
 */
class saekv implements iKv{
	private $kv;
	public function __construct(){
		$this->kv = new SaeKV();
	}
	public function get($key){
		return $this->kv->get($key);
	}
	public function set($key, $value){
		return $this->kv->set($key,$value);
	}
	public function delete($key){
		return $this->kv->delete($key);
	}
}