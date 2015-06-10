<?php
/**
 * @author:awei.tian
 * @date:2013-12-20
 * @functions:
 */
interface IRest{
	public function help();
	public function get(message $msg);
	public function post(message $msg);
	public function delete(message $msg);
	public function put(message $msg);
}