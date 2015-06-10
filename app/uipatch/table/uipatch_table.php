<?php
/**
 * Date: 2014-9-16
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/uipatch/AUipatch.php";
require_once ENTRY_PATH."/app/data/datasrc/dataSrc.php";
require_once ENTRY_PATH."/app/data/conf/AConf.php";
require_once ENTRY_PATH."/app/data/datasrc/ADataSrc.php";
require_once ENTRY_PATH."/lib/extend/d2calc/d2calc.php";
class uipatch_table extends AUipatch {
	private $buynow_string = "**";
	/**
	 *
	 * @var ADataSrc
	 * data
	 */
	public $datasrc;//data
	/**
	 *
	 * @var AConf
	 */
	public $config;
	private $head;
	private $caption;
	private $body = array ();
	private $last_level;
	public function __construct(ADataSrc $datasrcs, AConf $config) {
		$this->datasrc = $datasrcs;
		$this->config = $config;//new uipatch_table_config ( $this->datasrc->getId (), $config );
	}
	public function debug(){
		var_dump($this->datasrc->data,$this->config->conf);
	}
	public function getData() {
		$this->_make_body ();
		return array (
			"head" => $this->_make_head(),
			"body" => $this->body 
		);
	}
	public static function isSupport($datasrc_id) {
		return in_array ( $datasrc_id, self::getSupportDatasrc () );
	}
	public static function getSupportDatasrc() {
		return array (
			"22tp",
			"23ldp",
			"23tpe",
			"22ap",
			"22ld", 
			"hot" 
		);
	}
	private function _make_head() {
		$conf = $this->config->conf;
		switch ($this->datasrc->getId ()) {
			case "22ap" :
				return array (
						"Amout",
						"Price"
				);
			case "22tp" :
				return array (
						"Title",
						"Price"
				);
			case "23ldp" :
			case "22ld" :
				return array (
						"Title",
						"Day",
						"Price"
				);
			case "23tpe" :
				$extra = $conf["extraCaption"];
				switch ($conf["extraShowMask"]) {
					case "etp" :
						return array (
								$extra,
								"Title",
								"Price"
						);
					case "tep" :
						return array (
								"Title",
								$extra,
								"Price"
						);
					case "tpe" :
						return array (
								"Title",
								"Price",
								$extra
						);
				}
			case "hot":
				return array();
		}
		return array();
	}
	private function _make_body() {
		$calc = null;
		$data = $this->datasrc->data;
		$conf = $this->config->conf;
		switch ($this->datasrc->getId ()) {
			case "22ap" :
				foreach ( $data as $row ) {
					$this->body [] = $this->_build_22ap_row ( $row );
				}
				break;
			case "22tp" :
				foreach ( $data as $row ) {
					$this->body [] = $this->_build_22tp_row ( $row );
				}
				break;
			case "23ldp" :
			case "22ld" :
				$additional = $conf ["span"];
				if (empty ( $additional_data )) {
					$total = $data [count ( $data ) - 1] [0];
					$span = $conf ["spanNum"];
					$additional = $this->_divid_span ( $total, $span );
				}
				if ($this->datasrc->getId () == "23ldp") {
					$data = $this->datasrc->data;
				} else {
					$unitprice = $conf["unitprice"];
					$data = $this->datasrc->data;
				}
				
				if (count ( $data ) == 0) {
					throw new Exception ( "no data",0x321 );
				}
				
				$calc = new d2calc ( $data );
				$isShowCalcData = $conf ["showCalcData"];
				$isShowZero2End = $conf ["showZero2End"];
				$isShowA2B = $conf ["showA2B"];
				sort ( $additional );
				$additional = array_unique ( $additional );
				$len_data = count ( $data );
				$max = $data [$len_data - 1] [0];
				$min = $data [0] [0];
				$final_ret = array ();
				if ($isShowCalcData) {
					if ($this->datasrc->getId () == "23ldp") {
						$last = $this->last_level;
						$tmp = array ();
						foreach ( $data as $row ) {
							$tmp [] = array (
									$last . "-" . $row [0],
									$row [1],
									$row [2] 
							);
							$last = $row [0];
						}
					} else {
						$last = START_LEVEL;
						$tmp = array ();
						foreach ( $data as $row ) {
							$tmp [] = array (
									$last . "-" . $row [0],
									$row [1],
									$row [1] * $unitprice 
							);
							$last = $row [0];
						}
					}
					$final_ret = array_merge ( $final_ret, $tmp );
				}
				if ($isShowZero2End) {
					$additional_z2e_bak = $additional;
					if ($min == $additional_z2e_bak) {
						unset ( $additional_z2e_bak [0] );
					}
					$tmp = array ();
					foreach ( $additional_z2e_bak as $val ) {
						$last = START_LEVEL;
						if ($this->datasrc->getId () == "23ldp") {
							$calc_ret = $calc->calc ( 0, $val, 0 );
							$tmp [] = array (
									$last . "-" . $val,
									$calc_ret ["day"],
									$calc_ret ["price"] 
							);
						} else {
// 							var_dump($val);exit;
							$calc_ret = $calc->calc ( 0, $val, $unitprice );
							$tmp [] = array (
									$last . "-" . $val,
									$calc_ret ["day"],
									$calc_ret ["price"] 
							);
						}
					}
					$final_ret = array_merge ( $final_ret, $tmp );
				}
				if ($isShowA2B) {
					$additional_bak = $additional;
					foreach ( $additional_bak as $i => $val ) {
						
						if ($additional_bak [$i] >= $max) {
							unset ( $additional_bak [$i] );
							$i = 0;
							continue;
						}
						for($j = 0; $j < $len_data; $j ++) {
							if ($additional_bak [$i] == $data [$j] [0] && $i < count ( $additional_bak ) - 1 && $j < $len_data - 1 && $additional_bak [$i + 1] == $data [$j + 1] [0]) {
								unset ( $additional_bak [$i] );
								$i = 0;
								break;
							}
						}
					}
					array_push ( $additional_bak, $max );
					$tmp = array ();
					$last = START_LEVEL;
					foreach ( $additional_bak as $val ) {
						if ($this->datasrc->getId () == "23ldp") {
							$calc_ret = $calc->calc ( $last, $val, 0 );
							$tmp [] = array (
									$last . "-" . $val,
									$calc_ret ["day"],
									$calc_ret ["price"] 
							);
							$last = $val;
						} else {
							$calc_ret = $calc->calc ( $last, $val, $unitprice );
							$tmp [] = array (
									$last . "-" . $val,
									$calc_ret ["day"],
									$calc_ret ["price"] 
							);
							$last = $val;
						}
					}
					$final_ret = array_merge ( $final_ret, $tmp );
				}
				foreach ( $final_ret as $row ) {
					$this->body [] = $this->_build_23ldp_row ( $row );
				}
				break;
			case "23tpe" :
				foreach ( $data as $row ) {
					$this->body [] = $this->_build_23tpe_row ( $row );
				}
				break;
			case "hot" :
				foreach ( $data as $row ) {
					$this->body [] = $this->_build_hot_row ( $row );
				}
				break;
		}
	}
	private function _build_22ap_row($row) {
		$conf = $this->config->conf;
//		var_dump($conf);exit;
		$unitname = $conf["unit"];
		return array(
			(app::calcUnit($unitname,$row[0])),
			CURRENCY_SYMBOL . " " . ($row [1]),
			$row[0]
		); 

	}
	private function _build_22tp_row($row) {
		$row[2] = $row[0];
		return $row;
	}
	private function _build_23ldp_row($row) {
// 		$tmp = explode("-",$row[0]);
		$row[3] = $row[0];//array($tmp[0],$tmp[1]);
		return $row;
	}
	private function _divid_span($total, $span) {
		$num = ( int ) ($total / $span);
		$ret = array ();
		if ($span == 0)
			return array ();
		if ($span > $total) {
			$ret [] = $total;
		} else {
			$mod = $total % $span;
			$u = 0;
			for($i = 0; $i < $span; $i ++) {
				$r = $i < $mod ? ($num + 1) : $num;
				$u += $r;
				$ret [] = $u;
			}
		}
		return $ret;
	}
	private function _build_23tpe_row($row) {
		$conf = $this->config->conf;
		
		$rb = $row;
		$li = "";
		switch ($conf ["extraShowMask"]) {
			case "etp" :
				if ($conf ["extraShowMode"] == "icon") {
					$row [0] = strtr ( $conf ["iconPlaceHolder"], array (
							"{placeholder}" => util::escape ( $rb [2] ) 
					) );
				} else {
					$row [0] = $rb [2];
				}
				if ($conf ["titleType"] == "img") {
					$row [1] = "" . $rb [0] . "";
				} else {
					$row [1] = $rb [0];
				}
				$row [2] = CURRENCY_SYMBOL . " " . $rb [1];
				$li = $row [1];
				break;
			case "tep" :
				if ($conf ["extraShowMode"] == "icon") {
					$row [0] = strtr ( $conf ["iconPlaceHolder"], array (
							"{placeholder}" => util::escape ( $rb [0] ) 
					) );
				} else {
					$row [0] = $rb [0];
				}
				if ($conf ["titleType"] == "img") {
					$row [1] = "" . $rb [2] . "";
				} else {
					$row [1] = $rb [2];
				}
				$row [2] = CURRENCY_SYMBOL . " " . $rb [1];
				$li = $row [0];
				break;
			case "tpe" :
				if ($conf ["extraShowMode"] == "icon") {
					$row [0] = strtr ( $conf ["iconPlaceHolder"], array (
							"{placeholder}" => util::escape ( $rb [0] ) 
					));
				} else {
					$row [0] = $rb [0];
				}
				if ($conf ["titleType"] == "img") {
					$row [1] = CURRENCY_SYMBOL . " " . $rb [1] . "";
				} else {
					$row [1] = CURRENCY_SYMBOL . " " .$rb [1];
				}
				$row [2] =   $rb [2];
				$li = $row [0];
				break;
		}
		$row [3] = $li;
		return $row;
	}
	private function _build_hot_row($row) {
		return $row;
	}
// 	private function _skeleton() {
// 		$conf = $this->config->conf;
// 		if (array_key_exists ( "showType", $conf ) && $conf ["showType"] == "grid") {
// 			return "<div class='uipatch-table uipatch-table-grid'>{caption}{head}{body}</div>";
// 		}
// 		return "<div class='uipatch-table'><table>{caption}<thead>{head}</thead><tbody>{body}</tbody></table></div>";
// 	}
// 	private function _col3() {
// 		return "<tr><td>{col0}</td><td>{col1}</td><td>{col2}</td></tr>";
// 	}
// 	private function _col4() {
// 		return "<tr><td>{col0}</td><td>{col1}</td><td>{col2}</td><td>{col3}</td></tr>";
// 	}
}