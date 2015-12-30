<?php
/**
 * Date: 2015年12月29日
 * Author: Awei.tian
 * Description: 
 */
class mainController extends Controller{
	public function __construct(){
		echo "greet from mainController.__construct ..";
	}
	public function welcomeAction(){
		echo "hi";
	}
}