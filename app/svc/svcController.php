<?php
/**
 * @author awei.tian
 * date: 2015-2-12
 * 说明:
 */
require_once ENTRY_PATH."/app/modules/nodeleaf/nodeleafModule.php";
require_once dirname(__FILE__)."/svcView.php";
require_once dirname(__FILE__)."/svcModel.php";
class svcController extends appController{
	/**
	 * 
	 * @var svcModel
	 */
	protected $model;
	/**
	 * 
	 * @var svcView
	 */
	protected $view;
	private $path;
	private $oi;
	private $orders;
	
	private $html = array();
	public function __construct(message $msg,$pi){
		$this->view = new svcView();
		$this->model = new svcModel();
// 		var_dump($pi);
		if($pi == "" || $pi == "/"){
			$this->all();
			return ;
		}
		$this->model = new svcModel();
		$this->view = new svcView();
		$this->path = $pi;
		$this->oi = new widgetInfo();
		$this->initOrders();
		$this->initWidgets();
		$this->show();
	}
	private function all(){
		$this->view->showData($this->model->getData());
	}
	
	
	private function initOrders(){
		//var_dump($this->path);exit;
		try{
			$this->orders = $this->oi->getWidgets($this->path);
		}catch (Exception $e){
			$this->view->showErr($e->getMessage());
		}
		if(empty($this->orders)){
			if(!$this->oi->exists($this->path)){
				$this->view->_404();
			}else{
				$this->html[] = "no contents yet!";
			}
		}
	}
	private function initWidgets(){
		foreach($this->orders as $item){
			try{
				//echo nodeleafModule::ti2wt($item["typeid"]);
				//if(nodeleafModule::ti2wt($item["typeid"]) == "calc")exit;
				switch (nodeleafModule::ti2wt($item["typeid"])){
					case "table":
						$inst_wgt = new widget_table($this->path, $item["order"]);
						$this->html[] = $inst_wgt->getHTML();
						break;
					case "spancalc":
						$inst_wgt = new widget_spancalc($this->path, $item["order"]);
						$this->html[] = $inst_wgt->getHTML();
						break;
					case "calc":
						$inst_wgt = new widget_calc($this->path, $item["order"]);
						$this->html[] = $inst_wgt->getHTML();
						break;
					case "html":
						$inst_wgt = new widget_html($this->path, $item["order"]);
						$this->html[] = $inst_wgt->getHTML();
						break;
					default:
						break;
				}				
			}catch (Exception $e){
				if(APP_DEBUG){
					$this->view->showErr($e->getMessage()."<br>Order:".$item["order"]);
				}
			}
		}
	}
	private function show(){
		$this->view->showData(join("",$this->html));
	}
}