<?php
/**
 * @author awei.tian
 * date: 2013-8-18
 * 参考:thinkphp[thinkphp.cn]
 * 有了对象不能说明函数就没有用处了，就像原来的GOTO，不能多用，但偶尔用下也不错。
 * 如现在的EXCEPTION不就像过去的GOTO
 */
/**
 * 用.做为数组子元素访问
 * @param string $name
 * @return void|multitype:|string
 * 功能:空返回当前配置数组，
 * 		第一个参数是字符串,用.做为数组子元素访问
 1)$value不是NULL，以name为KEY，存储，NAME要符合\w+
 2)KEY存在返回，
 3)否则返回NULL
 第一个参数是数组
 合并数组,如果输入的数组中有相同的字符串键名，则该键名后面的值将覆盖前一个值。
 然而，如果数组包含数字键名，后面的值将不会覆盖原来的值，而是附加到后面。
 如果只给了一个数组并且该数组是数字索引的，则键名会以连续方式重新索引。

 */
class C{
	private static $_config=array();
	private static $_autoload=array();
	/**
	 * 加载文件
	 */
	public static function load($filename){
		if(file_exists($filename)){
			$v=require_once $filename;
			if(is_array($v))self::add($v);
		}
		return null;
	}
	public static function addAutoloadPath($classname,$path){
		self::$_autoload=array_merge(self::$_autoload,array($classname=>$path));
	}	
	public static function getAutoloadPath(){
		return self::$_autoload;
	}
	public static function add($array){
		self::$_config = array_merge(self::$_config, $array);
	}
	public static function get($name){
		$_config=&self::$_config;
		if (empty($name))
			return $_config;
		if (is_string($name)) {
			$name = explode(".", trim($name,"."));
			$val=null;$t=$_config;
			for($i=0;$i<count($name)&&isset($t[$name[$i]]);$i++){
				$t=$t[$name[$i]];
			}
			if($i==count($name))return $t;
			return null;
		}
		return null;
	}
	public static function set($name,$value){
		$_config=&self::$_config;
		if(!is_null($value)){
			$name=preg_replace("/[^\w]/", "", $name);
			$_config[$name]=$value;
			return;
		}
	}
}
/**
 * @package function.php
 * @author Administrator
 *
 */
class util{
	public static function getClientIp(){
		$ip = $_SERVER["REMOTE_ADDR"];
		if(substr($ip,0,7) === "192.168"){
			$ip = getenv("HTTP_X_Forwarded_For");
			if(strpos($ip, ",") !== false){
				$ips = explode(",",$ip);
				$ip = $ips[sizeof($ips)-1];
			}
		}
		return($ip);
	}
	public static function getDirList($dir){
		$ret=array();
		if(!$handle = @opendir($dir)){
			return false;
		}
		while (false !== ($file = @readdir($handle))) {
			if($file==".")continue;
			if($file=="..")continue;
			$p = $dir.DIRECTORY_SEPARATOR.$file;
			if (is_dir($p)){
				$ret[]=$file;
			}
		}
		return $ret;
	}
	/**
	 * 
	 * 获取目录下所有孩子文件,后台的参数大小写不区分
	 * @param $dir
	 * @param $ext_filter 排除前面用!txt,ini.
	 */
	public static function getFileList($dir,$ext_filter=""){
		$ret=array();
		if(!$handle = @opendir($dir)){
			return false;
		}
		$filter=array();
		$filter_mode="include";
		if(is_string($ext_filter) && $ext_filter!=""){
			if(substr($ext_filter, 0,1)=="!"){
				$filter_mode="exclude";
				$filter=substr($ext_filter, 1);
			}else{
				$filter=explode(",", $ext_filter);
			}
		}
		while (false !== ($file = @readdir($handle))) {
			if($file==".")continue;
			if($file=="..")continue;
			$p = $dir.DIRECTORY_SEPARATOR.$file;
			if (is_file($p)){
				if($filter!=""){
					$p=explode(".", $file);
					if(is_array($p)){
						if($filter_mode=="include"){
							foreach ($filter as $f){
								if(strtolower(end($p))==strtolower($f))$ret[]=$file;
							}
						}else{
							foreach ($filter as $f){
								if(strtolower(end($p))!=strtolower($f))$ret[]=$file;
							}
						}
					}
				}else{
					$ret[]=$file;
				}
				
			}
		}
		return $ret;
	}
	public static function substr($str,$start,$length){
		if(function_exists("mb_substr")){
			return mb_substr($str,$start,$length,"utf-8");
		}else{
			return substr($str,$start,$length);
		}
	}
	/**
	 * js escape php 实现
	 * @param $string           the sting want to be escaped
	 * @param $in_encoding
	 * @param $out_encoding
	 */
	public static function escape($string, $in_encoding = 'UTF-8',$out_encoding = 'UCS-2') {
		$return = '';
		if (function_exists('mb_get_info')) {
			for($x = 0; $x < mb_strlen ( $string, $in_encoding ); $x ++) {
				$str = mb_substr ( $string, $x, 1, $in_encoding );
				if (strlen ( $str ) > 1) { // 多字节字符
					$return .= '%u' . strtoupper ( bin2hex ( mb_convert_encoding ( $str, $out_encoding, $in_encoding ) ) );
				} else {
					$return .= '%' . strtoupper ( bin2hex ( $str ) );
				}
			}
		}
		return $return;
	}
	/**
	 * 数组的键值必须是从0到长度-1顺序排列
	 */
	public static function isDigitalSeqArray($arr){
		return is_array($arr) && array_keys($arr) === range(0, count($arr) - 1);
	}
	public static function isInt($int){
		return is_int($int) || (is_string($int) && is_numeric($int) && preg_match("/^\d+$/",$int));
	}
	/**
	 * 
	 * 把/zz/bb/cc变成/zz/bb/newkey
	 * @param string $oldpath
	 * @param string $newkey
	 */
	public static function getNewPath($oldpath,$newkey){
		if($oldpath===DIRECTORY_SEPARATOR)return $oldpath;
 		$p=dirname($oldpath);
 		if($p===DIRECTORY_SEPARATOR){
 			return "/".$newkey;
 		}
 		return $p."/".$newkey;
	}
}
