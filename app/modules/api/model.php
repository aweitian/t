<?php
/**
 * Date: 2016-01-09
 * Author: Awei.tian
 * Description: 
 */
class apiModel extends model{
	public function __construct(){
		parent::__construct();
	}
	public function test(){
		return "hi";
	}
	public function getWords($uid){
		$data = $this->db->fetch("select `word` from `blkwords` where `uid` = :uid", array(
				"uid" => $uid
		));
		if (count($data)){
			return $data["word"];
		}
		return "";
	}
}