<?php
/**
 * @author awei.tian
 * date: 2013-8-31
 * 参考:
 */

class routerException extends zzzException{
	const NOT_FOUND_CODE = 0;
	const NOMATCH_CODE = 1;
	const URL_IS_NOT_A_STRING = 3;
	const URL_IS_EMPTY = 4;
	public function __construct($message = null, $code = 0){
		switch ($code){
			case self::NOT_FOUND_CODE:
				$this->message=lang::t("routerException.not_found_code");
				break;
			case self::INVALID_ARGS2:
				$this->message=lang::t("routerException.nomatch_code");
				break;
			case self::URL_ISNOT_A_STRING:
			case self::URL_IS_EMPTY:
				$this->message=lang::t("routerException.url_is_not_a_string");
				break;
		}
	}
}