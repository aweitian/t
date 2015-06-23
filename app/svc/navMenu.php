<?php
class navMenu{
	private $rawData;
	
	private $rows;
	private $cols;
	private $data;
	private $rmSpc;
	public function __construct($raw,$cols=4){
		$this->rawData = $raw;
		$this->cols = $cols;
		$this->opRaw();
		$this->calcRemainSpacing();
	}
	/**
	 * @see /tmp/data1.php
	 */
	public function opRaw(){
		$last = "";
		$this->data = array();
		foreach ($this->rawData as $path){
			$arr = explode("/", trim($path,"/"));
			if (current($arr) != $last){
				$last = current($arr);
				$this->data[$last] = $last;
			}
			$this->data[$path] = end($arr);
		}
		$this->rows = ceil(count($this->data) / $this->cols);
	}
	public function calcRemainSpacing(){
		$this->rmSpc = $this->rows * $this->cols - count($this->data);
	}
	public function output(){
		$i = 0;
		$html = "";
		$html .=  '<table><tr><td>';
		foreach ($this->data as $path => $name){
			$i++;
			$skip = false;
			if($i % $this->rows == 0){
				$skip = true;
				if($this->isDir($path)){
					$this->rmSpc--;
					if($this->rmSpc < 0){
						$this->rows++;
						$this->calcRemainSpacing();
						reset($this->data);
						return $this->output();
					}else{
						$i++;
					}
					
				}
			}
			if($this->isDir($path)){
				$html .=   $name;
				$html .=   "<br>";
				$html .=   "<hr>";
			}else{
				$html .=   '<a href="'.$path.'">'.$name.'</a><br>';
			}
			if($skip){
				$html .=   '</td><td>';
			}
			
		}
		$html .=   '</td></tr></table>';
		return $html;
	}
	private function isDir($p){
		return strpos($p, "/") === false;
	}
	public function debug(){
		var_dump($this->rows);
	}
}