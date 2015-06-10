<?php
/**
 * @author awei.tian
 * date: 2015-5-8
 * 说明:
 */
class feedbackController extends appController{
	/**
	 * @var feedbackView
	 */
	protected $view;
	/**
	 * @var feedbackModel
	 */
	protected $model;
	public function __construct(){
		$this->_init();
	}
	public function welcomeAction(message $msg){
		if(isset($msg["?page"])){
			$cur = $msg["?page"] - 1;
			if($cur < 0){
				$cur = 0;
			}
		}else{
			$cur = 0;
		}
		$this->view->showList($this->model->getData($cur),$cur,"");
	}
	public function testAction(){
		echo "hello test";
	}
}