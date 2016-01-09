<?php
/**
 * Date: 2016-01-09
 * Author: Awei.tian
 * Description: 
 */
class mainModel extends model{
	public function __construct(){
		parent::__construct();
	}
	public function test(){
		return "hi";
	}
	public function putWords($uid,$data){
		return $this->db->exec("UPDATE `blkwords` 
			SET
			`word` = :data
			WHERE
			`uid` = :uid ;
				", array(
				"uid" => $uid,
				"data" => $data	
		));

	}
	
	public function putUrls($uid,$data){
		return $this->db->exec("UPDATE `blkwords` 
			SET
			`url` = :data
			WHERE
			`uid` = :uid ;
				", array(
				"uid" => $uid,
				"data" => $data
		));
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
	
	public function getUrls($uid){
		$data = $this->db->fetch("select `url` from `blkwords` where `uid` = :uid", array(
				"uid" => $uid
		));
		if (count($data)){
			return $data["url"];
		}
		return "";
	}
}