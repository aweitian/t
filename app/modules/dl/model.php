<?php
/**
 * Date: 2016-01-11
 * Author: Awei.tian
 * Description: 
 */
class dlModel extends model{
	
	public function __construct(){
		parent::__construct();
	}
	public function test(){
		return "hi";
	}
	public function getData($uid){
		$h = array_combine($_POST["col"], $_POST["col"]);
		$fields = array();
		foreach (array("url","result","ma_word","rawhtml","str_content") as $col){
			if(array_key_exists($col, $h)){
				$fields[] = '`'.$col.'`';
			}
		}
		$sql = "SELECT " . join(",",$fields) . " FROM `results` where `uid`=:uid";
		$data = $this->db->fetchAll($sql, array("uid"=>$uid));
		return $data;
	}
}