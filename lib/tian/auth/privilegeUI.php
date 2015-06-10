<?php 
require_once LIB_PATH.'/formUI/fieldsManifest.php';
require_once LIB_PATH.'/response/wrap/formWrap.php';
require_once dirname(__FILE__)."/privilegesModel.php";
class privilegeUI{
	public $fm;
	public function __construct(){
		$this->fm=new fieldsManifest();
		$this->fm->addField("code", fieldsManifest::FIELDS_MANIFEST_TYPE_INPUT_STR);
		$this->fm->addField("name", fieldsManifest::FIELDS_MANIFEST_TYPE_INPUT_STR);
		$this->fm->addField("comment", fieldsManifest::FIELDS_MANIFEST_TYPE_TEXTAREA);
	}
	/**
	 * @return formWrap
	 */
	public function getNames(){
		return $this->fm->transform();
	}	
	public function getLabels(){
		$model=new privilegesModel();
		return $model->attributeLabels();
	}
}

?>