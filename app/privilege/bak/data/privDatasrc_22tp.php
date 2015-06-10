<?php
/**
 * @author:awei.tian
 * @date: 2014-10-4
 * @functions:
 */
require_once dirname(dirname(__FILE__))."/privilege.php";
require_once dirname(dirname(dirname(__FILE__)))."/ttree/data/datasrc_22tpOp.php";
require_once dirname(dirname(dirname(__FILE__)))."/ttree/data/datasrc_22tpInfo.php";
require_once dirname(dirname(dirname(__FILE__)))."/datasrc/path2sid.php"; 
require_once dirname(dirname(dirname(__FILE__)))."/datasrc/pathDeco.php"; 
class privDatasrc_22tp extends privilege{
	private $index_url  = "/sea/debug.php?p=/test/priv_data/22tp/index";
	private $add_url    = "/sea/debug.php?p=/test/priv_data/22tp/add";
	private $append_url = "/sea/debug.php?p=/test/priv_data/22tp/append";
	private $edit_url   = "/sea/debug.php?p=/test/priv_data/22tp/edit";
	private $update_url = "/sea/debug.php?p=/test/priv_data/22tp/update";
	private $remove_url = "/sea/debug.php?p=/test/priv_data/22tp/remove";
	private $search_url = "/sea/debug.php?p=/test/priv_data/22tp/search";
	/**
	 * @var path2sid
	 */
	public $path2sid;
	/**
	 * @var datasrc_22tpInfo
	 */
	public $info;
	/**
	 * @var datasrc_22tpOp
	 */
	public $op;
	/**
	 * @var pathDeco
	 */
	public $pathDeco;
	public function __construct($datasrc_path){
		$this->info = new datasrc_22tpInfo($datasrc_path);
		$this->op = new datasrc_22tpOp();
		$this->path2sid = new path2sid();
		$this->pathDeco = new pathDeco($datasrc_path);
	}
	/**
	 * return add ui html
	 */
	public function add(){
		$tpl = file_get_contents(dirname(__FILE__)."/tpl/22tp/add.tpl");
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
		$tpl = file_get_contents(dirname(__FILE__)."/tpl/22tp/edit.tpl");
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