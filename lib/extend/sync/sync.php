<?php
/**
 * Date: 2014-11-7
 * Author: Awei.tian
 * function: 
 */
class sync{
	/**
	 * array("tablename"=>sync_field_name,...)
	 */
	public function __construct($sync_tables){
		
	}
	/**
	 * @return affected_rows
	 * 
	 */
	public function update($data){
		
	}
	/**
	 * @return affected_rows
	 * @param $data array(
	 * 		"tablename" => array(
	 * 			pk => revision,
	 * 			...
	 * 		),
	 * 		...
	 * 
	 * )
	 */
	public function commit($data){
		
	}
}