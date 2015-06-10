<?php
class cssView extends view{
	protected $engine;
	private $error = 0;
	private $css_cache_name = "css.css";
	private $kv;
	public function getLastError(){
		return $this -> error;
	}
	public function __construct(){
		$this -> engine = $this -> getEngine();
		$this->kv=tian::getContext()->getKv();
		require_once LIB_PATH."/components/color/ColorConvert.php";
	}
	public function welcome($data){
		$this->css_cache_name = "css.css";
		$css_template_path_dirs = array(
			ENTRY_PATH."/pd/html/960gs",
			ENTRY_PATH."/pd/html/css"
		);
		return $this->_parse($this->css_cache_name,$css_template_path_dirs,$data);
	}
	public function clear(){
		$this->kv->delete($this->_path_kvkey("css.css"));
	}
	private function cacheCss($content){
		$this->kv->set(
			$this->_path_kvkey($this->css_cache_name),
			$content
		);
	}
	private function _parse($css_cache_name,$css_template_path_dirs,$data){
		header("Content-Type:text/css");
		if($content=$this->kv->get($this->_path_kvkey($css_cache_name))){
			echo $content; 
			return;
		}
		$cipher = "/*".CSS_SIGNATURE_CODE."*/";
		$convert = new ColorConvert();
		$css_template_arr = array();
		$lastresult="";
		foreach ($css_template_path_dirs as $css_template_path_dir){
			if(!$handle = @opendir($css_template_path_dir)){
				return false;
			}
			while (false !== ($file = @readdir($handle))) {
				if($file==".")continue;
				if($file=="..")continue;
				$file = $css_template_path_dir.DIRECTORY_SEPARATOR.$file;
				if (is_file($file)){
					$string = file_get_contents($file);
					if(substr($string,0,strlen($cipher)) === $cipher){
						$css_template_arr[] = $file;	
					}
				}
			}
			$this -> engine -> assign('s',$data);
			$this -> engine -> assign('convert',$convert);
			$ret=array();
			$retname = array();
			foreach($css_template_arr as $val){
				$name = explode(".", $val);//("[\\\/]",$val);
				$ret[] = str_replace("/*CSS_SIGNATURE_CODE*/", "", $this -> engine -> fetch($val));	
				$retname[] = "/*--".str_replace($css_template_path_dir.DIRECTORY_SEPARATOR,"",$name[0])."--*/";	
			}
			$lastresult.= join("\r\n",$retname)."\r\n/*-----------------------------------*/\r\n".join("\r\n", $ret);	
			
		}
		$this->cacheCss($lastresult);
		echo $lastresult;
	}
	private function _path_kvkey($path){
		return "control_css.".md5($path);
	}
}