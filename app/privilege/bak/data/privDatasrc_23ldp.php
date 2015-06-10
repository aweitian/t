<?php
/**
 * @author:awei.tian
 * @date: 2014-10-4
 * @functions:
 */
require_once dirname(dirname(__FILE__))."/privilege.php";
require_once dirname(dirname(dirname(__FILE__)))."/ttree/data/datasrc_23ldpOp.php";
require_once dirname(dirname(dirname(__FILE__)))."/ttree/data/datasrc_23ldpInfo.php";
require_once dirname(dirname(dirname(__FILE__)))."/datasrc/path2sid.php"; 
require_once dirname(dirname(dirname(__FILE__)))."/datasrc/pathDeco.php"; 
class privDatasrc_23ldp extends privilege{
	private $index_url  = "/sea/debug.php?p=/test/priv_data/23ldp/index";
	private $add_url    = "/sea/debug.php?p=/test/priv_data/23ldp/add";
	private $append_url = "/sea/debug.php?p=/test/priv_data/23ldp/append";
	private $edit_url   = "/sea/debug.php?p=/test/priv_data/23ldp/edit";
	private $update_url = "/sea/debug.php?p=/test/priv_data/23ldp/update";
	private $remove_url = "/sea/debug.php?p=/test/priv_data/23ldp/remove";
	private $search_url = "/sea/debug.php?p=/test/priv_data/23ldp/search";
	/**
	 * @var path2sid
	 */
	public $path2sid;
	/**
	 * @var datasrc_23ldpInfo
	 */
	public $info;
	/**
	 * @var datasrc_23ldpOp
	 */
	public $op;
	/**
	 * @var pathDeco
	 */
	public $pathDeco;
	public function __construct($datasrc_path){
		$this->info = new datasrc_23ldpInfo($datasrc_path);
		$this->op = new datasrc_23ldpOp();
		$this->path2sid = new path2sid();
		$this->pathDeco = new pathDeco($datasrc_path);
	}
	/**
	 * return add ui html
	 */
	public function add(){
		$tpl = file_get_contents(dirname(__FILE__)."/tpl/23ldp/add.tpl");
		$dsnsid = $this->path2sid->getDsnsidByPath($this->info->path->toString());
		return $this->_skeleton(strtr($tpl,array(
				"{action}" => $this->append_url,
				"{dsnsid}" => $dsnsid,
				"{loc}" => $this->info->path->toString(),
				"{deco}" => $this->pathDeco->getDecoPath(),
		)));
	}
	public function append($dsnsid,$data){
		return $this->op->add($dsnsid, $data);
	}
	public function edit(){
		$tpl = file_get_contents(dirname(__FILE__)."/tpl/23ldp/edit.tpl");
		$dsnsid = $this->path2sid->getDsnsidByPath($this->info->path->toString());
		$data = $this->info->getDatasrcByDsnsid($dsnsid);
		return $this->_skeleton(strtr($tpl,array(
			"{action}" => $this->update_url,
			"{dsnsid}" => $dsnsid,
			"{loc}" => $this->info->path->toString(),
			"{data}" => json_encode($data->getData()),
			"{deco}" => $this->pathDeco->getDecoPath(),
		)));
	}
	public function update($dsnsid,$data){
		return $this->op->update($dsnsid, $data);
	}
	public function remove($dsnsid){
		return $this->op->removeByNsdsid($dsnsid);
	}
}