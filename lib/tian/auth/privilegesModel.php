<?php
/**
 * @author: awei.tian
 * @date: 2013-12-18
 * @function:
 */

require_once LIB_PATH.'/model/activeRecord.php';
C::load(LIB_PATH."/_setting/auth.php");
require_once dirname(__FILE__)."/auth.php";
class privilegesModel extends activeRecord{
	public $code;
	public $name;
	public $comment;
	public $sid;
	public function rules() {
		return array(
				array('code, name', 'required'),
				array('code', 'length', 'maxSize'=>20),
				array('name', 'length', 'maxSize'=>50),
				array('code', 'checkcode'),
		);
	}
	public function attributeLabels(){
		return array(
			"sid"=>"主键",
			"code"=>"权限代码",
			"name"=>"权限名称",
			"comment"=>"权限描述"
		);
	}
	public function tableName(){
		return C::get("auth_privileges_collection_tablename"); 
	}
	public function checkcode($attr,$params){
		$value=$this->$attr;
		if($value==auth::AUTH_CODE_SYSTEM){
			$this->addError("code", "SYSTEM is not allowed");
			return false;
		}
		$r=preg_match("/^\w+$/", $value);
		if(!$r){
			$this->addError("code", "format is not matched");
		}
		return $r;
	}	
}