<?php
/**
 * Date: 2014-9-29
 * Author: Awei.tian
 * function: 
 */
require_once dirname(dirname(__FILE__))."/privilege.php";
require_once dirname(dirname(dirname(__FILE__)))."/ttree/namespace/namespaceNodeOp.php";
require_once dirname(dirname(dirname(__FILE__)))."/datasrc/DataSrc.php";
require_once dirname(dirname(dirname(__FILE__)))."/datasrc/DataSrcOp.php";
class privNsPath extends privilege{
	private $namespaceNodeOp;
	private $namespaceNodeInfo;
	private $index_url = "/sea/debug.php?p=test/namespace/path/index";
	private $add_url = "/sea/debug.php?p=test/namespace/path/add";
	private $append_url = "/sea/debug.php?p=test/namespace/path/append";
	private $edit_url = "/sea/debug.php?p=test/namespace/path/edit";
	private $update_url = "/sea/debug.php?p=test/namespace/path/update";
	private $remove_url = "/sea/debug.php?p=test/namespace/path/remove";
	private $search_url = "/sea/debug.php?p=test/namespace/path/search";
	/**
	 * privilege namespace node
	 * @param unknown $nodepath
	 */
	public function __construct($nodepath){
		$this->_initdb();
		$this->namespaceNodeInfo = new namespaceNodeInfo($nodepath);
		$this->namespaceNodeOp = new namespaceNodeOp();
	}
	public function addUI(){
		$tpl = file_get_contents(dirname(__FILE__)."/tpl/node/add.tpl");
		return $this->_skeleton(strtr($tpl,array(
				"{action}" => $this->append_url,
				"{nodepath}" => $this->namespaceNodeInfo->nodepath->getNodePath(),
		)));
	}
	public function editUI($id){
		$data = $this->namespaceNodeInfo->getInfoById($id);
		$tpl = file_get_contents(dirname(__FILE__)."/tpl/node/edit.tpl");
		return $this->_skeleton(strtr($tpl,array(
				"{action}" => $this->update_url,
				"{nssid}" => $data[0],
				"{key}" => $data[1],
				"{deco}" => $data[2],
				"{comment}" => $data[3]
		)));		
	}
	public function listUI(){
		
	}
	/**
	 * @param int $nssid
	 * @param string $key
	 * @param string $desc
	 * @param string $comment
	 * @return 返回影响的行数
	 */
	public function update($nssid,$key,$desc="",$comment=""){
		return $this->namespaceNodeOp->update($nssid,$key,$desc,$comment);
	}
	/**
	 * @param string $key
	 * @param string $desc
	 * @param string $comment
	 * @return nsssid
	 */
	public function append($key,$desc="",$comment=""){
		return $this->namespaceNodeOp->add($this->namespaceNodeInfo->nodepath->getNodePath(), $key,$desc,$comment);
	}
	public function indexUI(){

	}

}