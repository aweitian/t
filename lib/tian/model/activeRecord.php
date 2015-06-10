<?php
/**
 * @author:awei.tian
 * @date:2013-12-2
 * @functions:	
 * $object->{'nameSpaces:value'}
 * AR 依靠表中良好定义的主键。如果一个表没有主键，则必须在相应的 AR 类中通过如下方式覆盖 primaryKey() 
 * 方法指定哪一列或哪几列作为主键。
public function primaryKey()
{
    return 'id';
    // 对于复合主键，要返回一个类似如下的数组
    // return array('pk1', 'pk2');
}
	
$post=new Post;
$post->create_time=new CDbExpression('NOW()');
// $post->create_time='NOW()'; 不会起作用，因为
// 'NOW()' 将会被作为一个字符串处理。
$post->save();


读取记录

// 查找满足指定条件的结果中的第一行
$post=Post::model()->find($condition,$params);
// 查找具有指定主键值的那一行
$post=Post::model()->findByPk($postID,$condition,$params);
// 查找具有指定属性值的行
$post=Post::model()->findByAttributes($attributes,$condition,$params);
// 通过指定的 SQL 语句查找结果中的第一行
$post=Post::model()->findBySql($sql,$params);






	
命名范围	
class Post extends CActiveRecord
{
    ......
    public function scopes()
    {
        return array(
            'published'=>array(
                'condition'=>'status=1',
            ),
            'recently'=>array(
                'order'=>'create_time DESC',
                'limit'=>5,
            ),
        );
    }
}
$posts=Post::model()->published()->recently()->findAll();	
Post::model()->published()->recently()->delete();
$posts=Post::model()->published()->recently(3)->findAll();







对 AR 的支持受 DBMS 的限制，当前只支持下列几种 DBMS：

MySQL 4.1 或更高版本
PostgreSQL 7.3 或更高版本
SQLite 2 和 3
Microsoft SQL Server 2000 或更高版本
Oracle


注意: AR 并非要解决所有数据库相关的任务。它的最佳应用是模型化数据表为 PHP 结构和执行不包含复杂 SQL 语句的查询。

 */



/**
 * 每个 AR 类代表一个数据表（或视图），数据表（或视图）的列在 AR 类中体现为类的属性，一个 AR 实例则表示表中的一行。
 */


/**
 * 可以先设置pk_value值
 * 然后就可以获取列名值
 * __GET规则
 * 	先获取列名，不存在就去relaction去查找
 * 存在返回这个AR实例
 * 返回null
 */
require_once LIB_PATH."/model/model.php";
abstract class activeRecord extends model{
	private $_inited=false;
	private $_inited_attr_value=false;
	private $_attribute_hash=array();
	private $_join_attribute_hash=array();
	private $_relations_hash=array();
	
	
	
	protected static $tableInfo=null;
	protected static $colInfo=null;
	protected $attributeName=null;
	
	protected $tableInfoEngine=null;
	protected $columnInfoEngine=null;
	
	
	
	
	
	/**
	 * @var IDB
	 */
	public $db=null;
	/**
	 * @var Ipdobase
	 */
	public $pdo=null;
	public $pk=null;
	
	/**
	 * 可以为a,b,c,也可以为array(1,2,3)
	 * 个数要和pk一样
	 * @var string or array
	 */
	public $pk_value=null;//不为NULL,PUT     NULL->POST
	
	/**
	 * 每次HTTP请求的缓存
	 * @var unknown
	 */
	public $kv=null;
	
	public $useColumnCommentAsLable=true;
	
	
	
	
	
	
	
	
	
	
	
	
	abstract public function tableName();
	public function __construct(){
		$this->dbConnection=tian::$context->getDb()->getDbConnection()->getConnection();
		$this->db=tian::$context->getDb();
		$this->pdo=$this->db->getPdoBase();
		$this->tableInfoEngine=$this->db->getTableInfo($this->tableName());
		$this->attributeNames();
		$this->attributeLabels();
		$this->getPrimaryKey();
		
		$this->_inited=true;
		
		
	}
	/**
	 * MASTER的PK必须和这个外键相对应
	 * 'VarName'=>array('ClassName', 'ForeignKey1,ForeignKey2,...', ...additional options)
	 * additional options:
	 * 		path 指向className的路径
	 */
	public function relations(){
		
		return array();
	}
	public function getPrimaryKey(){
		if($this->pk == null){
			$this->pk=$this->db->getTableInfo($this->tableName())->getPk();
		}
		return $this->pk;
	}
	
	/**
	 * $object->{'nameSpaces:value'}
	 * @see model::attributeNames()
	 */
	public function attributeNames(){
		if($this->attributeName != null)return $this->attributeName;
		$this->attributeName=$this->tableInfoEngine->getColumnNames();
		$this->_inited_attr_name=true;
		return $this->attributeName;
	}
	
	/**
	 * 用于findAllBySql
	 * tablename.fieldname
	 * 或者 AS xxx
	 */
	public function joinAttributeName(){
		return array();
	}
	public function joinAttributeLabels(){
		return array();
	}
	public function getJoinAttributeLabel($attribute)
	{
		$labels=$this->joinAttributeLabels();
		if(isset($labels[$attribute]))
			return $labels[$attribute];
		else
			return $this->generateAttributeLabel($attribute);
	}
	/**
	 * 如果$useColumnCommentAsLable为真
	 * 优先使用注释
	 * @see model::attributeLabels()
	 */
	public function attributeLabels(){
		$ret=array();
		if(!is_array($this->attributeName))return $ret;
		foreach ($this->attributeName as $attr){
			$colInfo=$this->db->getColumnInfo($this->tableName(), $attr);
			$tablename=$this->tableName();
			$fieldname=$attr;
			if($this->useColumnCommentAsLable){
// 				$this->setColumnInfo($attr);
				$comment=trim($colInfo->getComment());
			}else{
				$comment="";
			}
			if($comment!=""){
				$ret[$attr]=$comment;
			}else{
				$ret[$attr]=$fieldname;
			}
		}
		return $ret;
		
	}
	
	/**
	 * finds
	 */
	
	
	/**
	 * 查找满足指定条件的结果中的第一行
	 */
	public function find($condition,$params){
		return $this->RowToAr($this->findRaw($condition,$params));
	}
	public function findRaw($condition,$params){
		return $this->pdo->fetch("select * from `".$this->tableName()."` where ".$condition, $params);
	}
	/**
	 * 查找具有指定主键值的那一行
	 * @param unknown $postID
	 * @param unknown $condition
	 * @param unknown $params
	 * @throws Exception
	 * @return array
	 */
	public function findByPkCondition($pk_value,$condition,$params){
		return $this->RowToAr($this->findByPkConditionRaw($pk_value,$condition,$params));
	}
	public function findByPkConditionRaw($pk_value,$condition,$params){
		$pkwhere=$this->_parse_pk_to_where($this->getPrimaryKey(), $pk_value);
		if(is_array($params)){
			$params=$pkwhere[1]+$params;
		}else{
			$params=$pkwhere[1];
		}
		$sql="select * from `".$this->tableName()."` where ".$pkwhere[0]."";
		$sql=$sql." and ".$condition;
		$r=$this->pdo->fetch($sql, $params);
		return $r;
	}
	/**
	 * 查找具有指定主键值的那一行
	 * @param unknown $postID
	 * @param unknown $condition
	 * @param unknown $params
	 * @throws Exception
	 * @return array
	 */
	public function findByPk($pk_value){
		return $this->findByPkCondition($pk_value,"1",array());
	}
	public function findByPkRaw($pk_value){
		return $this->findByPkConditionRaw($pk_value,"1",array());
	}

	
	/**
	 * 查找具有指定属性值的第一行
	 */
	public function findByAttributes($attributes,$condition,$params){
		return $this->RowToAr($this->findByAttributesRaw($attributes,$condition,$params));
	}
	public function findByAttributesRaw($attributes,$condition,$params){
		return $this->pdo->fetch("select `".implode("`,`", $attributes)."` from `".$this->tableName()."` where ".$condition, $params);
	}
	
	/**
	 * 通过指定的 SQL 语句查找结果中的第一行
	 * 这个SQL的表应该是TABLENAME
	 * @param unknown $sql
	 * @param unknown $params
	 */
	public function findBySql($sql,$params){
		return $this->RowToAr($this->findBySqlRaw($sql,$params));
	}
	public function findBySqlRaw($sql,$params){
		return $this->pdo->fetch($sql, $params);
	}
	
	/**
	 * 获取满足指定条件的行数
	 * @param unknown $condition
	 * @param unknown $params
	 */
	public function findAll($condition,$params){
		return $this->ArrayToAr($this->findAllRaw($condition, $params));
	}
	public function findAllRaw($condition,$params){
		$r=$this->pdo->fetchAll("select * from `".$this->tableName()."` where ".$condition, $params);
		return $r;
	}
	
	/**
	 * 查找带有指定主键的所有行
	 * @param unknown $postIDs
	 * @param unknown $condition
	 * @param unknown $params
	 * @throws Exception
	 */
	public function findAllByPkCondition($pk_value,$condition,$params){
		return $this->ArrayToAr($this->findAllByPkConditionRaw($pk_value,$condition,$params));
	}
	public function findAllByPkConditionRaw($pk_value,$condition,$params){
		$pkwhere=$this->_parse_pk_to_where($this->getPrimaryKey(), $pk_value);
		if(is_array($params)){
			$params=$pkwhere[1]+$params;
		}else{
			$params=$pkwhere[1];
		}
		$sql="select * from `".$this->tableName()."` where ".$pkwhere[0]."";
		$sql=$sql." and ".$condition;
		$r=$this->pdo->fetchAll($sql, $params);
		return $r;
	}
	/**
	 * 查找带有指定主键的所有行
	 * @param unknown $postIDs
	 * @param unknown $condition
	 * @param unknown $params
	 * @throws Exception
	 */
	public function findAllByPk($pk_value){
		return $this->findAllByPkCondition($pk_value,"1",array());
	}
	public function findAllByPkRaw($pk_value){
		return $this->findAllByPkConditionRaw($pk_value,"1",array());
	}
	/**
	 * // 查找带有指定属性值的所有行
	 * @param unknown $attributes
	 * @param unknown $condition
	 * @param unknown $params
	 */
	public function findAllByAttributes($attributes,$condition,$params){
		return $this->ArrayToAr($this->findAllByAttributesRaw($attributes,$condition,$params));
	}
	public function findAllByAttributesRaw($attributes,$condition,$params){
		return $this->pdo->fetchAll("select `".implode("`,`", $attributes)."` from `".$this->tableName()."` where ".$condition, $params);
	}
	
	/**
	 * // 通过指定的SQL语句查找所有行
	 * 这个SQL的表应该是TABLENAME
	 * @param unknown $sql
	 * @param unknown $params
	 */
	public function findAllBySql($sql,$params){
		return $this->ArrayToAr($this->findAllBySqlRaw($sql,$params));
	}
	public function findAllBySqlRaw($sql,$params){
		return $this->pdo->fetchAll($sql, $params);
	}
	
	
	/**
	 * 获取满足指定条件的行数
	 */
	public function count($condition,$params){
		$r=$this->pdo->fetch("select count(*) as c from `".$this->tableName()."` where ".$condition, $params);
		if(empty($r))return 0;
		return $r["c"];
	}
	
	/**
	 * 通过指定的 SQL 获取结果行数
	 * 直接使用COUNT方法
	 * 一般统计后要立即获取这个数据
	 * @param unknown $sql
	 * @param unknown $params
	 */
	public function countBySql($sql,$params){
		return count($this->pdo->fetchAll($sql, $params));
	}
	
	/**
	 * 检查是否至少有一行符合指定的条件
	 * @param unknown $condition
	 * @param unknown $params
	 * @return bool 存在为真
	 */
	public function exists($condition,$params){
		return count($this->pdo->fetchAll("select * from `".$this->tableName()."` where ".$condition, $params))!=0;
	}
	
	
	
	
	/**
	 * save
	 * 使用同样的 save() 方法执行插入和更新操作
	 * 在操作之前先要验证数据的有效性
	 * 返回BOOL
	 * 可以用getErrors()获取出错信息;
	 */
	public function save(){
		if($this->validate()){
			if(!empty($this->pk_value)){
				return $this->updateByPk($this->pk_value, $this->attributeNames())>0;
			}else{
				//下面已经包括了PK
				$attributes=$this->attributeNames();
				$fields=array();$params=array();
				foreach ($attributes as $attr){
					$fields[$attr]=":".$attr;
					$params[":".$attr]=$this->$attr;
				}
				$sql="insert into `".$this->tableName()."` (`".implode("`,`", array_keys($fields))."`) values (".implode(",", $fields).")";
				$insert_id=$this->pdo->insert($sql, $params);
				if($insert_id>0){
					$this->pk_value=$insert_id;
					return true;
				}
				return false;
			}
		}
		return false;
	}

	
	/**
	 * @return 更新行数
	 * @param unknown $attributes
	 * @param unknown $condition
	 * @param unknown $params
	 */
	public function updateAll($attributes,$condition,$params){
		$sql="update `".$this->tableName()."` set ";
		$fields=array();
		foreach ($attributes as $attr){
			$fields[]="`".$attr."`=:".$attr."";
			$params[":".$attr]=$this->$attr;
		}
		$sql=$sql.implode(",", $fields);
		$sql=$sql." where ".$condition;
		return $this->pdo->exec($sql, $params);
	}
	
	/**
	 * @return 更新行数
	 * @param unknown $pk_value
	 * @param unknown $attributes
	 * @param unknown $condition
	 * @param unknown $params
	 */
	public function updateByPkCondition($pk_value,$attributes,$condition,$params){
		$sql="update `".$this->tableName()."` set ";
		$pk=$this->getPrimaryKey();
		$pkwhere=$this->_parse_pk_to_where($pk, $pk_value);
		if(is_array($params)){
			$params=$pkwhere[1]+$params;
		}else{
			$params=$pkwhere[1];
		}
		
		$fields=array();
		foreach ($attributes as $attr){
			$fields[]="`".$attr."`=:".$attr;
			$params[":".$attr]=$this->$attr;
		}
		
		$sql=$sql.implode(",", $fields);
		$sql=$sql." where ".$pkwhere[0]." and ".$condition;
		return $this->pdo->exec($sql, $params);
	}
	/**
	 * @return 更新行数
	 * @param unknown $pk_value
	 * @param unknown $attributes
	 * @param unknown $condition
	 * @param unknown $params
	 */
	public function updateByPk($pk_value,$attributes){
		return $this->updateByPkCondition($pk_value,$attributes,"1",array());
	}
	
	
	/**
	 * delete
	 */
	
	/**
	 * // 从数据表中删除此行
	 * @return number删除行数
	 */
	public function delete(){
		if(empty($this->pk_value)){
			return 0;
		}
		$pkwhere=$this->_parse_pk_to_where($this->pk, $this->pk_value);
		$sql="delete from `".$this->tableName()."` where ".$pkwhere[0];
		$this->pdo->exec($sql, $pkwhere[1]);
	}
	
	/**
	 * @return 删除行数
	 * @param unknown $pk_value
	 * @param unknown $condition
	 * @param unknown $params
	 */
	public function deleteByPkCondition($pk_value,$condition,$params){
		$pkwhere=$this->_parse_pk_to_where($this->pk, $pk_value);
		$sql="delete from `".$this->tableName()."` where ".$pkwhere[0]." and ".$condition;
		if(is_array($params)){
			$params=$pkwhere[1]+$params;
		}else{
			$params=$pkwhere[1];
		}
		$this->pdo->exec($sql, $params);
	}
	/**
	 * @return 删除行数
	 * @param unknown $pk_value
	 * @param unknown $condition
	 * @param unknown $params
	 */
	public function deleteByPk($pk_value){
		$this->deleteByPkCondition($pk_value,"1",array());
	}
	/**
	 * // 删除符合指定条件的行
	 * @param unknown $condition
	 * @param unknown $params
	 * @return 删除行数
	 */
	public function deleteAll($condition,$params){
		$sql="delete from `".$this->tableName()."` where ".$condition;
		$this->pdo->exec($sql, $params);
	}
	
	
	
	/**
	 * 优先获取本AR的列名值
	 * 然后获取RELATION的AR
	 * @see model::__get()
	 */
	public function __get($name){
		$hash=$this->attributeName;
		if($hash==null){
			if(!$this->_inited){
				$this->init();
				return $this->__get($name);
			}
			return null;
		}
		
		if(in_array($name, $hash)){
			//这个地方要根据PK查找唯一值
			if($this->_inited_attr_value)return $this->_attribute_hash[$name];
			if(!isset($this->_attribute_hash[$name]) || is_null($this->_attribute_hash[$name])){
				
				//是更新
				if(!is_null($this->pk_value)){
					$values=$this->findByPk($this->pk_value);
					$this->_inited_attr_value=true;
					foreach ($hash as $attr){
						$this->_attribute_hash[$attr]=isset($values[$attr])?$values[$attr]:null;
					}
				}				
			}
		
			return isset($this->_attribute_hash[$name])?$this->_attribute_hash[$name]:null;
		}
		$joinAttr=$this->joinAttributeName();
		if(in_array($name,$joinAttr)){
			if(isset($this->_join_attribute_hash[$name])){
				return $this->_join_attribute_hash[$name];
			}else{
				return null;
			}
		}
		
		$relations=$this->relations();
		if(array_key_exists($name, $relations)){
			$relation=$relations[$name];
			if(isset($relation[0],$relation[1])){
				$params=array_slice($relation,2);
				if(!class_exists($relation[0])){
					if(isset($params["path"])){
						$filepath=$params["path"];
					}else{
						$filepath=ENTRY_PATH.C::get("defaultModuleLocation")."/".$relation[0]."/model.php";
					}
					if(file_exists($filepath)){
						require_once $filepath;
					}else{
						throw new Exception("Relation model not found@activeRecord");
					}
				}
				$this->_relations_hash[$name]=new $relation[0]($this->scenario);
				$this->_relations_hash[$name]->pk=$relation[1];
				$this->_relations_hash[$name]->pk_value=$this->pk_value;
				return $this->_relations_hash[$name];	
				
			}else{
				throw new Exception("Relations Error@activeRecord.");
			}
		}
		return null;
	}
	public function __set($name,$val){
		$hash=$this->attributeName;
		if($hash==null)return;
		if(in_array($name, $hash)){$this->_attribute_hash[$name]=$val;}
		$joinAttr=$this->joinAttributeName();
		if(in_array($name, $joinAttr)){$this->_join_attribute_hash[$name]=$val;}
		$relations=$this->relations();
		if(array_key_exists($name, $relations)){$this->_relations_hash[$name]=$val;}
	}
	
	/**
	 * 把数组中的元素变成AR对象
	 * 对象是CLONE THIS
	 * @param array $data
	 * @return array
	 */
	public function ArrayToAr($data){
		foreach ($data as &$values){
			$this->RowToAr($values);
		}
		return $data;
	} 
	public function RowToAr($row){
		$o=clone $this;
		foreach ($row as $key=>$val){
			$o->$key=$val;
		}
		$row=$o;
		return $row;
	}
	private function _parse_pk_to_where($pk,$pk_value){
		if(is_array($pk)){
			if(is_string($pk_value)){
				$pk_value=explode(",", $pk_value);
			}
			if(!is_array($pk_value)){
				throw new Exception("pk_value is invalid!");
			}
			if(count($pk)!=count($pk_value)){
				throw new Exception("pk_value length must be equal to pk");
			}
			$pkwhere=array();
			$pkwhere_params=array();
			for($i=0;$i<count($pk);$i++){
				$pkwhere[]="`".$pk[$i]."`=:".$pk[$i]."";
				$pkwhere_params[":".$pk[$i]]=$pk_value[$i];
			}
			$ret=array();
			$ret[]=implode(" and ", $pkwhere);
			$ret[]=$pkwhere_params;
		}else{
			$ret=array();
			$ret[]="`".$pk."`=:".$pk."";
			$ret[]=array(":".$pk=>$pk_value);
		}
		return $ret;
	}
}