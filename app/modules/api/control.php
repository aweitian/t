<?php
/**
 * Date: 2016-01-09
 * Author: Awei.tian
 * Description: 
 */
require_once FILE_SYSTEM_ENTRY.'/app/modules/api/model.php';
require_once FILE_SYSTEM_ENTRY.'/app/modules/api/view.php';
class apiController extends Controller{
	/**
	 * 
	 * @var apiModel
	 */
	private $model;
	/**
	 * 
	 * @var apiView
	 */
	private $view;
	
	private $result;
	private $word;
	public static function _checkPrivilege(){
		return roleSession::getInstance()->isLogined();
	}
	public function __construct(){
		$this->model = new apiModel();
		$this->view = new apiView();
		$this->result = array();
		$word = $this->model->getWords(roleSession::getInstance()->getUserID());
		$word = explode("\n", $word);
		foreach ($word as &$w){
			$w = trim($w);
			$w = explode(" ", $w);
			foreach ($w as &$i){
				if(trim($i)){
					$i = trim($i);
				}
			}
		}
		$this->word = $word;
	}
	public function welcomeAction(){
		if(isset($_POST["url"])){
			if(!is_array($_POST["url"])){
				$this->err();
			}else{
				$this->rep($_POST["url"]);
			}
		}
		$this->err();
	}
	private function err(){
		$this->view->output(array("result"=>false,"msg"=>"invalid post data"));
	}
	private function rep($url){
		foreach($url as $num => $item){
			if(Validator::isUrl($item)){
				$content = $this->clean($this->fetch($item));
				$this->result[$key] = $this->jd($content);
			}else{
				$this->result[$num] = 2;
			}
		}
		$this->view->output(array(
			"result"=>true,
			"msg"=>$this->result
		));
	}
	private function clean($con){
		$con = strip_tags($con);
		return preg_replace("/\s+/","",$con);
	}
	private function fetch($url){
		return file_get_contents($url);
	}
	public function jd($con){
		foreach($this->word as $kwArr) {
			$ret = true;
			foreach ($kwArr as $kwItem) {
				if (strpos($word,$kwItem) === false) {
					$ret = false;
					break;
				}
			}
			if ($ret) {
				return 0;
			}
		}
		return 1;
	}
}