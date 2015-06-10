<?php
/**
 * Date:2015年5月6日
 * Author:Awei.tian
 * Function:
 */
require_once ENTRY_PATH."/app/modules/member/memberUi.php";
require_once ENTRY_PATH."/app/modules/member/memberModule.php";
class themeDataMember{
	/**
	 * @var memberUi
	 */
	private $ui;
	public function __construct(){
		$this->ui = new memberUi();
	}
	public function getLoginRawData(){
		return $this->ui->login();
	}
	public function getRegisterRawData(){
		return $this->ui->register();
	}
	public function getProfileRawData(){
		
	}
	public function getLoginHtml(){
		ob_start();
		$data = $this->getLoginRawData();
		include dirname(__FILE__)."/tpl/login.tpl.php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
	public function getProfileHtml(){
		ob_start();
		$data = $this->getLoginRawData();
		include dirname(__FILE__)."/tpl/login.tpl.php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
	public function getRegisterHtml($errorMsg=""){
		ob_start();
		$data = $this->getRegisterRawData();
		include dirname(__FILE__)."/tpl/register.tpl.php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
}