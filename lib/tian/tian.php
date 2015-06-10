<?php
/**
 * 框架入口文件
 * 作用：context
 */
class tian{
	/**
	 * 
	 * Enter description here ...
	 * @var Icontext
	 */
	public static $context=null;
	private static $hashtable = "abcdefghjkmnpqrstuwxyz0123456789";
	private function __construct(){
	}
	static public function init(){
		// 设定错误和异常处理
		register_shutdown_function(array('tian','fatalError'));
		set_error_handler(array('tian','appError'));
		set_exception_handler(array('tian','appException'));
		// 注册AUTOLOAD方法
		spl_autoload_register(array('tian', 'autoload'));
		self::initEnvir();
		return ;
	}
	private static function initEnvir(){
		
		self::getContext();
	}
	public static function getContext(){
		if(is_null(self::$context)){
			if(ENVIR==ENVIR_COMMON){
				require_once LIB_PATH."/context/commonContext.php";
				self::$context=new commonContext();
			}
			elseif (ENVIR==ENVIR_SAE){
				require_once LIB_PATH."/context/saeContext.php";
				self::$context=new saeContext();
			}
			elseif (ENVIR==ENVIR_BAE){
				require_once LIB_PATH."/context/baeContext.php";
				self::$context=new baeContext();
			}
			elseif (ENVIR==ENVIR_OPENSHIFT){
				require_once LIB_PATH."/context/openshiftContext.php";
				self::$context=new openshiftContext();
			}
		}
		return self::$context;
	}
	/**
	 * 系统自动加载类库
	 * 并且支持配置自动加载路径
	 * @param string $class 对象类名
	 * @return void
	 */
	public static function autoload($class){
		$path=C::getAutoloadPath();
		if(array_key_exists($class,$path)){
			$p=$path[$class];
			if(file_exists($p)){
				require_once $p;
			}
		}
	}
	
	/**
	 * 如果存在同一名字的路由和DISPATCHER，优先使用名字相同的DISPATCHER
	 * 一个DISPATCHER失败了，不会用下一个DISPATCHER
	 */
	public static function dispatch(){
		$route_name=self::$context->getRouter()->getMatchedRouteName();
		//var_dump(self::$context->getDispatcher($route_name));
		return self::$context->getDispatcher($route_name)->dispatch();
	} 
	/**
	 * 自定义异常处理
	 * @access public
	 * @param mixed $e 异常对象
	 */
	static public function appException($e) {
		$error = array();
		$error['message']   = $e->getMessage();
		$trace  = $e->getTrace();
	
		$error['file']      = $e->getFile();
		$error['line']      = $e->getLine();
	
		self::$context->loadLog();
		log::d("APPEXCEPTION", $error['message']);
		if(DEBUG_FLAG){
			var_dump($error);
			exit;
		}
	}
	/**
	 * 自定义错误处理
	 * @access public
	 * @param int $errno 错误类型
	 * @param string $errstr 错误信息
	 * @param string $errfile 错误文件
	 * @param int $errline 错误行数
	 * @return void
	 */
	static public function appError($errno, $errstr, $errfile, $errline) {
		switch ($errno) {
			case E_ERROR:
			case E_PARSE:
			case E_CORE_ERROR:
			case E_COMPILE_ERROR:
			case E_USER_ERROR:
				ob_end_clean();
				// 页面压缩输出支持
				$errorStr = "$errstr ".$errfile." $errline lines.";
				self::getContext()->loadLog();
				log::d("APPERROR",$errorStr);
				exit('ERROR:'.$errorStr);
				break;
			case E_STRICT:
			case E_USER_WARNING:
			case E_USER_NOTICE:
			default:
				$errorStr = "[$errno] $errstr ".$errfile." $errline lines.<br>";
				echo ($errorStr);
				break;
		}
	}
	
	// 致命错误捕获
	static public function fatalError() {
		// 保存日志记录
		if ($e = error_get_last()) {
			switch($e['type']){
				case E_ERROR:
				case E_PARSE:
				case E_CORE_ERROR:
				case E_COMPILE_ERROR:
				case E_USER_ERROR:
					exit('<font color="red">ERROR:</font>'.$e['message']);
					break;
			}
		}
	}
	/**
	 * @param $assets_path likes LIB_PATH://resource/contextType.json
	 * VENDOR_PATH://Validation/js/jquery.validationEngine.min.js
	 */
	public static function createAssetsUrl($assets_path){
		require_once LIB_PATH."/resource/assetsManager.php";
		return new assetsManager($assets_path);
	}
	/**
	 * 根据默认路由来创建URL
	 */
	public static function createUrl($url){
		C::load(LIB_PATH."/_setting/defaultRoute.php");
		$pathFrom=C::get("defaultRoutePathFrom");
		$defaultRoutePathFromQueryStringPlaceHolder=C::get("defaultRoutePathFromQueryStringPlaceHolder");
		if(is_string($url)){
			$url=strtolower($url);
			
			if(substr($url, 0,7)=="http://" || substr($url, 0,8)=="https://" || substr($url, 0,2)=="//")return $url;
			
			if($pathFrom==urlManager::PATH_FROM_QUERYSTRING){
				return ENTRY_HOME."?".$defaultRoutePathFromQueryStringPlaceHolder."=".$url;
			}else{
				//var_dump($url);
				return ENTRY_HOME."/".trim($url,"/");
			}
		}
		$router=self::$context->getRouter();
		$urlbuilder=$router->getRoute()->getUrlManager();
		if(!is_array($url)){
			throw new Exception("create url param url only accept type string or array");
		}
		if(count($url)==1){
			$urlbuilder->setAction($url[0]);
			return $urlbuilder->toUrl();
		}else if(count($url)==2){
			$urlbuilder->setControl($url[0]);
			$urlbuilder->setAction($url[1]);
			return $urlbuilder->toUrl();
		}else if(count($url)==3){
			$urlbuilder->setModule($url[0]);
			$urlbuilder->setControl($url[1]);
			$urlbuilder->setAction($url[2]);
			return $urlbuilder->toUrl();
		}
		
	}
	/**
	 * $url as array
	 * #Module,Control,Action
	 * *temp var
	 * :pathinfo
	 * ?querystring
	 * @param unknown $url
	 * @param string $route_name
	 */
	public static function createUrlOnMsg($url,$route_name=""){
		$msg=tian::$context->getMessage();
		foreach ($url as $key=>$val){
			$msg[$key]=$val;
		}
		return $msg->getUrlManager()->toUrl();
	}

	//2015-3-25添加加密解密函数
	/**
     * 基于3des加密后返回BASE32方式编码
     */
	public static function encrypt($input, $key) {
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $input = Security::pkcs5_pad($input, $size);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = self::encode($data);
        return $data;
    }
    /**
     * 基于BASE32方式编码
     */
    public static function encode($s){
        $i = 0;$prev=0;$ascii=0;$mod=0;
        $result = array();
        while($i<strlen($s)){
            $ascii=ord($s[$i]);
            $result[]=str_pad(decbin($ascii), 8, "0", STR_PAD_LEFT);
            $i++;
        }
        $_t = str_split(join("",$result),5);
        $len = count($_t);
        $result=array();
        foreach($_t as $val){
            $result[]=self::$hashtable[bindec($val)];   
        }
        return strlen($_t[$len-1]).join("",$result);
    }
    /**
     * 基于BASE32方式解码
     */
    public static function decode($s){
        $i = 1;$prev=0;$ascii=0;$mod=0;$cur;
        $result = array();
        while($i<strlen($s)){
            $cur=strpos(self::$hashtable,$s[$i]);
            $result[]=str_pad(decbin($cur), 5, "0", STR_PAD_LEFT);
            $i++;
        }
        $len = count($result);
        $result[$len-1] = substr($result[$len-1],5-$s[0]);
        $_t = str_split(join("",$result),8);
        $len = count($_t);
        $result=array();
        foreach($_t as $val){
            $result[]=chr(bindec($val));    
        }
        return join("",$result);
    }
    private static function pkcs5_pad ($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }
 	/**
     * 基于BASE32方式解码后用3des解密后返回明文
     */
    public static function decrypt($sStr, $sKey) {
        $decrypted= mcrypt_decrypt(
            MCRYPT_RIJNDAEL_128,
            $sKey,
            self::decode($sStr),
            MCRYPT_MODE_ECB
        );
        $dec_s = strlen($decrypted);
        $padding = ord($decrypted[$dec_s-1]);
        $decrypted = substr($decrypted, 0, -$padding);
        return $decrypted;
    }
}
