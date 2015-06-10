<?php
/**
 * Date: 2014-9-19
 * Author: Awei.tian
 * function: 用于计算器不使用JS计算,
 * 相当于给用户提供一个路径选择器
 */
require_once ENTRY_PATH."/app/data/datasrc/DataSrcPath.php";
require_once ENTRY_PATH."/app/data/datasrc/ADataSrc.php";
class DataSrc_ns extends ADataSrc{
	private $use_namespace;
	public function __construct($data,$datamode = "dbdata"){
		if($datamode == "dbdata"){
			$this->data = self::convertDbDataToNsdata($data);
		}else{
			$this->data = $data;
		}
// 		var_dump(self::isNoNsData($data));exit;
		if(self::isNoNsData($data)){
			$this->use_namespace = false;
			return ;
		}
		if(!self::check($this->data)){
			if(DEBUG_FLAG){
				var_dump($data);
			}
			throw new Exception("illegal data");
		}
		$this->use_namespace = true;
	}
	/**
	 * /key1/key2/key3
	 * /kk1/kk2,kk4
	 * @return array:
	 */
	public function getAllLeafPath(){
		if(!$this->use_namespace)return "/";
		$ret = array();
		$this->_getAllLeafPath($this->data["data"],"",$ret);
		return $ret;
	}
	public function getNamespaceUseMode(){
		return $this->use_namespace;
	}	
	/**
	 * 长度相等匹配，没有相等的找长度大于且离自己长度最近的一个
	 * @return array
	 * array
	 * 'lvl-key-1' => string '1' (length=1)
	 * 'lvl-key-13' => string '22' (length=2)
	 * 'lvl-key-132' => string '33' (length=2)
	 * 查找失败返回array_combine(KEYPATH,KEYPATH)
	 */
	public function getCurrentNamespaceWrap($current_keypath){
		if(!$this->use_namespace)return array();
		$a = $this->data["nsDeco"];
		$tmp_lenKey_valArr = array();
		foreach ($a as $p){
			$arr = $this->_str2keypath($p);
			$tmplen = count($arr);
			$tmp_lenKey_valArr[$tmplen] = $arr;
		}
		if(is_string($current_keypath)){
			$current_keypath = $this->_str2keypath($current_keypath);
		}
		$cur_len = count($current_keypath);
		ksort($tmp_lenKey_valArr);
		if($cur_len == 0)return array();
		$ret = array();
		foreach ($tmp_lenKey_valArr as $len => $keypath){
			if($len >= $cur_len){
				$i = 0;
				foreach ($keypath as $wrap){
					$ret[$current_keypath[$i]] = $wrap;
					$i++;
					if($i == $cur_len)break;
				}
				return $ret;
			}
		}
		return array_combine($current_keypath, $current_keypath);
	}
	private function _getAllLeafPath($src,$path="",&$ret){
		if(self::isPointerTodataSrc($src)){$ret[] = $path;return true;}
		$f = true;
		$f = $f && is_array($src);
		foreach ($src as $key => $val){
			if(!$f)break;
			$f = $f && array_key_exists("text", $val);
			$f = $f && is_string($val["text"]);
			$f = $f && array_key_exists("data", $val);
			$f = $f && is_array($val["data"]);
			$f = $f && $this->_getAllLeafPath($val["data"],$path."/".$key,$ret);
		}
		return $f;
	}
	public static function getFirstLeafPath($src,$path=""){
		if(self::isPointerTodataSrc($src)){return $path;}
		$f = true;
		$f = $f && is_array($src);
		foreach ($src as $key => $val){
			if(!$f)break;
			$f = $f && array_key_exists("text", $val);
			$f = $f && is_string($val["text"]);
			$f = $f && array_key_exists("data", $val);
			$f = $f && is_array($val["data"]);
			if($f)return self::getFirstLeafPath($val["data"],$path."/".$key);
			return "";
		}
	}
	public static function convertDbDataToNsdata($dbdata){
//		var_dump($dbdata);exit;
		$data = array();
		foreach($dbdata as $row){
			$tr = &$data;
			$path = $row["path"];
			$tmp = trim($path,"/");
			$tmp = explode("/",$tmp);
//			var_dump($tmp);exit;
			for($i=0;$i<count($tmp)-1;$i++){
				if(isset($tr[$tmp[$i]]) && is_array($tr[$tmp[$i]])){
					$tr = &$tr[$tmp[$i]]["data"];
				}else{
					throw new Exception("invalid path");
				}
			}
			$tr[$tmp[$i]] = array("text"=>$tmp[$i],"nssid"=>$row["nssid"],"data"=>array());
		}
			//不会出错，因为上面的nsdsid就查过了
		$dec = $dbdata[0]["deco"];
		if(is_string($dec)){
			$dec = explode(",", $dec);
		}else{
			$dec = array();
		}
		return array("nsDeco"=>$dec,"dsType"=>$dbdata[0]["dstype"],"data"=>$data);
	}
	public static function check($data){
		return self::isValid($data);
	}
	public static function isValid($data){
		$f = true;
		$f = $f && is_array($data);
		$f = $f && array_key_exists("nsDeco", $data);
		$f = $f && array_key_exists("dsType", $data);
		$f = $f && array_key_exists("datasrc",$data);
		$f = $f && is_array($data["nsDeco"]);
		$f = $f && array_key_exists("data", $data);
		$f = $f && is_array($data["data"]);
		$f = $f && self::_recur_check_data($data["data"]);
		return $f;
	}
	private static function isNoNsData($data){
//		var_dump($data);exit;
		$f = true;
		$f = $f && is_array($data);
		$f = $f && array_key_exists("nsDeco", $data);
		$f = $f && array_key_exists("dsType", $data);
		$f = $f && array_key_exists("datasrc",$data);
		$f = $f && array_key_exists("namespace",$data);
		$f = $f && $data["namespace"] === false;
		$f = $f && is_array($data["nsDeco"]);
		$f = $f && array_key_exists("data", $data);
		$f = $f && is_array($data["data"]);
		return $f;
	}
	/**
	 * @return bool
	 * @param unknown $data
	 */
	private static function _recur_check_data($data){
		if(self::isPointerTodataSrc($data))return true;
		$f = true;
		$f = $f && is_array($data);
		foreach ($data as $key => $val){
			if(!$f)break;
			$f = $f && array_key_exists("text", $val);
			$f = $f && is_string($val["text"]);
			$f = $f && array_key_exists("data", $val);
			$f = $f && is_array($val["data"]);
			$f = $f && self::_recur_check_data($val["data"]);
		}
		return $f;
	}
	
	public static function checkData($data){
		return self::_recur_check_data($data);
	}
	public static function isPointerTodataSrc($data){
		return isset($data) && is_array($data) && empty($data);
	}	
	private function _sample_data(){
		return array(
			"nsDeco" => array("/aa/bb/cc","/"),
			"data" => array(
				"key1" => array(
					"text" => "text1",
					"data" => array()
				),
				"key2" => array(
					"text" => "text2",
					"data" => array()
				)
			)// or array()
		);
	}
	private function _str2keypath($path){
		$path = trim($path,"/");
		$keypath = explode("/", $path);
		return $keypath;
	}
}