<?php
require_once LIB_PATH."/interfaces/IDbConnection.php";
class pdoConnection implements IDbConnection{
	private static $config=null;
	private static $connection=null;
	private $host;
	private $dbname;
	public $errorMsg;
	public function __construct($array){
		try{
			if(is_null(self::$connection)){
				self::$connection=new PDO(
					"mysql:host=".$array["hostname"].";dbname=".$array["database"].";port=".$array["port"], 
					$array["username"], $array["password"]
				);
				self::$config=$array;
				self::$connection->exec("SET NAMES '".$array["charset"]."'");
			
			}
		}catch (Exception $e){
			$this->errorMsg=$e->getMessage();
			exit($this->errorMsg);
		}
		$this->dbname=self::$config["database"];
		$this->host=self::$config["hostname"];			
	}
	/**
	 * (non-PHPdoc)
	 * @see lib/tian/interfaces/IDbConnection::getConnection()
	 */
	public function getConnection(){
		if(is_null(self::$connection)){
			new self(self::$config);
		}
		return self::$connection;
	}
	public function getHost(){
		return $this->host;
	}
	public function getDbname(){
		return $this->dbname;
	}
}