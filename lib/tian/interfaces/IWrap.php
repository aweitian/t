<?php
/**
 * @author:awei.tian
 * @date:2013-12-23
 * @functions:
 * 以什么样的格式加工数据，然后返回到
 * 客户端
 */
interface IWrap{
	/**
	 * @return string
	 */
	public function wrap($data,httpResponse $response);
}