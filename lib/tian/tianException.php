<?php
/**
 * @author awei.tian
 * date: 2013-8-10
 * 参考:epi
 */
define("USEEXCEPTION",true);
class tianException extends Exception
{
	public static function raise($exception)
	{
		if(USEEXCEPTION)
		{
			throw new $exception($exception->getMessage(), $exception->getCode());
		}
		else
		{
			echo sprintf("An error occurred and you have <strong>exceptions</strong> disabled so we're displaying the information.
                    To turn exceptions on you should call: <em>zzz::setSetting('exceptions', true);</em>.
                    <ul><li>File: %s</li><li>Line: %s</li><li>Message: %s</li><li>Stack trace: %s</li></ul>",
					$exception->getFile(), $exception->getLine(), $exception->getMessage(), nl2br($exception->getTraceAsString()));
		}
	}
	public static function info(Exception $e){
		return "file:".$e->getFile()."<br>line:".$e->getLine()."<br>msg:".$e->getMessage();
	}
}