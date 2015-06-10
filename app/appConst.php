<?php
/**
 * Date: 2014-10-21
 * Author: Awei.tian
 * function: 
 */
define("APP_DEBUG", TRUE);
define("APP_PATH", ENTRY_PATH."/app");
define("API_PATH", ENTRY_PATH."/app/api");
define("DATASRC_PATH", ENTRY_PATH."/app/data/datasrc");
define("DATA_PATH", ENTRY_PATH."/app/data");
define("WIDGET_PATH", ENTRY_PATH."/app/widgets");
define("PUBLIC_HOME",ENTRY_HOME.'/public');
define("UPLOADS_HOME",ENTRY_HOME.'/uploads');

define("START_LEVEL",1);
define("STATIC_JS_SPANCALC_NAME","g_spancalc");
define("STATIC_JS_CALC_NAME","g_calc");
define("PRICE_PREC", 2);


define("SVC_NAME","svc");//修改这里,然后把/APP/CONTROLLERS/SVC文件夹相应修改就OK
define("CURRENCY_SYMBOL", "$");