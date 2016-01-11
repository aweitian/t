<?php
/**
 * Date: 2016-01-09
 * Author: Awei.tian
 * Description: 
 */
require_once FILE_SYSTEM_ENTRY.'/app/modules/main/model.php';
require_once FILE_SYSTEM_ENTRY.'/app/modules/main/view.php';
class mainController extends AuthController{
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
	/**
	 * 后台输入的负面词按行切割成数组，每个元素再按空格切割成数组
	 * 由initWord()方法完成
	 * @var array
	 */
	private $word;
	
	private $url;			/*正在FETCH的地址*/
	private $ma_word;		/*如果负面匹配成功，此变量为匹配成功的一行词，没有成功，为空*/
	private $result;		/*执行结果,值 为下面INFO的定义 0-4*/
	private $raw_html;		/*FETCH的结果*/
	private $str_content;	/*clean函数执行的结果*/
	
	const INFO_CLEAN = 0x0;
	const INFO_DIRTY = 0x1;
	const INFO_FETCH_ERR = 0x2;
	const INFO_INVALID_URL = 0x3;
	const INFO_INIT = 0x4;
	public static function _checkPrivilege() {
		return true;
	}
	public function __construct(){
		if(!roleSession::getInstance()->isLogined()){
			$this->go("login","");
		}
		$this->model = new mainModel();
		$this->view = new mainView();
	}
	public function welcomeAction(){
		$this->searchAction();
	}
	private function showResult(){
		if(isset($_POST["urls"]) && is_array($_POST["urls"])){
			$task = $_POST["urls"];
			print $this->getTaskUIHtml();
			$this->initWord();
			$this->model->cleanResults(roleSession::getInstance()->getUserID());
			
			foreach ($task as $url){
				$this->initResultItem();
				if(Validator::isUrl($url)){
					$this->url = $url;
					$this->raw_html = $this->fetch($url);
					if($this->raw_html === false){
						$this->result = self::INFO_FETCH_ERR;
					}else{
						$this->clean();		/*  $this->str_content  */
						$this->jd();		/*  $this->result  */
						$this->model->putResultItem($this->getResultItem());
					}
				}else{
					$this->result = self::INFO_INVALID_URL;
					$this->url = $url;
					
				}
				$this->output();
			}
		}else{
			return $this->showTask();
		}
	}
	private function output(){
		ob_flush();
		flush();
		print '<script>updst("'.$this->url.'",'.$this->result.')</script>';
		
	}
	private function getResultItem(){
		return array(
			"result"=>$this->result,
			"url"=>$this->url,
			"ma_word"=>$this->ma_word,
			"rawhtml"=>$this->raw_html,
			"str_content"=>$this->str_content,
			"uid"=>roleSession::getInstance()->getUserID()
		);
	}
	private function initResultItem(){
		$this->ma_word = "";
		$this->url = "";
		$this->raw_html = "";
		$this->str_content = "";
		$this->result = 0x4;
	}
	private function clean(){
		$con = $this->raw_html;
		#去除脚本
		$con = preg_replace("#<script[^>]*>[\d\D]*?</script>#","",$con);
		#去除样式
		$con = preg_replace("#<style[^>]*>[\d\D]*?</style>#","",$con);
		#去除所有标签
		$con = preg_replace("#<[^>]+>#","",$con);
		#去除所有空白
		$con = preg_replace("/\s+/","",$con);
	
		#去除所有HTML空白字符
		$this->str_content = str_replace("&nbsp;","",$con);
		return ;
	}
	public function editwordAction(){
		if($this->isPost()){
			return $this->updateWord();
		}
		$this->showWord();
	}
	private function updateWord(){
		if(isset($_POST["w"])){
			$r = $this->model->putWords(roleSession::getInstance()->getUserID(), $_POST["w"]);
		}else{
			$r = false;
		}
		$this->showWord($r,$r ? "编辑成功":"编辑失败");
	}
	private function showWord($r=true,$msg=""){
		$this->view->wrap(
				$this->view->fetch(
						"editword",
						array(
							"result"=>$r,
							"msg"=>$msg,
							"content"=>$this->model->getWords(roleSession::getInstance()->getUserID())
						)
				)
		)->show();
	}
	public function editurlAction(){
		if($this->isPost()){
			return $this->updateUrl();
		}
		$this->showurl();
	}
	
	private function showurl($r=true,$msg=""){
		$this->view->wrap(
				$this->view->fetch(
						"editurl",
						array(
								"result"=>$r,
								"msg"=>$msg,
								"content"=>$this->model->getUrls(roleSession::getInstance()->getUserID())
						)
				)
		)->show();
	}
	private function updateUrl(){
		if(isset($_POST["u"])){
			$r = $this->model->putUrls(roleSession::getInstance()->getUserID(), $_POST["u"]);
		}else{
			$r = false;
		}
		$this->showurl($r,$r ? "编辑成功":"编辑失败");
	}
	
	public function searchAction(){
		if($this->isPost()){
			$this->showResult();
			return ;
		}
		$this->showTask();
		
	}
	private function showTask(){
		$this->view->wrap($this->view->showTask(
				$this->model->getUrls(roleSession::getInstance()->getUserID())
		))->show();
	}
	private function getTaskUIHtml(){
		return $this->view->wrap($this->view->showTask(
				$this->model->getUrls(roleSession::getInstance()->getUserID())
		))->getHtml();
	}
	private function initWord(){
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
	private function fetch($url){
		return file_get_contents($url);
	}
	/**
	 * @return boolean true == 存在负面信息
	 */
	private function jd(){
		foreach($this->word as $kwArr) {
			$rowClean = true;
			if($this->jdRow($kwArr)){
				$this->result = self::INFO_DIRTY;
				return;
			}
		}
		$this->result = self::INFO_CLEAN;
	}
	/**
	 * @return boolean true == dirty
	 * @param string $word_row
	 */
	private function jdRow($word_row){
		foreach ($word_row as $kwItem) {
			if (strpos($this->str_content,$kwItem) === false) {
				//只要有一个词不存在，就认为这行没有匹配成功
				return false;
			}
		}
		//这行所有词都匹配成功，认为存在负面信息
		$this->ma_word = join(" ",$word_row);
		return true;
	}
}