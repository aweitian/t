<?php
class DBUtil{
	private $errorInfo;
	private $errorCode;
    //pdo对象  
    private $_pdo = null;  
    //用于存放实例化的对象  
    static private $_instance = null;  
      
    //公共静态方法获取实例化的对象  
    static public function getInstance() {  
        if (!(self::$_instance instanceof self)) {  
            self::$_instance = new self();  
        }  
        return self::$_instance;  
    }  
    /**
     * (non-PHPdoc)
     * @see IPdoBase::getErrorInfo()
     */
    public function getErrorInfo(){
    	return $this->errorInfo;
    }
    public function getErrorCode(){
    	return $this->errorCode;
    }    
    //私有克隆  
    private function __clone() {}  
      
    //私有构造  
    private function __construct() {  
        try {  
            $this->_pdo = new PDO(DB_DNS, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES '.DB_CHARSET));  
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
        } catch (PDOException $e) {  
            exit($e->getMessage());  
        }  
    } 
    /**
     *
     * @return last insert into id
     * @param string $sql
     * @param array $data
     */
    public function insert($sql,$data){
    	$sth=$this->_pdo->prepare($sql);
    	if(!$sth){
    		$this->errorInfo=$this->_pdo->errorInfo();
    		$this->errorCode=$this->_pdo->errorCode();
    		return 0;
    	}
    	foreach ($data as $k=>$v){
    		$sth->bindValue($k, $v,self::convert($v));
    	}
    	$sth->execute();
    	$id=$this->_pdo->lastInsertId();
    	if($id==0){
    		$this->errorInfo=$sth->errorInfo();
    		$this->errorCode=$sth->errorCode();
    	}
    	return $id;
    }
    /**
     * 返回一行:array(field1=>val1,field2=>val2,...)
     * 结果为空，返回空数组
     * @return array;
     * @param string $sql
     * @param array $data
     */
    public function fetch($sql,$data,$fetch_mode=PDO::FETCH_ASSOC){
    	$sth=$this->_pdo->prepare($sql);
    	if(!$sth){
    		$this->errorInfo=$this->_pdo->errorInfo();
    		$this->errorCode=$this->_pdo->errorCode();
    		return array();
    	}
    	foreach ($data as $k=>$v){
    		$sth->bindValue($k, $v,self::convert($v));
    	}
    	$sth->setFetchMode($fetch_mode);
    	$sth->execute();
    	$this->errorInfo=$sth->errorInfo();
    	$this->errorCode=$sth->errorCode();
    	$ret=$sth->fetch();
    	if(!is_array($ret))return array();
    	return $ret;
    }
    
    /**
     *
     * @return array;
     * @param string $sql
     * @param array $data
     */
    public function fetchAll($sql,$data,$fetch_mode=PDO::FETCH_ASSOC){
    	$sth=$this->_pdo->prepare($sql);
    	if(!$sth){
    		$this->errorInfo=$this->_pdo->errorInfo();
    		$this->errorCode=$this->_pdo->errorCode();
    		return array();
    	}
    	foreach ($data as $k=>$v){
    		$sth->bindValue($k, $v,self::convert($v));
    	}
    	$sth->setFetchMode($fetch_mode);
    	$sth->execute();
    	$this->errorInfo=$sth->errorInfo();
    	$this->errorCode=$sth->errorCode();
    	$r=$sth->fetchAll();
    	return $r;
    }
    /**
     *  插入 或者 更新 使用
     * @return affected rows
     * @param string $sql
     * @param array $data
     */
    public function exec($sql,$data){
    	$sth=$this->_pdo->prepare($sql);
    	if(!$sth){
    		$this->errorInfo=$this->_pdo->errorInfo();
    		$this->errorCode=$this->_pdo->errorCode();
    		return 0;
    	}
    	foreach ($data as $k=>$v){
    		$sth->bindValue($k, $v,self::convert($v));
    	}
    	$sth->execute();
    	$this->errorInfo=$sth->errorInfo();
    	$this->errorCode=$sth->errorCode();
    	return $sth->rowCount();
    }
    private static function convert($var){
    	if(is_null($var))return PDO::PARAM_NULL;
    	if(is_numeric($var))return PDO::PARAM_INT;
    	return PDO::PARAM_STR;
    }
}
?>