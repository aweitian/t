<?php
/**
 * Date: 2015-1-21
 * Author: Awei.tian
 * function: 
 */
require_once API_PATH."/aApi.php";
require_once ENTRY_PATH."/app/data/news/newsInfo.php";
require_once ENTRY_PATH."/app/data/news/newsOp.php";

class newsApi extends aApi{
	private $helper;
	public function __construct(){

	}
	/**
	 * @return bool
	 * @see IApi::invoke()
	 */
	public function invoke(){
		if($this->isGet()){
			return $this->_list();
		}else if($this->isPost()){
			return $this->_add();
		}else if($this->isPut()){
			return $this->_update();
		}else if($this->isDelete()){
			return $this->_remove();
		}
	}
	/**
	 * path
	 */
	private function _list(){
		$this->helper = new newsInfo();
		if(isset($this->args["offset"],$this->args["length"])){
			return $this->helper->all($this->args["offset"],$this->args["length"]);
		}else if(isset($this->args["sid"])){
			return $this->helper->info($this->args["sid"]);
		}else {
			return $this->helper->getSlideData();
		}
		throw new Exception("invalid args",1);
	}
	/**
	 * path
	 * @return number >0 ok
	 */
	private function _add(){
		if(!isset($this->args["title"],$this->args["content"],$this->args["lnk"],$this->args["sldimg"],$this->args["sldflg"],$this->args["sldorder"])){
			throw new Exception("invalid args",9);
		}
		$this->helper = new newsOp();
		$sid = $this->helper->add($this->args["title"],$this->args["content"],$this->args["lnk"],$this->args["sldimg"],$this->args["sldflg"],$this->args["sldorder"]);
		return $sid;
	}
	private function _update(){
		$this->helper = new newsOp();
		if(isset($this->args["sid"],$this->args["title"],$this->args["content"],$this->args["lnk"],$this->args["sldimg"],$this->args["sldflg"],$this->args["sldorder"])){
			return $this->helper->update($this->args["sid"],$this->args["title"],$this->args["content"],$this->args["lnk"],$this->args["sldimg"],$this->args["sldflg"],$this->args["sldorder"]);
		}else if(isset($this->args["sid"])){
			switch ($this->scenario){
				case "turnonslide":
					return $this->helper->trunOnFlag($this->args["sid"]);
				case "turnoffslide":
					return $this->helper->trunOffFlag($this->args["sid"]);
			}
		}
		throw new Exception("invalid args",2);
	}
	private function _remove(){
		$this->helper = new newsOp();
		if(isset($this->args["sid"])){
			return $this->helper->remove($this->args["sid"]);;
		}
		throw new Exception("invalid args", 1);
	}
}