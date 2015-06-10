<?php
/**
 * @author: awei.tian
 * @date: 2013-11-18
 * @function:
 */
class Security{
	static private function _get_salt(){
		return "_tianphplib1.1_salt__";
	}
	static public function encrypt($ps){
		return substr(md5(self::_get_salt().strrev(md5($ps))).md5(substr(strrev(dechex(crc32($ps))),1)),3);
	}
	static public function isCorrect($ciphertext,$ps){
		return $ciphertext === self::encrypt($ps);
	}
} 