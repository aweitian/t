<?php
/**
 * Date: 2015-1-23
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/interfaces/IUi.php";
require_once ENTRY_PATH."/app/themesData/menu/menu.php";
require_once ENTRY_PATH."/app/themesData/contact/contact.php";


class ui implements IUi{

	public function __construct(){
		
	}
	public function getNavMenuHtml(){
		$menu = new themeDataMenu();
		return $menu->getHTML();
	}
	
	public function getContactHtml(){
		$contact = new themeDataContact();
		return $contact->getHtml();
	}
	public function getLeftRightSkl($left,$right=""){
		if($right == ""){
			$right = $this->getContactHtml();
		}
		ob_start();
		include dirname(__FILE__)."/tpl/lr-layout.php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
	
	public function wrap(array $data,$type){
		extract($data);
		include dirname(__FILE__)."/layout.php";
	}
	
}