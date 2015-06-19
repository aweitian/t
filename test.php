<?php
define("DEBUG_FLAG", TRUE);
if(DEBUG_FLAG){
	error_reporting(E_ALL);
	ini_set("display_errors","On");
}else{
	error_reporting(0);
	ini_set("display_errors","Off");
}
abstract class filePath{
	public $errMsg;
	public $errCode;
	protected $cur;
	/**
	 * 
	 * @param string $cur ¾ø¶ÔÂ·¾¶
	 */
	public function __construct($cur){
		if(!$this->isAbsolutePath($cur)){
			throw new Exception("only absolute path accepted.",0x8812);
		}
		$this->cur = $cur;
	}
	abstract public function exists($filename);
	public function up(){
		if($this->isRoot())return ;
		$cur = dirname($this->cur);
		if($cur == DIRECTORY_SEPARATOR){
			$cur = '/';
		}
		$this->cur = $cur;
		return $this;
	}
	public function open($filename){
		if($filename == ".")return ;
		if($filename == "..")return $this->up();
		if(!$this->isValidFilename($filename)){
			throw new Exception("invalid filename",0x8811);
		}
		if($this->exists($filename)){
			if($this->isRoot()){
				$this->cur = '/' . $filename;
			}else{
				$this->cur = $this->cur . '/' . $filename;
			}
		}
	}
	public function entry($path){
		$bak = $this->cur;
		$this->linuxPath($path);
		if($path !== '/'){
			$path = rtrim($path,'/');
		}
		try{
			if($this->isAbsolutePath($path)){
				$this->cur = '/';
				$path = substr($path, 1);
			}
			$pathArr = explode('/', $path);
			//var_dump($pathArr);exit;
			foreach ($pathArr as $item){
				$this->open($item);
			}
			return true;
		}catch (Exception $e){
			$this->errCode = $e->getCode();
			$this->errMsg  = $e->getMessage();
			$this->cur = $bak;
			return false;
		}
	}
	public function isRoot(){
		return $this->cur == DIRECTORY_SEPARATOR;
	}
	public function isValidFilename($filename){
		return $filename != "" && strpos($filename, '/') === false;
	}
	public function isAbsolutePath($path){
		return $path[0] === '/';
	}
	public function linuxPath($path){
		return str_replace('\\','/',$path);
	}
	public function getPath(){
		return $this->cur;
	}
}

class filePathTest extends filePath{
	
	public function exists($filename){
		return true;	
	}
	public function debug(){
		print $this->cur;
		print '<br>';	
	}
}

$demo = new filePathTest("/home");
$demo->debug();
$demo->open("qq");
$demo->debug();
$demo->entry("/../tty/d../kdke/ww/wie/../qqie/ie/d/dx/");
$demo->debug();