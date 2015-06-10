<?php
C::addAutoloadPath("urlManager", LIB_PATH."/url/urlManager.php");
return array(
	"defaultRouteResponseContentTypeSpecedInurl"=>defined("RESPONSE_CONTENT_TYPE_SPECED_IN_URL")?RESPONSE_CONTENT_TYPE_SPECED_IN_URL:true,//是否认为URL中包含了RESPONSE CONTENT TYPE
	"defaultRoutePathFrom"=>defined("URLREWRITEMODE")?urlManager::PATH_FROM_PATH:urlManager::PATH_FROM_QUERYSTRING/*urlManager::PATH_FROM_PATH*/,
	"defaultRoutePathFromQueryStringPlaceHolder"=>defined("ROUTE_GET_NAME")?ROUTE_GET_NAME:"r",
	/**
	 * RESPONSE_CONTENT_TYPE_SPECED_IN_URL 为TRUE时，它指定RESPONSE CONTENT TYPE 的位置
	 */
	"defaultRouteResponseContentFrom"=>urlManager::RESPONSE_CONTENT_TYPE_FROM_ACTIONPOST,
	/**
	 * 如果揎定在QUERY STRING中，用什么名字
	 */
	"defaultRouteResponseContentTypeFromQueryStringPlaceHolder"=>defined("RESPONSE_CONTENT_TYPE_PLACE_HOLDER_IN_URL")?RESPONSE_CONTENT_TYPE_PLACE_HOLDER_IN_URL:"ext",
);