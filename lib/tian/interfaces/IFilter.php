<?php


interface IFilter {
	/**
	 * @return bool
	 * @param unknown $data
	 */
	public function filter(&$data);
}

?>