<?php
/**
 * Date: 2014-9-18
 * Author: Awei.tian
 * function: 
 */
 interface IPayment{
 	/**
 	 * 
 	 * @param string $title
 	 * @param string $price
 	 * @param string $extra
 	 * @return 正常情况下转跳到PAYMENT URL上
 	 */
 	public function pay($title,$price,$extra);
 }