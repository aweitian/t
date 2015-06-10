<?php
/**
 * @author awei.tian
 * date: 2013-9-16
 * 说明:
 */
lang::import("pmcaiException");
class pmcaiException extends zzzException{

	const INVALID_MASKSTRING=0;


	public function __construct($message = null, $code = 0){
		switch ($code){
			case self::INVALID_MASKSTRING:
				$this->message=lang::t("pmcaiException.invalid_maskstring");
				break;


		}
	}
}