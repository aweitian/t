<?php
/**
 * @author: awei.tian
 * @date: 2013-11-10
 * @function:
 */
interface IContext{
	function loadLog();
	function loadModel();
	function loadView();
	function getCache();
	/**
	 * @return IDb
	 */
	function getDb();
	function getKv();
	
	/**
	 * @return httpRequest
	 */
	function getRequest();
	function setRequest(httpRequest $r);
	/**
	 * @return httpResponse
	 * Enter description here ...
	 */
	function getResponse();
	function setResponse(httpResponse $r);
	/**
	 * @return message
	 */
	function getMessage();
	function setMessage(message $m);
	/**
	 * @return router
	 * Enter description here ...
	 */
	function getRouter();
	function setRouter(router $m);
	
	/**
	 * @return IDispatcher
	 */
	function getDispatcher($name);
	function addDispatcher($name,IDispatcher $d);
	
	/**
	 * @return session
	 */
	function getSession();
	/**
	 * @return identityToken
	 */
	function getIdentityToken();
	/**
	 * @return visterEnvironment
	 */
	function getVisterEnvironment();
}