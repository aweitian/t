<?php
/**
 * Date: 2014-9-28
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/modules/auth/privUsrAuth.php";
class privilege extends Controller{
	public static function _checkPrivilege(message $msg,identityToken $it){
		$check = new privUsrAuthModule();
		return $check->isLogined();
	}
	/**
	 *
	 * @var IDb
	 */
	protected $db;
	/**
	 * @var IPdoBase
	 */
	protected $pdo;
	protected function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}
	protected function _skeleton($content){
		return strtr(file_get_contents(dirname(__FILE__)."/misc/skeleton.tpl"),array(
				"{csspath}" => "/sea/public/nec/css/",
				"{content}" => $content
		));
	}
}