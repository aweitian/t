<?php
/**
 * @author awei.tian
 * date: 2013-9-11
 * 说明:
 */
require_once 'app/const.php';
require_once LIB_PATH.'/tian.php';
tian::init();
require_once ENTRY_PATH.'/app/app.php';
tian::$context->setRequest(new httpRequest());
tian::$context->setResponse(new httpResponse());
//tian::$context->getResponse()->start();
tian::$context->setRouter(new router(tian::$context->getRequest()));
require_once ENTRY_PATH."/app/route/webservicesRoute.php";
require_once ENTRY_PATH."/app/route/privRoute.php";
require_once ENTRY_PATH."/app/route/svcRoute.php";
require_once ENTRY_PATH."/app/dispatcher/dispatcher.php";
require_once ENTRY_PATH."/app/controller.php";

//C::addAutoloadPath("assetsController", LIB_PATH."/resource/assets.php");
C::addAutoloadPath("model", LIB_PATH."/mvc/model/model.php");
C::addAutoloadPath("view", LIB_PATH."/mvc/view/view.php");
tian::$context->getRouter()->addRoute(SVC_NAME,new svcRoute());
tian::$context->getRouter()->addRoute("webservices",new webservicesRoute());
tian::$context->getRouter()->addRoute("privilege",new privRoute());
tian::$context->setMessage(new message(tian::$context->getRequest(), 
tian::$context->getRouter()->route()->getUrlManager()));

switch (tian::$context->getRouter()->getMatchedRouteName()){
	case SVC_NAME:
		tian::$context->getMessage()->setModuleLoc(ENTRY_PATH."/app");
		break;
	case "webservices":
		tian::$context->getMessage()->setModuleLoc(ENTRY_PATH."/app/webservices");
		break;
	case "privilege":
		require_once APP_PATH."/privilege/init.php";
		tian::$context->getMessage()->setModuleLoc(ENTRY_PATH."/app/privilege/controllers");
		break;
	default:
		break;
}
tian::$context->addDispatcher("default",new dispatcher(tian::$context->getMessage()));
tian::$context->addDispatcher(SVC_NAME,new noActionDispatcher(tian::$context->getMessage()));



if(!tian::dispatch()){
	if(APP_DEBUG){
		echo "<br><br><br><br><br><br><br><br><br><br><br><br><h2>DEBUG INFO:</h2><hr>";
		var_dump(tian::$context->getRouter()->getMatchedRouteName());
		tian::$context->getRouter()->debug();
		tian::$context->getDispatcher(tian::$context->getRouter()->getMatchedRouteName())->debug();
		var_dump(tian::$context->getRouter()->getRoute()->getUrlManager()->getPmcai());		
	}
	tian::$context->getResponse()->_404();
}
// tian::$context->getResponse()->stop();
// print tian::$context->getResponse()->output;


// echo "<br><br><br><br><br><br><br><br><br><br><br><br><h2>DEBUG INFO:</h2><hr>";
// var_dump(tian::$context->getRouter()->getMatchedRouteName());
// tian::$context->getRouter()->debug();
// tian::$context->getDispatcher(tian::$context->getRouter()->getMatchedRouteName())->debug();
// var_dump(tian::$context->getRouter()->getRoute()->getUrlManager()->getPmcai());
// echo tian::createUrl(array('control','action'));
// echo "<br>";
// echo tian::createUrlOnMsg(
// 		array(
// 				'#Control'=>'action',
// 				'#Action'=>"aaa",
// 		)

// );
//var_dump(tian::$context->getMessage());
?>
