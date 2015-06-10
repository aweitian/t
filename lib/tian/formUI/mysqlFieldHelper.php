<?php
/**
 * @author:awei.tian
 * @date:2013-12-13
 * @functions:tableName,initAr[add,edit],enum_set_kvp[has set enum type],
 * fieldsOnScenario,fieldsExceptScenario
 */
require_once dirname(__FILE__)."/fieldsManifest.php";
// CREATE TABLE `tony_zzzzz` (
//   `a` TEXT NOT NULL,
//   `b` DATETIME NOT NULL,
//   `c` DATE NOT NULL,
//   `d` ENUM('a','b') NOT NULL,
//   `e` SET('a','b','c') NOT NULL,
//   `f` VARBINARY(20) NOT NULL,
//   `g` VARCHAR(10) NULL,
//   `h` INT(11) DEFAULT '0'
// ) ENGINE=INNODB DEFAULT CHARSET=utf8
class mysqlFieldHelper{
	public static $typeArr = array(
		"textarea"=>"text",
		"input_datetime"=>"datetime",
		"input_date"=>"date",
		"enum"=>"enum",
		"set"=>"set",
		"input_file"=>"varbinary",
		"input_str"=>"varchar",
		"input_num"=>"int"
	);
	public static function db2ui($type){
		switch($type){
			case "text":
			case "tinyblob":
			case "tinytext":
			case "blob":
			case "mediumblob":
			case "mediumtext":
			case "longblob":
			case "longtext":
				return "textarea";
			case "datetime":
			case "timestamp":
				return "input_datetime";
			case "date":
			case "time":
			case "year":
				return "input_date";
			case "enum":
				return "enum";
			case "set":
				return "set";
	
			case "binary":
			case "varbinary":
				return "input_file";
			case "varchar":
			case "char":
				return "input_str";
			case "tinyint":
			case "smallint":
			case "int":
			case "bigint":
			case "float":
			case "double":
			case "decimal":
			case "mediumint":
				return "input_num";
			default:
				return "input_str";
		}
	}
	public static function ui2db($type){
		if(array_key_exists($type, self::$typeArr)){
			return self::$typeArr[$type];
		}
		return "varchar";
	}
}