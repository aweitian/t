<?php
/**
 * Date: 2015年12月30日
 * Author: Awei.tian
 * Description: 
 */

$data = 
array (
  0 => 
  array (
    'id' => '1',
    'class_top' => '0',
    'class_name' => '远怀近集',
    'class_order' => '1',
  ),
  1 => 
  array (
    'id' => '2',
    'class_top' => '1',
    'class_name' => '奇想',
    'class_order' => '2',
  ),
  2 => 
  array (
    'id' => '3',
    'class_top' => '2',
    'class_name' => '第三级',
    'class_order' => '3',
  ),
  3 => 
  array (
    'id' => '4',
    'class_top' => '2',
    'class_name' => '31',
    'class_order' => '3',
  ),
  4 => 
  array (
    'id' => '5',
    'class_top' => '2',
    'class_name' => '222222222',
    'class_order' => '3',
  ),
  5 => 
  array (
    'id' => '6',
    'class_top' => '1',
    'class_name' => '11111111',
    'class_order' => '2',
  ),
  6 => 
  array (
    'id' => '7',
    'class_top' => '5',
    'class_name' => '44444444',
    'class_order' => '4',
  ),
);





$ret = array();
function test(&$r,$top=0,$level=1){
	global $data;
	foreach ($data as $item){
		if ($item["class_order"] == $level && $top == $item["class_top"]){
			$r[$item["id"]] = array(
				"text" => $item["class_name"],
				"child" => array()
			);
			test($r[$item["id"]]["child"],$item["id"],$level+1);
		} 
		
	}
	
}
test($ret);
echo json_encode($ret);



















