<?php
/**
 * @author: awei.tian
 * @date: 2014-3-17
 * @usage:
 */
require_once ENTRY_PATH."/app/api/aApi.php";
require_once ENTRY_PATH."/app/session/captcha/captcha.php";

class captchaApi extends aApi{
	/**
	 * @return bool
	 * @see IApi::invoke()
	 */
	public function invoke(){
		if($this->isGet()){
			return $this->_get();
		}else if($this->isPost()){
			return $this->_check();
		}else if($this->isPut()){
			return $this->_update();
		}else if($this->isDelete()){
			return 0;
		}
	}	
	
	private function _get(){
		if(!isset($this->args["width"])){
			$width=-1;
		}else{
			$width=$this->args["width"];
			if($width>1024||$width<10){
				$width=-1;
			}
		}
		if(!isset($this->args["height"])){
			$height=-1;
		}else{
			$height=$this->args["height"];
			if($height>768||$height<10){
				$height=-1;
			}
		}
		if(!isset($this->args["length"])){
			$length=-1;
		}else{
			$length=$this->args["length"];
			if($height>768||$height<10){
				$length=-1;
			}
		}
		$helper = new session_captcha();
		if(isset($this->args["type"])){
			switch ($this->args["type"]){
				case "num":
					return $helper->getCode_num(
						$length,
						$width,
						$height
					);
				case "char":
					return $helper->getCode_char(
						$length,
						$width,
						$height
					);
				case "math":
					return $helper->getCode_math(
						$width,
						$height
					);
			}
			return $this->helper->getData();
		}else{
			return $helper->getCode_char(
					$length,
					$width,
					$height
			);
		}
	}
	/**
	 * path
	 * @return number >0 ok
	 */
	private function _check(){
		if(!isset($this->args["code"])){
			return false;
		}
		$helper = new session_captcha();
		return $helper->check($this->args["code"]);
	}
	private function _update(){
		$helper = new session_captcha();
		return $helper->_debug_get_code_238237128();
	}
	private function _remove(){
		
	}
	
}