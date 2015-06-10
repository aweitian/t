<?php
/**
 * Date: 2015-1-21
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/modules/auth/memberAuth.php";
require_once LIB_PATH."/formUI/fieldsManifest.php";
class memberUi{
	public function login(){
		$auth = new memberAuthModule();
		return $auth->getUiData();
	}
	
	public function recoverPwd($def=array()){
		$text = array("Security Question","Security Answer","New password","Repeat new password");
		$mf = new fieldsManifest();
		$mf->addField("q", "text",$this->_def($def, "q"));
		$mf->addField("email", "text",$this->_def($def, "email","hidden"));
		$mf->addField("a", "text",$this->_def($def, "a"));
		$mf->addField("nwpwd", "text",$this->_def($def, "nwpwd"));
		$mf->addField("nwpwd_repeat", "text",$this->_def($def, "nwpwd_repeat"));
		
		$val = $mf->getData();
		$eml = $val["email"];
		unset($val["email"]);
		$val["q"] = $val["q"].$eml;
		return array_combine($text, array_values($val));
	}
	
	public function register($def=array()){
		$text = array("Email","Your Password","Repeat Password","Nick name","First name","Last name","Security question","Security answer","Phone","Msn","Aim","Yahoo");
		$mf = new fieldsManifest();
		$mf->addField("email", "text",$this->_def($def, "email"));
		$mf->addField("pswod", "text",array("type"=>"password"));
		$mf->addField("pswod1", "text",array("type"=>"password"));
		$mf->addField("nknme", "text",$this->_def($def, "nknme"));
		$mf->addField("fname", "text",$this->_def($def, "fname"));
		$mf->addField("lname", "text",$this->_def($def, "lname"));
		$mf->addField("squst", "text",$this->_def($def, "squst"));
		$mf->addField("sqkey", "text",$this->_def($def, "sqkey"));
		$mf->addField("phone", "text",$this->_def($def, "phone"));
		$mf->addField("mssnn", "text",$this->_def($def, "mssnn"));
		$mf->addField("aimmm", "text",$this->_def($def, "aimmm"));
		$mf->addField("yahoo", "text",$this->_def($def, "yahoo"));
		$val = $mf->getData();
		return array_combine($text, array_values($val));
	}
	public function updateInfo($def=array()){
		$text = array("Nick name","First name","Last name","Security question","Security answer","Phone","Msn","Aim","Yahoo");
		$mf = new fieldsManifest();
		$mf->addField("nknme", "text",$this->_def($def, "nknme"));
		$mf->addField("email", "text",$this->_def($def, "email","hidden"));
		$mf->addField("fname", "text",$this->_def($def, "fname"));
		$mf->addField("lname", "text",$this->_def($def, "lname"));
		$mf->addField("squst", "text",$this->_def($def, "squst"));
		$mf->addField("sqkey", "text",$this->_def($def, "sqkey"));
		$mf->addField("phone", "text",$this->_def($def, "phone"));
		$mf->addField("mssnn", "text",$this->_def($def, "mssnn"));
		$mf->addField("aimmm", "text",$this->_def($def, "aimmm"));
		$mf->addField("yahoo", "text",$this->_def($def, "yahoo"));
		$val = $mf->getData();
		$eml = $val["email"];
		unset($val["email"]);
		$val["nknme"] = $val["nknme"].$eml;
		return array_combine($text, array_values($val));
	}
	public function revisePwd($def=array()){
		$text = array("Original password","New password","Repeat new password");
		$mf = new fieldsManifest();
		$mf->addField("email", "text",$this->_def($def, "email","hidden"));
		$mf->addField("oldpwd", "text",$this->_def($def, "oldpwd"));
		$mf->addField("nwpwd", "text",$this->_def($def, "nwpwd"));
		$mf->addField("nwpwd_repeat", "text",$this->_def($def, "nwpwd_repeat"));
		$val = $mf->getData();
		$eml = $val["email"];
		unset($val["email"]);
		$val["nknme"] = $val["nknme"].$eml;
		return array_combine($text, array_values($val));
	}	
	public function updateRksmvid($def=array()){
		$mr = require ENTRY_PATH."/app/conf/memberrank.php";
		$text = array("Consume amount","Rank","VIP ID");
		$mf = new fieldsManifest();
		$mf->addField("email", "text",$this->_def($def, "email","hidden"));
		$mf->addField("cnsm", "text",$this->_def($def, "cnsm"));
		$v = $this->_def($def, "rank");
		$mf->addField("rank", "select",array(),array_keys($mr),array_values($mf),$v["value"]);
		$mf->addField("vid", "text",$this->_def($def, "vid"));
		$val = $mf->getData();
		$eml = $val["email"];
		unset($val["email"]);
		$val["nknme"] = $val["nknme"].$eml;
		return array_combine($text, array_values($val));
	}
	
	
	private function _def($def,$name,$type="text"){
		$ret = array();
		if($type!="text")$ret["type"] = $type;
		if(isset($def[$name])){
			$ret["value"] = $def[$name];
		}else{
			$ret["value"] = "";
		}
		return $ret;
	}
}