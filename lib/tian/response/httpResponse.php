<?php
/**
 * @author awei.tian
 * date: 2013-9-27
 * 说明:
 * 		depends js/css
 * 		路径为/pathtopath或者简写，简写定义在/app/conf/depends/comm.php
 */
require_once dirname(__FILE__)."/wrap/baseWrap.php";
class httpResponse{
	public $error="";
	public $output = "";
	const RESPONSE_TYPE_HTML=0;
	const RESPONSE_TYPE_JSON=1;

	
	
	public $response_type=self::RESPONSE_TYPE_HTML;

	private $contentType="php";
	private $dependJS=array();
	private $dependCSS=array();
	private $com_dep_arr_js = array();
	private $com_dep_arr_css = array();
	public function __construct(){
		if(httpRequest::isJsonAccept()){
			$this->response_type=self::RESPONSE_TYPE_JSON;
		}
		if(file_exists(ENTRY_PATH."/app/conf/dependent/js.php")){
			$this->com_dep_arr_js = require ENTRY_PATH."/app/conf/dependent/js.php";
		}
		if(file_exists(ENTRY_PATH."/app/conf/dependent/css.php")){
			$this->com_dep_arr_css = require ENTRY_PATH."/app/conf/dependent/css.php";
		}
	}
	public function _exit($msg){
		$this->output($msg);
		exit;
	}
	/**
	 * @return bool
	 * @param string $path
	 */
	public function addDependentJs($path){
		if(!is_string($path))return false;
		if(strpos($path, "/") === 0){
			$key = md5($path);
		}else{
			$key = $path;
			if(!array_key_exists($key, $this->com_dep_arr_js)){
				$path = $this->com_dep_arr_js[$key];
			}else{
				return false;
			}
		}
		if(array_key_exists($key, $this->dependJS))return true;
		if(file_exists(ENTRY_PATH.$path)){
			$this->dependJS[$key] = $path;
			return true;
		}
		return false;
	}
	/**
	 * @return bool
	 * @param string $path
	 */
	public function addDependentCss($path){
		if(!is_string($path))return false;
		if(strpos($path, "/") === 0){
			$key = md5($path);
		}else{
			$key = $path;
			if(!array_key_exists($key, $this->com_dep_arr_css)){
				$path = $this->com_dep_arr_css[$key];
			}else{
				return false;
			}
		}
		if(array_key_exists($key, $this->dependCSS))return true;
		if(file_exists(ENTRY_PATH.$path)){
			$this->dependCSS[$key] = $path;
			return true;
		}
		return false;
	}
	public function getDependentCss(){
		$css_ret="";
		foreach ($this->dependCSS as $css){
			$css_ret.='<link rel="stylesheet" href="'.$css.'"/>';
			$css_ret.="\r\n";
		}
		return $css_ret;
	}
	public function start(){
		ob_start();
	}
	public function stop(){
		$this->output = ob_get_contents();
		ob_end_clean();	
	}
	public function displayLayout($vars,$layout){
		extract($vars);
		ob_start();
		require_once $layout;
		$result=ob_get_contents();
		ob_end_clean();
		$this->output($result);
	}
	public function getDependJs(){
		$js_ret="";
		foreach ($this->dependCSS as $js){
			$js_ret.='<script language="javascript" type="text/javascript" src="'.$js.'"></script>';
			$js_ret.="\r\n";
		}
		return $js_ret;
	}
	/**
	 * 只设置HTTP STATUS
	 */
	public function _404(){
		@header('HTTP/1.x 404 Not Found');
		@header('Status: 404 Not Found');
		include_once dirname(__FILE__)."/404.tpl.php";
		exit();
	}
	public function showError($msg){
		include_once dirname(__FILE__)."/msg.tpl.php";
		exit();
	}
	public function _redirect($url){
		header("location:".$url);
		exit;
	}
	public function setResponseType($type=self::RESPONSE_TYPE_HTML){
		if($type===self::RESPONSE_TYPE_JSON)
		$this->response_type=self::RESPONSE_TYPE_JSON;
		else $this->response_type=self::RESPONSE_TYPE_HTML;
		return $this;
	}
	/**
	 * 当类型设置为JSON的时候，可以传递数组
	 * @param unknown $content
	 */
	public function output($content,IWrap $wrap=null){
		if(is_null($wrap)){
			$wrap=new baseWrap();
		}
		echo $wrap->wrap($content,$this);
	}
	public function setResponseContentType($ext){
		$this->contentType=$ext;
	}
	public function ok($msg=""){
		$wrap=new baseWrap();
		$ret=array();
		$ret["state"]="ok";
		$ret["message"]=$msg;
		return $wrap->wrap($ret,$this);
		
	}
	public function fail($msg=""){
		$wrap=new baseWrap();
		$ret=array();
		$ret["state"]="fail";
		$ret["message"]=$msg;
		return $wrap->wrap($ret,$this);
	}
	public function readLocalAsHttpContent($file_path,$assets_path_fix_schema="",$assets_path_fix_path=""){
		
		if(file_exists($file_path))
		{
			C::load(LIB_PATH."/_setting/httpResponse.php");
			$allowed_type=C::get("httpResponseAllowedFileType");
			$map_content_type=json_decode(file_get_contents( dirname(__FILE__)."/contextType.json"),true);
			
			$path_info=pathinfo($file_path);
			if(!isset($path_info["extension"])){
				$this->error="no extentsion.";
				return false;
			}
			if(!in_array(strtolower($path_info["extension"]),$allowed_type)){
				$this->error="file extension is not allowed.";
				return false;
			}
			$content_type=isset($map_content_type[strtolower($path_info["extension"])])?
			$map_content_type[strtolower($path_info["extension"])] : "application/octet-stream";

			Header("Content-type: ".$content_type);
			Header("Accept-Ranges: bytes");
			Header("Accept-Length: ".filesize($file_path));
			//Header("Content-Disposition: attachment; filename=" . $file_name);
			$file = fopen($file_path,"r"); // 打开文件
			$content=fread($file,filesize($file_path));
			if(!empty($assets_path_fix_schema)){
				if(strtolower($path_info["extension"])=="css"){
					$this->fixCssPath($content,$assets_path_fix_schema,$assets_path_fix_path);
				}
			}
			fclose($file);
			$this->output($content);
			return true;
		}else{
			$this->error="file not found,filename:".$file_path;
			return false;
		}		
		
	}
	private function fixCssPath(&$content,$assets_path_fix_schema,$file_path){
		$trans=array();
		if(preg_match_all("/url\s*\(([^\)]+)\)/", $content, $matches)){
	
			if(isset($matches[1])){
				foreach($matches[1] as $match){
					$m=trim($match," \"'");
					if(strpos("$m", "data:")===0)continue;
					$asset_path=tian::createAssetsUrl($assets_path_fix_schema."://".dirname($file_path)."/".$m);
					$trans[$match]="'".$asset_path."'";
				}
	
			}
		}
		$content=strtr($content, $trans);
	}
}