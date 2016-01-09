<?php
/**
 * Date: 2016-01-09
 * Author: Awei.tian
 * Description: 
 */
require_once FILE_SYSTEM_ENTRY.'/app/modules/main/model.php';
require_once FILE_SYSTEM_ENTRY.'/app/modules/main/view.php';
class mainController extends Controller{
	/**
	 * 
	 * @var mainModel
	 */
	private $model;
	/**
	 * 
	 * @var mainView
	 */
	private $view;
	public function __construct(){
		$this->model = new mainModel();
		$this->view = new mainView();
	}
	public function welcomeAction(){
		$this->searchAction();
	}
	public function editwordAction(){
		$this->view->wrap(
			$this->view->fetch(
					"editword",
					$this->model->getWords(roleSession::getInstance()->getUserID())
					
					)
				)->show();
	}
	public function editurlAction(){
		$this->view->wrap(
			$this->view->fetch(
					"editurl",
					$this->model->getUrls(roleSession::getInstance()->getUserID())
					
					)
				)->show();
	}
	public function searchAction(){
		$this->view->wrap($this->model->test())->show();
	}
}