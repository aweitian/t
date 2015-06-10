<?php
/**
 * @author awei.tian
 * date: 2013-11-7
 * 说明:
 */
interface IController{
	static function _checkPrivilege(message $msg,identityToken $it);
}
