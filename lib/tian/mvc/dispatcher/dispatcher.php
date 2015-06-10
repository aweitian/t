<?php
/**
 * @author awei.tian
 * date: 2013-9-17
 * 说明:
 */
require_once LIB_PATH."/interfaces/IDispatcher.php";
require_once dirname(__FILE__)."/AController.php";

C::load(LIB_PATH."/_setting/dispatch.php");
C::addAutoloadPath("IActionNotFound", LIB_PATH."/interfaces/IActionNotFound.php");
C::addAutoloadPath("IController", LIB_PATH."/interfaces/IController.php");
C::addAutoloadPath("message", LIB_PATH."/mvc/message/message.php");

class dispatcher implements IDispatcher{
	
	const DISPATCH_STATE_INIT		=0xa1;
	const DISPATCH_STATE_RESTART    =0xb2;
	const DISPATCH_STATE_DISPATCHING=0xc3;
	const DISPATCH_STATE_CONTROL_NOT_FOUND=0xd4;
	const DISPATCH_STATE_ACTION_NOT_FOUND=0xe5;
	const DISPATCH_STATE_DISPATCH_OK=0xf6;
	const DISPATCH_STATE_DISPATCH_FAIL=0xf7;
	const DISPATCH_STATE_EXCEED_MAX_TIMES=0xfc;
	
	const MAX_COUNT_MSG_DISPATCH=5;
	/**
	 * 此消息派遣是否成功
	 * @var $_state
	 */
	protected $_state=false;
	protected $msg;
	protected $_message="";
	protected $traces=array();
	protected $_control_inst=null;
	protected $module_path="";
	public function __construct(message $msg){
		$msg->setDispatchedState(self::DISPATCH_STATE_INIT);
		$msg->setDispatcher($this);
		$this->msg=$msg;
		$this->fixedMsg();
	}
	/**
	 * 检查pmcai
	 * 为空就用默认填充
	 */
	protected function fixedMsg(){
		$control=$this->msg->getControl();
		$control=preg_replace("#".C::get("defaultControlRegExp")."#", "", $control);
		if($control==="")$control=C::get("defaultControl");
		$this->msg->setControl($control);
		
		$action=$this->msg->getAction();
		$action=preg_replace("#".C::get("defaultActionRegExp")."#", "", $action);
		if($action==="")$action=C::get("defaultAction");
		$this->msg->setAction($action);
	}
	/**
	 * 返回是否派遣成功
	 */
	public function dispatch(){
		while ($this->doDispatch()===false);
		return $this->getDispatchResult()===self::DISPATCH_STATE_DISPATCH_OK;
	}
	/**
	 * 返回TRUE，结束派遣
	 * @return boolean
	 * 根据msg的mca
	 * 如果C不存在，它实现了iControlNotFound，就把$msg传递给它的zzzSysDefinedRewriteMessage方法
	 * 如果没有实现，就fail()
	 * 如果方法存在，派遣成功
	 * 如果不存在，但它实现了iActionNotFound,调用zzzSysDefinedDefaultAction
	 * 派遣结束
	 * 没有实现iActionNotFound，
	 *
	 */
	protected function doDispatch(){
		$times=$this->msg->getDispatchCount();
		if($times>self::MAX_COUNT_MSG_DISPATCH){
			$this->traces[]="diapatch://exceed the Max limit,dispatch end";
			$this->exceed_max_times();
		}else{
			$this->msg->setDispatchCount($times+1);
		}
		if($this->msg->getUseSysControlNotFound()){
			$this->_dispatch_Sys_control_not_found();
		}
		$state=$this->msg->getDispatchState();
		
		switch ($state){
			case self::DISPATCH_STATE_INIT:
			case self::DISPATCH_STATE_RESTART:
				$this->msg->setDispatchedState(self::DISPATCH_STATE_DISPATCHING);
				$this->_Dispatch();
				return false;
			case self::DISPATCH_STATE_DISPATCHING:
				$this->_state=$state;
				return true;
			case self::DISPATCH_STATE_CONTROL_NOT_FOUND:
				$this->_state=$state;
				return true;
			case self::DISPATCH_STATE_ACTION_NOT_FOUND:
				$this->_state=$state;
				return true;
			case self::DISPATCH_STATE_DISPATCH_OK:
				$this->_state=$state;
				return true;
			case self::DISPATCH_STATE_DISPATCH_FAIL:
				$this->_state=$state;
				return true;
			case self::DISPATCH_STATE_EXCEED_MAX_TIMES:
				$this->_state=$state;
				return true;
		}
	}
	protected function ok(){
		$this->msg->setDispatchedState(self::DISPATCH_STATE_DISPATCH_OK);
	}
	protected function fail($msg){
		$this->msg->setDispatchedState(self::DISPATCH_STATE_DISPATCH_FAIL);
		$this->_message=$msg;
		$this->_state=false;
	}
	protected function control_not_found(){
		$this->msg->setDispatchedState(self::DISPATCH_STATE_CONTROL_NOT_FOUND);
	}
	protected function action_not_found(){
		$this->msg->setDispatchedState(self::DISPATCH_STATE_ACTION_NOT_FOUND);
	}
	protected function restart(){
		$this->msg->setDispatchedState(self::DISPATCH_STATE_RESTART);
	}
	protected function exceed_max_times(){
		$this->msg->setDispatchedState(self::DISPATCH_STATE_EXCEED_MAX_TIMES);
	}
	protected function getDispatchResult(){
		$state=$this->msg->getDispatchState();
		switch ($state){
			case self::DISPATCH_STATE_INIT:
			case self::DISPATCH_STATE_RESTART:
				$this->_message=lang::t("dispatcherException.dispatch_state_init");
				break;
			case self::DISPATCH_STATE_DISPATCHING:
				$this->_message=lang::t("dispatcherException.dispatch_state_dispatching");
				break;
			case self::DISPATCH_STATE_CONTROL_NOT_FOUND:
				$this->_message=lang::t("dispatcherException.dispatch_state_control_not_found",array("control"=>$this->msg->getControl()));
				break;
			case self::DISPATCH_STATE_ACTION_NOT_FOUND:
				$this->_message=lang::t("dispatcherException.dispatch_state_action_not_found",array("action"=>$this->msg->getAction()));
				break;
			case self::DISPATCH_STATE_DISPATCH_OK:
				$this->_message=lang::t("dispatcherException.dispatch_state_dispatch_ok");
				break;
			case self::DISPATCH_STATE_EXCEED_MAX_TIMES:
				$this->_message=lang::t("dispatcherException.exceed_max_times");
				break;
		}
		return $this->_state;
	}
	/**
	 * 先调用下getDispatchResult()
	 * @return string
	 */
	public function getDispatchResultInfo(){
		return $this->_message;
	}
	protected function getMessage(){
		return $this->msg;
	}
	public function debug(){
		echo "<div style='background:#fff;border:0px solid #aaa;color:#333333;line-height:120%;'>".implode("<br>", $this->traces)."</div>";
	}
	public function getModuleLoc(){
		return $this->_getDefaultModuleLoc();
	}
	/**
	 * 执行逻辑:
	 * 根据moduleloc/module/control看controlController的文件名是否存在（这样也点好处，比如在包含control类之前还想包含点别的，这时就可以进行）
	 * 存在包含，检查类是否存在，存在，有没有实现ICONTROL，没有调用FAIL（）。
	 * 实现了，初始化
	 * 如果类不存在的话，看有没有类controlNotFound,并且它要实现iControlNotFound
	 * 实现先调用zzzSysDefinedRewriteMessage（$msg）
	 * 然后调用restart()
	 * 没有没有实现iControlNotFound
	 * 调用FAIL（）。
	 */
	protected function _Dispatch(){
		$control_suffix=$this->msg->getControl().C::get("ControlSuffix");
		$controlLoc=$this->_getControllerLoc();
		$this->traces[]="dispatching://prepare to check class exists named $control_suffix";
		if(!class_exists($control_suffix)){
			$this->traces[]="dispatching://class not found,finding file $controlLoc";
			if(file_exists($controlLoc)){
				$this->traces[]="dispatching://control file found, require the control file at $controlLoc";
				require_once($controlLoc);
			}
			$this->traces[]="dispatching://recheck class exists";
			if (!class_exists($control_suffix)){
				$this->traces[]="dispatching://trigger control not exist";
				$this->_dispatch_control_not_exist();
			}else{
				$this->traces[]="dispatching://trigger control exist";
				$this->_dispatch_control_exist();
			}
		}else{
			$this->traces[]="dispatching://trigger control exist";
			$this->_dispatch_control_exist();
		}
	}
	protected function _getControllerLoc(){
		$moduleLoc=$this->msg->getModuleLoc();
		if($moduleLoc==""){
			$moduleLoc=$this->_getDefaultModuleLoc();
		}
		$module=$this->msg->getModule();
		if($module!="")$module=$module."/";
		$controlLoc=$moduleLoc."/".($this->msg->getModuleLoc()==""?$module:"").$this->msg->getControl()."/".($this->msg->getControl().C::get("ControlSuffix")).".php";
		return $controlLoc;
	}
	protected function _dispatch_control_exist(){
		$this->traces[]="dispatching://init control class";
		$rc=new ReflectionClass($this->msg->getControl().C::get("ControlSuffix"));
		$this->traces[]="dispatching://check control implements the iController interface";
		if ($rc->implementsInterface('IController')) {
			$this->traces[]="dispatching://control implemented the iController interface";
			//if(!$rc -> hasMethod(C('action_not_found')) && !$rc -> hasMethod($msg -> getAction())){
			//权限检查
			$controller=$this->msg->getControl().C::get("ControlSuffix");
			if (!$rc->hasMethod("_checkPrivilege") or !$rc->getMethod("_checkPrivilege")->isStatic()) {
				$this->traces[]="dispatching://controller not function _checkPrivilege";
				return true;
			}
			$privilege=call_user_func_array(
					$controller."::_checkPrivilege", 
					array(
						$this->msg,
						tian::$context->getIdentityToken()
					)
			);
			$this->traces[]="dispatching://execute the check privilege function";
			if($privilege!==true){
				$this->traces[]="dispatching://blocked by the privilege check";
				$this->fail(lang::t("dispatcherException.no_permision"));
			}else{
				$this->traces[]="dispatching://pass the privilege check";
				$action=$this->msg->getAction();
				$action_suffix=$action.C::get("ActionSuffix");
				$this->traces[]="dispatching://assign the action:$action_suffix";
				//action存在
				$this->traces[]="dispatching://check action exists";
				if($rc->hasMethod($action_suffix)){
					$this->traces[]="dispatching://action found,and invoked,dispatch end.";
					$controller=$rc->newInstance();
					$method=$rc->getMethod($action_suffix);
					$method->invokeArgs($controller, array($this->msg));
					$this->ok();
				//ACTION不存在，但实现了iActionNotFound接口
				}elseif ($rc->implementsInterface("IActionNotFound")){
					$this->traces[]="dispatching://action not found,but the control immplements the IActionNotFound interface";
					$action=C::get("actionNotFound");
					$this->traces[]="dispatching://action is assigned to $action";
					$controller=$rc->newInstance();
					$method=$rc->getMethod($action);
					$method->invokeArgs($controller, array($this->msg));
					$this->ok();
					$this->traces[]="dispatching://invoked the actionNotFound action,dispatch end.";
				}else{
					$this->traces[]="dispatching://action not found,and the control no implemtns the IActionNotFound interface,dispatch end";
					$this->fail(lang::t("dispatcherException.dispatch_state_action_not_found"));
				}
			}

		}else{
			$this->traces[]="dispatching://the class have not implements iController interfaces,dispatch end";
			$this->fail(lang::t("dispatcherException.control_does_not_implements_icontroller"), false);
		}
	}
	protected function _dispatch_control_not_exist(){
		$this->traces[]="dispatching://control not exist";
		$this->msg->setUseSysControlNotFound();
		$this->restart();
	}
	protected function _dispatch_Sys_control_not_found(){
		$control=C::get("controlNotFound");
		$this->traces[]="dispatching://hook 404,the control name is $control";
		if(!class_exists($control)){
			$this->traces[]="dispatching://control name $control not included manually";
			$this->msg->resetUseSysControlNotFound();
			$this->fail(lang::t("dispatcherException.no_sys_control_not_found"), false);
			
			return false;
		}
		$rc=new ReflectionClass($control);
		if ($rc->implementsInterface('iControlNotFound')) {
			$this->traces[]="dispatching://control name $control implements icontroller interface";
			$controller=$rc->newInstance();
			$method=$rc->getMethod("_action_not_found");
			$method->invokeArgs($controller, array($this->msg));
			$this->restart();
			$this->traces[]="dispatching://invoke the _action_not_found,dispatch end";
		}else{
			$this->traces[]="dispatching://control name $control dese not implements icontroller interface,dispatch end";
			$this->fail(lang::t("dispatcherException.control_does_not_implements_icontroller"), false);
		}
		
	}
}