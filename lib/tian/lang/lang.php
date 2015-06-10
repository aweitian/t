<?php
/**
 * @author awei.tian
 * date: 2013-9-12
 * 说明:在pd目录下的语言文件名不要和system目录下的语言文件名一样
 * 而且键值也要不一样,建议命名:[文件名.键值]=value
 */

class lang{
	const LOC_SYS=0;
	const LOC_PD=1;
	private static $lang_dir=array();
	private static $lang_data=array();
	private static $lang_name="cn";
	public static function t($name="",$var=array()){
		$name = strtoupper($name);
		if(empty($name))return self::$lang_data;
		return isset(self::$lang_data[$name]) ? self::replaceStringVar(self::$lang_data[$name],$var) : $name;
	}
	public static function change($new_lang_name){
		self::$lang_name=$new_lang_name;
		self::$lang_dir=array();
		self::$lang_data=array();
		self::_add_sys_lang_dir();
	}
	/**
	 * 根据路径+文件名的方法来包含
	 * 根据已知目录顺序来包含
	 */
	public static function import($filename,$loc=self::LOC_SYS){
		self::_add_sys_lang_dir();
		if($loc===self::LOC_PD)self::_add_pd_lang_dir();
		foreach (self::$lang_dir as $dir){
			if(file_exists($dir."/".$filename.".php")){
				$data=require_once $dir."/".$filename.".php";
				if(is_array($data)){
					self::$lang_data=array_merge(self::$lang_data, array_change_key_case($data, CASE_UPPER));
				}
			}
		}
	}
	private static function _add_sys_lang_dir(){
		if(!in_array(LIB_PATH."/_setting/lang/".self::$lang_name."", self::$lang_dir)){
			self::$lang_dir[]=LIB_PATH."/_setting/lang/".self::$lang_name."";
		}
	}
	private static function _add_pd_lang_dir(){
		if(!in_array(ENTRY_PATH."/pd/lang/".self::$lang_name."", self::$lang_dir)){
			self::$lang_dir[]=ENTRY_PATH."/pd/lang/".self::$lang_name."";
		}
	}
	public static function replaceStringVar($str,$var){
		if(is_array($var)){
			if(preg_match_all("/\{[$](\w+)(?:\|(.*?))?\}/", $str, $matches)){
				if(count($matches)===3){
					$ret=$str;
					foreach ($matches[0] as $key=>$raw_replacement){
						$ret=str_replace(
								$raw_replacement, 
								array_key_exists($matches[1][$key], $var)?$var[$matches[1][$key]]:$matches[2][$key],
								$ret
						);
					}
					return $ret;
				}
			}	
		}
		return $str;
	}
}