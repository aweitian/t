<?php
/**
 * Date: 2014-9-18
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/uipatch/AUipatch.php";
require_once ENTRY_PATH."/app/data/datasrc/dataSrc.php";
require_once ENTRY_PATH."/app/data/conf/AConf.php";
require_once ENTRY_PATH."/app/data/datasrc/ADataSrc.php";
require_once ENTRY_PATH."/lib/extend/d2calc/d2calc.php";
class uipatch_nsselector extends AUipatch{
	private $default_keypath = array();
	private $current_keypath = array();
	private $namespace_data = array();
	private $data;
	private $tpl;
	/**
	 * @var DataSrc_ns
	 */
	public $src;
	/**
	 * 生成一个UI。通过这个UI可以得到一个NAMESPACE PATH
	 */
	public function __construct($data,$path=""){
		if($data instanceof DataSrc_ns){
			$this->data = $data->data;
			$this->src = $data;
		}else{
			$this->data = $data;
			$this->src = new DataSrc_ns($data);
	 		if(!DataSrc_ns::isValid($data)){
	 			throw new Exception("invalid data");
	 		}			
		}
 		if($path != ""){
	 		$this->setCurrentKeypath($path)	;		
 		}else{
 			$this->_buildDefaultKeypath();
 			$this->_buildNamespaceData();
 		}
	}
	/**
	 * array(
	 * 		"key"=>array(
	 * 			"name"=>"",
	 * 			"html"=>"html...."
	 * 		),
	 * 		...
	 * )
	 * @see AUipatch::getData()
	 */
	public function getData(){
		return $this->_getnamespacehtml();
	}
	public function getNamespaceData(){
		return $this->namespace_data;
	}
	private function _getnamespacehtml(){
		$data = array();
		$ns_val = $this->getCurrentNamespaceWrap();
		$ns_dat = $this->namespace_data;
		$i = 0;
// 		var_dump($ns_val,$ns_dat);exit;
		foreach ($ns_val as $k => $v){
			$options = "";
			foreach ($ns_dat[$i] as $kv){
				$options .= strtr('<option value="{optionkey}"{selected}>{optionval}</option>',array("{optionkey}"=>$kv[0],"{optionval}"=>$kv[1],"{selected}"=>$kv[0]===$this->current_keypath[$i] ? " selected":""));//"<option value='".."'>".."</option>";
			}
			//这里生成的HTML在app/widgets/spancal|calc/tpl.php中按照这格式把$k替换成了_$k
			$data[$k] = array(
				"name"=>$v,
				"html"=> '<select name="'.$k.'">'.$options.'</select>'
			);
			$i++;
		}
//		var_dump($data);exit;
		return $data;
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
	public function getCurrentNamespaceWrap(){
		$current_keypath = $this->current_keypath;
		return $this->src->getCurrentNamespaceWrap($current_keypath);
	}
	
	public function setCurrentKeypath($path){
		if(!$this->_isvalidkeypath($path)){
			throw new Exception("invalid keypath");
		}
		$this->_buildNamespaceData();
	}
	public function getCurrentKeypath(){
		if(!$this->src->getNamespaceUseMode())return "/";
		return $this->current_keypath;
	}
	public function getCurrentKeypathStr(){
		if(!$this->src->getNamespaceUseMode())return "/";
		if(empty($this->current_keypath))return "/";
		return "/".join("/",$this->current_keypath);
	}
	private function _buildDefaultKeypath($src=null){
		if(!$this->src->getNamespaceUseMode())return ;
		if(is_null($src)){
			$this->current_keypath = array();
			$src = $this->data["data"];
		}
		if(DataSrc_ns::isPointerTodataSrc($src)){
			return;
		}
		foreach ($src as $key => $val){
			$this->current_keypath[] = $key;
			return $this->_buildDefaultKeypath($val["data"]);
		}
	}
	private function _buildNamespaceData($src=null,$deep = 0){
		if(!$this->src->getNamespaceUseMode())return ;
		if(DataSrc_ns::isPointerTodataSrc($src))return;
		if(is_null($src))$src = $this->data["data"];
		//sample data
		if(empty($this->current_keypath))return ;
		$childkey = $this->current_keypath[$deep];$this->namespace_data[$deep] = array();
		foreach ($src as $key => $val){
			$this->namespace_data[$deep][] = array($key,$val["text"]);
		}
		return $this->_buildNamespaceData($src[$childkey]["data"],$deep+1);
	}
	private function _isvalidkeypath($path){
		$keypath = $this->_str2keypath($path);
		$keypath_len = count($keypath);
		$arr = $this->data["data"];
		$i = 0;
		if($keypath_len == 0){
			return DataSrc_ns::isPointerTodataSrc($arr);
		}
		while($i<$keypath_len && array_key_exists($keypath[$i], $arr)){
			$arr = $arr[$keypath[$i]]["data"];
			if($i+1 == $keypath_len){
				if(DataSrc_ns::isPointerTodataSrc($arr)){
					$this->current_keypath = $keypath;
					return true;
				}else{
					//如果路径只设置前一部分,剩下用户默认填充
					if(DataSrc_ns::checkData($arr)){
						$this->current_keypath = array_merge($keypath,$this->_str2keypath(DataSrc_ns::getFirstLeafPath($arr)));
						return true;
					}
				}
			}
			$i++;
		}
		return false;
	}
	private function _str2keypath($path){
		$path = trim($path,"/");
		$keypath = explode("/", $path);
		return $keypath;
	}
}