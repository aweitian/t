<?php
/**
 * @author awei.tian
 * date: 2013-8-10
 * 参考:
 */
require_once LIB_PATH."/interfaces/ILog.php";
class log implements ILog{
	public static function d($tag,$msg){
		$filename=self::getLogFilename();
		if(file_exists($filename)){
			$msg=file_get_contents($filename)."\n[".$tag."] #".date("H:i:s",time())."\t".$msg;
		}else{
			$msg="[".$tag."] #".date("H:i:s",time())."\t".$msg;
		}
		file_put_contents($filename, $msg);
	}
	private static function getLogFilename(){
		return ENTRY_PATH."/log/".date("Ymd",time()).".log";
	}
}