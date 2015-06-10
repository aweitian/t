<?php
/**
 * @author:awei.tian
 * @date:2013-12-24
 * @functions:
 */
C::load(LIB_PATH."/_setting/auth.php");
class authInit{
	private $tbnames;
	private $db;
	private $pdo;
	public function __construct(){
		$this->db=tian::$context->getDb();
		$this->pdo=$this->db->getPdoBase();
		$this->tbnames=require LIB_PATH."/_setting/auth.php";
		foreach($this->tbnames as $tab){
			if(!$this->db->getDbInfo()->tableExists($tab)){
				$this->init($tab);
			}
		}
	}
	private function init($tab){
		$sql="";
		switch($tab){
			case C::get("auth.privileges_collection_tablename"):
				$sql=$this->getPrivilegeCollectionSql();
				break;
			case C::get("auth.role_privilege_relations"):
				$sql=$this->getRelationsSql();
				break;
			case C::get("auth.role_infos"):
				$sql=$this->getRoleInfoSql();
				break;
		}
		$r=$this->pdo->exec($sql,array());
		if($r===false){
			$errMsg=$this->pdo->getErrorInfo();
			throw new Exception($errMsg[2]);
		}
	}
	private function getPrivilegeCollectionTableName(){
		return C::get("auth.privileges_collection_tablename");
	}
	private function getRelationsTableName(){
		return C::get("auth.role_privilege_relations");
	}
	private function getRoleInfoTableName(){
		return C::get("auth.role_infos");
	}
	private function getPrivilegeCollectionSql(){
		return "
			CREATE TABLE `".$this->getPrivilegeCollectionTableName()."` (
			  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `code` varchar(50) NOT NULL DEFAULT '0' COMMENT '代码中使用它判断',
			  `name` varchar(50) NOT NULL COMMENT '说明',
			  `comment` varchar(50) NOT NULL DEFAULT '' COMMENT '权限详细描述',
			  PRIMARY KEY (`sid`)
			) ENGINE=MyISAM AUTO_INCREMENT=503 DEFAULT CHARSET=utf8 COMMENT='系统功能表';
	
		";
	}
	
	private function getRelationsSql(){
		return "
			CREATE TABLE `".$this->getRelationsTableName()."` (
			  `rolecode` varchar(50) NOT NULL COMMENT '角色CODE',
			  `privilegecode` varchar(50) NOT NULL COMMENT '权限CODE',
			  KEY `rolesid` (`rolecode`,`privilegecode`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色功能对照表';
		";
	}
	
	private function getRoleInfoSql(){
		return "
			CREATE TABLE `".$this->getRoleInfoTableName()."` (
			  `rolecode` varchar(20) NOT NULL DEFAULT '',
			  `rolename` varchar(50) NOT NULL COMMENT '角色名',
			  `status` tinyint(1) NOT NULL DEFAULT '1',
			  `creater` int(10) NOT NULL,
			  `createtime` datetime NOT NULL,
			  `updater` int(10) NOT NULL,
			  `updatetime` datetime NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色表';
		";
	}
}