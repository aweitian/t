<?php
/**
 * @user:awei.tian
 * @date:2014-3-14
 * @usage:
 */
C::addAutoloadPath("IController", LIB_PATH."/interfaces/IController.php");
abstract class AController implements IController{
	protected $view;
	protected $model;
	public function _loadView(){
		$classname=tian::getContext()->getMessage()->getControl();
		require_once $this->_getCurDir()."/".$classname."View.php";
	}
	public function _loadModel(){
		$classname=tian::getContext()->getMessage()->getControl();
		require_once $this->_getCurDir()."/".$classname."Model.php";
	}
	public function _getCurDir(){
		$classname=tian::getContext()->getMessage()->getControl();
		return tian::$context->getMessage()->getModuleLoc()."/".$classname;
	}
	protected function _init(){
		$classname=tian::getContext()->getMessage()->getControl();
		$this->_loadModel();
		$this->_loadView();
		$v = $classname."View";
		$m = $classname."Model";
		$this->model = new $m;
		$this->view = new $v;
	}
}
abstract class authenticateController extends AController{
	public static function _checkPrivilege(message $msg,identityToken $it){
		return false;
	}
}
abstract class controller extends AController{
	public static function _checkPrivilege(message $msg,identityToken $it){
		return true;
	}

}
