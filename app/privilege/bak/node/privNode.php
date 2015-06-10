<?php
/**
 * Date: 2014-9-26
 * Author: Awei.tian
 * function: 
 */
require_once dirname(dirname(dirname(__FILE__)))."/ttree/node/nodeOp.php";
require_once dirname(dirname(dirname(__FILE__)))."/datasrc/DataSrc.php";
require_once dirname(dirname(dirname(__FILE__)))."/datasrc/DataSrcOp.php";
class privNode{
	/**
	 *
	 * @var IDb
	 */
	private $db;
	/**
	 * /sea/public/css/nec/
	 * @var IPdoBase
	 */
	private $pdo;
	
	
	private $nodeop;
	private $nodeinfo;
	private $index_url = "/sea/debug.php?p=test/node/index";
	private $add_url = "/sea/debug.php?p=test/node/add";
	private $append_url = "/sea/debug.php?p=test/node/append";
	private $edit_url = "/sea/debug.php?p=test/node/edit";
	private $update_url = "/sea/debug.php?p=test/node/update";
	private $remove_url = "/sea/debug.php?p=test/node/remove";
	private $search_url = "/sea/debug.php?p=test/node/search";
	/**
	 * 
	 * @param unknown $nodepath
	 */
	public function __construct($nodepath){
		$this->_initdb();
		$this->nodeinfo = new nodeInfo($nodepath);
		$this->nodeop = new nodeOp();
	}
	public function addUI(){
		$tpl = file_get_contents(dirname(__FILE__)."/tpl/add.tpl");
		return $this->_skeleton(strtr($tpl,array(
				"{nav}" => $this->nodeinfo->getNavLink($this->nodeinfo->nodepath->getNodePath(),$this->index_url),
				"{action}" => $this->append_url,
				"{nodepath}" => $this->nodeinfo->nodepath->getNodePath(),
		)));
	}
	public function appendNode($key,$name){
		return $this->nodeop->addChild($this->nodeinfo->nodepath->getNodePath(),
				$key,$name
		);
	}
	public function indexUI(){
		$tpl = file_get_contents(dirname(__FILE__)."/tpl/index.tpl");
		$data = $this->nodeinfo->getChildInfo();
		$row_tpl = file_get_contents(dirname(__FILE__)."/tpl/index_row.tpl");
		$rowhtml = "";
		foreach ($data as $k => $v){
			$rowhtml .= strtr($row_tpl,array(
					"{name}" => $v,
					"{key}" => $k,
					"{url}" => $this->index_url."&nodepath=".urlencode($this->nodeinfo->nodepath->getChildPath($k)),
			));
		}
		return $this->_skeleton(strtr($tpl,array(
				"{navlink}" => $this->nodeinfo->getNavLink($this->nodeinfo->nodepath->getNodePath(),$this->index_url),
				"{currentnodepath}" => $this->nodeinfo->nodepath->getNodePath(),
				"{addlink}" => $this->add_url,
				"{content}" => $rowhtml,
		)));
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}
	private function _skeleton($content){
		return strtr(file_get_contents(dirname(__FILE__)."/tpl/skeleton.tpl"),array(
			"{csspath}" => "/sea/public/nec/css/",
			"{content}" => $content
		));
	}
}