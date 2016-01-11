<?php
/**
 * Date: 2016-01-11
 * Author: Awei.tian
 * Description: 
 */
require_once FILE_SYSTEM_ENTRY.'/app/modules/dl/model.php';
require_once FILE_SYSTEM_ENTRY.'/app/modules/dl/view.php';
class dlController extends Controller{
	/**
	 * 
	 * @var dlModel
	 */
	private $model;
	/**
	 * 
	 * @var dlView
	 */
	private $view;
	private $field_desc;
	public static function _checkPrivilege() {
		return roleSession::getInstance()->isLogined();
	}
	public function __construct(){
		$this->model = new dlModel();
		$this->view = new dlView();
		$this->field_desc = array(
				"url"=>"查询网址",
				"result"=>"结果",
				"ma_word"=>"匹配的负面关键词",
				"rawhtml"=>"抓取的网页内容",
				"str_content"=>"去除无用后的内容"
		);

	}
	public function welcomeAction(){
		if($this->isPost()){
			$this->dl();
		}else{
			$this->showCol();
		}
	}
	private function showCol(){
		$this->view->wrap($this->view->fetch("list",$this->field_desc))->show();
	}
	private function dl(){
		$h = array_combine($_POST["col"], $_POST["col"]);
		$data = $this->model->getData(roleSession::getInstance()->getUserID());
		$this->view->outputExcel($this->field_desc,$data);		
	}
}