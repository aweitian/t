<?php
/**
 * Date: 2015-1-23
 * Author: Awei.tian
 * function: 
 */
interface IUi{
	/**
	 * @return string
	 * @param array $data 数组KEY对应模板中需要的内容,比如模板中只需要CONTENT,LEFT
	 * @param string $type 通常一个主题只有一种皮肤,但在一个主题下也会有不同的外观,比如登陆有可能就不一样
	 */
	public function wrap(array $data,$type);
}