<?php
/**
 * @author:awei.tian
 * @date: 2014-12-10
 * @functions:
 */
require_once ENTRY_PATH."/app/data/datasrc/DataSrcPath.php";
require_once ENTRY_PATH."/app/data/datasrc/ADataSrc.php";
class DataSrc_nsdata extends ADataSrc{
	/**
	 * 默认数据类型为DBDATA
	 * Enter description here ...
	 * @param unknown_type $data
	 * @param unknown_type $datamode
	 */
	public function __construct($data,$datamode = "dbdata"){
		if($datamode == "dbdata"){
			$this->data = self::convertDbDataToNsdata($data);
		}else{
			$this->data = $data;
		}
		if(!self::check($this->data)){
			if(DEBUG_FLAG){
				var_dump($data);
			}
			throw new Exception("illegal data",0x785);
		}
	}
	public function getId(){
		return "nsdata";
	}
	/**
	 * /key1/key2/key3
	 * /kk1/kk2,kk4
	 * @return array:
	 */
	public function getAllLeafPath(){
		$ret = array();
		$this->_getAllLeafPath($this->data["data"],"",$ret);
		return $ret;
	}	
	public function getData($path){
// 		var_dump($this->data);exit;
		if(!array_key_exists($path, $this->data["datasrc"])){
//			var_dump($this->data);exit;
			if($path == "" && $this->data["namespace"] === false && array_key_exists("/", $this->data["datasrc"])){
				return $this->data["datasrc"]["/"];
			}
			throw new Exception("invalid path:".$path, 0x2);
		}
		return $this->data["datasrc"][$path];
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
	/**
	 * @see datasrc_nsInfo.txt
	 * Enter description here ...
	 * @param unknown_type $dbdata
	 */
	public static function convertDbDataToNsdata($dbdata){
// 		var_dump($dbdata);exit;
		$data = array();
		$datasrc = array();
		foreach($dbdata as $row){
			$tr = &$data;
			$path = $row["path"];
			$tmp = trim($path,"/");
			$tmp = explode("/",$tmp);
//			var_dump($tmp);exit;
			if($row["namespace"]){//数据分类
				for($i=0;$i<count($tmp)-1;$i++){
					if(isset($tr[$tmp[$i]]) && is_array($tr[$tmp[$i]])){
						$tr = &$tr[$tmp[$i]]["data"];
					}else{
	//					var_dump($tr[$tmp[$i]],$tmp[$i]);exit;
						throw new Exception("invalid path:".$path,0x9);
					}
				}
				$tr[$tmp[$i]] = array("text"=>$tmp[$i],"data"=>array());	
				if($row["nt"] == "file")$datasrc[$path] = $row["data"];			
			}else{//数据不分类
				$datasrc["/"] = $row['data'];
			}
		}
		$dec = $dbdata[0]["deco"];
		$namespace = $dbdata[0]["namespace"];
		if(is_string($dec)){
			$dec = explode(",", $dec);
		}else{
			$dec = array();
		}
		return array("namespace"=>$namespace,"nsDeco"=>$dec,"dsType"=>$dbdata[0]["dstype"],"datasrc"=>$datasrc,"data"=>$data);
	}
	private function _getAllLeafPath($src,$path="",&$ret){
		if(self::isPointerToBasedatasrc($src)){$ret[] = $path;return true;}
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

	public static function check($data){
		return self::isValid($data);
	}
	public static function isValid($data){
		if(self::isNoNsData($data))return true;
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
		if(self::isPointerToBasedatasrc($data))return true;
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
	
	
	public static function isPointerToBasedatasrc($data){
		return isset($data) && is_array($data) && empty($data);
	}	
	private function _sample_data(){
		return array(
			"nsDeco" => array("/aa/bb/cc","/"),
			"dsType" => "22ld",
			"namespace" => true,
			"datasrc"=>array(
				"/p1/p2" => array("data"),
				"/p1/p3" => array("22ld data")
			),
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