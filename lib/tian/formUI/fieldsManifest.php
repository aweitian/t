<?php
/**
 * @author:awei.tian
 * @date:2013-12-9
 * @functions:
 */
class fieldsManifest{

	public $clsname_datetime = "datetimepicker";
	public $clsname_date = "datepicker";
	public $clsname_enumview = "showtitle";
	public $clsname_viewiframe = "viewiframe";
	public $clsname_tbhelper_icon = "tbhelper_icon";
	
	
	public $num_greaterThanOnMuti=2;
	public $num_greaterThanOnSingle=2;
	
	public $maxNumOnDisplay=15;
	
	public $picOnDisplayWidth=275;
	public $picOnDisplayHeight=275;
	public $picOnViewWidth=75;
	public $picOnViewHeight=75;
	
	public $scenario;
	
	public $rules=null;
	
	private $_supported_type=array();
	public static $typeArr = array(
		"textarea"=>"textarea",
		"input_str"=>"input_str",
		"input_num"=>"input_num",
		"input_file"=>"input_file",
		"input_date"=>"input_date",
		"input_datetime"=>"input_datetime",
		"set"=>"set",
		"enum"=>"enum",
		"checkbox"=>"checkbox",
		"select_muti"=>"select_muti",
		"radio"=>"radio",
		"select_single"=>"select_single",
	);
	
	public function __construct($scenario="add"){
		$this->rules=$this->rules();
		switch ($scenario){
			case "display":
				$this->scenario=$scenario;break;
			case "view":
				$this->scenario=$scenario;break;
			case "edit":
				$this->scenario=$scenario;break;
			case "add":
				$this->scenario=$scenario;break;				
		}
	}
	/**
	 * 			
	 * @return 
	 * <pre>"field1"=>array(
			"type"=>fieldsManifest::textarea,
			"options"=>array(
				"cols"=>33,
				"rows"=>33,
			),
			"key"=>array()//用于21,22,31,32
			"value"=>array()//用于21,22,31,32
			* "selectedValue"=""//=key
		),
		"field2"=>array(
			"type"=>"",
			"options"=>array()
		),
	</pre>
	 */
	public function rules(){
		return array(
		);
	}
	/**
	 * @return array key=field,value=string
	 * @throws Exception
	 * @return multitype:NULL
	 */
	public function getData(){
		$ret=array();
		foreach ($this->rules as $field=>$rule){
			switch ($this->scenario){
				case "add":
				case "edit":
				case "view":
				case "display":
					break;
				default:throw new Exception("scenario error @ formui",0x1);
			}
			$ret[$field]=$this->_m($this->scenario,$field, $rule);
		}
		return $ret;
	}
	/**
	 * 
	 * @param string $field 使用于rules,如果OPTIONS中没有NAME就把它作为NAME //if(!array_key_exists("name",$options))$options["name"]=$fidld;
	 * @param string $type 直接使用INPUT TYPE属性 支持列表,括号为别名: textarea,input_str(text),input_num,input_file(file),input_date,input_datetime,set,enum,checkbox,select_muti,radio,select_single(select)
	 * @param array $options 用于HTML属性 (如果存在RULES,options和原来的合并,后加的覆盖前面的)
	 * @param array $key 作用于checkbox,radio,select_muti,select_single,enum,set等
	 * @param array $value 作用于SET,ENUM等
	 * @param string/array $selectedValue 作用于SET,ENUM等,如果是单选的,为字符串,多选可以为f1,f2,f3,...字符串，或者数组
	 */
	public function addField($field,$type,$options=array(),$key=null,$value=null,$selectedValue=null){
		$type = $this->trAlias($type);
		if(!array_key_exists($type, self::$typeArr)){
			throw new Exception("Type error:".$type,0x2);
		}
		if(isset($this->rules[$field]["options"]) && is_array($this->rules[$field]["options"])){
			$pre_options=$this->rules[$field]["options"];
		}else{
			$pre_options=array();
		}
		$options=$options+$pre_options;
		$this->rules[$field]=array();
		
		$this->rules[$field]["type"]=$type;
		$this->rules[$field]["options"]=$options;
		switch ($type){
			case "checkbox":
			case "radio":
			case "select_muti":
			case "select_single":
			case "enum":
			case "set":
				if(is_array($key))$this->rules[$field]["key"]=$key;
				else throw new Exception("key is required @ formui.",0x3);
				if(is_array($value))$this->rules[$field]["value"]=$value;
				if(is_string($selectedValue) || is_array($selectedValue))$this->rules[$field]["selectedValue"]=$selectedValue;
		}
		
	}
	
	private function trAlias($type){
		switch ($type){
			case "file":
				return "input_file";
			case "select":
				return "select_single";
			case "text":
				return "input_str";
			case "hidden":
				return "input_hide";
			default:
				return $type;
		}
	}
	
	/**
	 * 处理了在VIEW,DISPLAY场景下IMG的SRC
	 * @param unknown $field
	 * @param unknown $value
	 */
	public function updateFieldValue($field,$value){
		switch ($this->scenario){
			case "display":
			case "view":
				if($this->rules[$field]["type"]=="input_file"){
					$this->rules[$field]["options"]["src"]=$value;
					return;
				}
		}
		$this->rules[$field]["options"]["value"]=$value;
	}
	private function _m($m,$fidld,$rule){
		$method="_".$this->_getTypeByConstType($fidld, $rule)."_".$m;
		return $this->$method($fidld,$rule);
	}
	private function _getTypeByConstType($fidld,$rule){
		switch ($rule["type"])
		{
			case "set":
				if(count($rule["key"])>$this->num_greaterThanOnMuti){
					return "select_muti";
				}
				return "checkbox";
			case "enum":
				if(count($rule["key"])>$this->num_greaterThanOnSingle){
					return "select_single";
				}
				return "radiobox";
			case "textarea":
				return "textarea";
			case "input_str":
			case "input_num":
				return "text";
			case "input_file":
				return "varbinary";
			case "input_date":
				return "date";
			case "input_datetime":
				return "datetime";
			case "checkbox":
				return "checkbox";
			case "select_muti":
				return "select_muti";
			case "radio":
				return "radiobox";
			case "select_single":
				return "select_single";
			default:
				throw new Exception("unrecognized type @ formUI.",0x9);
		}
	}
	private function _options_to_str($fidld,$rule){
		$options=$rule["options"];
		if(!array_key_exists("name",$options))$options["name"]=$fidld;
		$ret=array();
		foreach ($options as $key=>$val){
			$ret[]=$key."=\"".htmlspecialchars($val, ENT_NOQUOTES)."\"";
		}
		return implode(" ", $ret);
	}
	private function _textarea_add($fidld,$rule){
		if(isset($rule['options']['value'])){
			$defaultValue=$rule['options']['value'];
			unset($rule['options']['value']);
		}else{
			$defaultValue="";
		}
		return "<textarea ".$this->_options_to_str($fidld,$rule).">".$defaultValue."</textarea>";
	}
	private function _textarea_edit($fidld,$rule){
		return $this -> _textarea_add($fidld,$rule);
	}
	private function _textarea_view($fidld,$rule){//defaultValue
		$str = $rule['options']["value"];
		if($this -> _has_html($str)){
			return $this -> iframe_html($str);
		}else{
			return nl2br($str);
		}
	}
	private function _textarea_display($fidld,$rule){
		$str = $rule['options']["value"];
		if($this -> _has_html($str)){
			return util::substr(htmlspecialchars($str, ENT_NOQUOTES),0,15);
		}else{
			return nl2br($str);
		}
	}
	
	//------------------- :: datetime :: ---------------------------------------------------------
	private function _datetime_add($fidld,$rule){
		if(isset($rule['options']['class'])){
			$rule['options']['class'].=" ".$this->clsname_datetime;
		}else{
			$rule['options']['class']=$this->clsname_datetime;
		}
		return "<input ".$this->_options_to_str($fidld,$rule).">";
	}
	private function _datetime_edit($fidld,$rule){
		return $this -> _datetime_add($fidld,$rule);
	}
	private function _datetime_view($fidld,$rule){
		$dt = $rule['options']["value"];
		$dta = explode(" ",$dt);
		return "<span title='".($dt)."'>".$dta[0]."</span>";
	}
	private function _datetime_display($fidld,$rule){//defaultValue
		return $rule['options']["value"];
	}
	
	//------------------- :: date :: ---------------------------------------------------------
	private function _date_add($fidld,$rule){
		if(isset($rule['options']['class'])){
			$rule['options']['class'].=" ".$this->clsname_date;
		}else{
			$rule['options']['class']=$this->clsname_date;
		}
		return "<input ".$this->_options_to_str($fidld,$rule).">";
	}
	private function _date_edit($fidld,$rule){
		return $this -> _date_add($fidld,$rule);
	}
	private function _date_view($fidld,$rule){
		return $rule['options']["value"];
	}
	private function _date_display($fidld,$rule){
		return $rule['options']["value"];
	}
	
	//------------------- :: enum :: ---------------------------------------------------------
	private function _select_single_add($fidld,$rule){
		$values = isset($fidld,$rule["value"]) ? $rule['value'] : false;
		$enum = $rule["key"];
		if($values){
			$enum = array_combine($enum,$values);
		}else{
			$enum = array_combine($enum,$enum);
		}
		if(isset($rule["selectedValue"])){
			$selectedValue = $rule["selectedValue"];
		}else if(isset($rule["options"]["value"])){
			$selectedValue = $rule["options"]["value"];
		}else{
			$selectedValue="";
		}
		$fragment = '';
		$fragment.= "<select ".$this->_options_to_str($fidld,$rule).">";
		foreach($enum as $k => $v){
			$fragment.= "<option".
					($k==$selectedValue ? " selected" : "")
					." value=\"".
					htmlentities($k,ENT_QUOTES)
					."\">".$v."</option>";
		}
		$fragment.= "</select>";
		return $fragment;
	}
	private function _select_single_edit($fidld,$rule){
		return $this -> _select_single_add($fidld,$rule);
	}
	private function _select_single_view($fidld,$rule){
		$values = isset($fidld,$rule["value"]) ? $rule['value'] : false;
		$enum = $rule["key"];
		if($values){
			$enum = array_combine($enum,$values);
		}
		if(isset($rule["selectedValue"])){
			$selectedValue = $rule["selectedValue"];
		}else if(isset($rule["options"]["value"])){
			$selectedValue = $rule["options"]["value"];
		}else{
			$selectedValue="";
		}
		return $values ? '<span title="'.$selectedValue.'" class="'.$this -> clsname_enumview.'">'.$enum[$selectedValue].'</span>' : $rule['options']["value"];
	}
	private function _select_single_display($fidld,$rule){
		return $this -> _select_single_view($fidld,$rule);
	}
	
	
	private function _radiobox_add($fidld,$rule){
		$values = isset($fidld,$rule["value"]) ? $rule['value'] : false;
		$enum = $rule["key"];
		if($values){
			$enum = array_combine($enum,$values);
		}else{
			$enum = array_combine($enum,$enum);
		}
		if(isset($rule["selectedValue"])){
			$selectedValue = $rule["selectedValue"];
		}else if(isset($rule["options"]["value"])){
			$selectedValue = $rule["options"]["value"];
		}else{
			$selectedValue="";
		}
		
		$rule["options"]["type"]="radio";
		$fragment = '';
		foreach($enum as $k => $v){
			$rule["options"]["value"]=$k;
			$fragment.= "<input ".$this->_options_to_str($fidld,$rule)."".
					($k==$selectedValue ? " checked" : "")
					.">".$v;
		}
		return $fragment;
	}
	private function _radiobox_edit($fidld,$rule){
		return $this -> _radiobox_add($fidld,$rule);
	}
	private function _radiobox_view($fidld,$rule){
		return $this->_select_single_view($fidld,$rule);
	}
	private function _radiobox_display($fidld,$rule){//^
		return $this -> _radiobox_view($fidld,$rule);
	}
	
	//------------------- :: set :: ---------------------------------------------------------
	private function _select_muti_add($fidld,$rule){
		$values = isset($fidld,$rule["value"]) ? $rule['value'] : false;
		$enum = $rule["key"];
		if($values){
			$enum = array_combine($enum,$values);
		}else{
			$enum = array_combine($enum,$enum);
		}
		if(isset($rule["selectedValue"])){
			$selectedValue = $rule["selectedValue"];
		}else if(isset($rule["options"]["value"])){
			$selectedValue = $rule["options"]["value"];
		}else{
			$selectedValue = "";
		}
		if(is_string($selectedValue)){
			$selectedValue = explode(",",$selectedValue);
		}
		$rule["options"]["multiple"]="multiple";
		$rule["options"]["name"]=$fidld."[]";

		$fragment = '';
		$fragment.= "<select ".$this->_options_to_str($fidld,$rule).">";
		foreach($enum as $k => $v){
			$rule["options"]["value"]=$k;
			$fragment.= "<option".(in_array($k,$selectedValue) ? " selected" : "")." value=\"".
				htmlentities($k,ENT_QUOTES)."\">".$v."</option>";
		}
		$fragment.= "</select>";
		return $fragment;
	}
	private function _select_muti_edit($fidld,$rule){//^
		return $this -> _select_muti_add($fidld,$rule);
	}
	private function _select_muti_view($fidld,$rule){
		$values = isset($fidld,$rule["value"]) ? $rule['value'] : false;
		$enum = $rule["key"];
		if($values){
			$enum = array_combine($enum,$values);
		}else{
			$enum = array_combine($enum,$enum);
		}
		if(isset($rule["selectedValue"])){
			$selectedValue = $rule["selectedValue"];
		}else if(isset($rule["options"]["value"])){
			$selectedValue = $rule["options"]["value"];
		}else{
			$selectedValue="";
		}
		if(is_string($selectedValue)){
			$selectedValue = explode(",",$selectedValue);
		}
		$fragment = array();
		foreach($enum as $k => $v){
			if(in_array($k,$selectedValue)){
				$fragment[] = "<span title='".$k."'>".$v."</span>";
			}
		}
		return join(' , ',$fragment);
	}
	private function _select_muti_display($fidld,$rule){//^
		return $this -> _select_muti_view($fidld,$rule);
	}
	private function _checkbox_add($fidld,$rule){
		$values = isset($fidld,$rule["value"]) ? $rule['value'] : false;
		$enum = $rule["key"];
		if($values){
			$enum = array_combine($enum,$values);
		}else{
			$enum = array_combine($enum,$enum);
		}
		if(isset($rule["selectedValue"])){
			$selectedValue = $rule["selectedValue"];
		}else if(isset($rule["options"]["value"])){
			$selectedValue = $rule["options"]["value"];
		}else{
			$selectedValue="";
		}
		if(is_string($selectedValue)){
			$selectedValue = explode(",",$selectedValue);
		}
		$rule["options"]["name"]=$fidld."[]";
		$rule["options"]["type"]="checkbox";

		$fragment = '';
		foreach($enum as $k => $v){
			$rule["options"]["value"]=$k;
			$fragment.= "<input ".$this->_options_to_str($fidld,$rule)."".(in_array($k,$selectedValue) ? " selected" : "").">".$v."";
		}
		return $fragment;
	}
	private function _checkbox_edit($fidld,$rule){//^
		return $this -> _checkbox_add($fidld,$rule);
	}
	private function _checkbox_view($fidld,$rule){
		return $this->_select_muti_view($fidld, $rule);
	}
	private function _checkbox_display($fidld,$rule){//^
		return $this -> _checkbox_view($fidld,$rule);
	}
	
	//------------------- :: varbinary :: ---------------------------------------------------------
	private function _varbinary_add($fidld,$rule){
		$rule["options"]["type"]="file";
		return "<input ".$this->_options_to_str($fidld,$rule).">";
	}
	private function _varbinary_edit($fidld,$rule){
		return "<input ".$this->_options_to_str($fidld,$rule).">";
	}
	private function _varbinary_view($fidld,$rule){
		if(!isset($rule['options']['width']))$rule['options']['width']=$this->picOnViewWidth;
		if(!isset($rule['options']['height']))$rule['options']['height']=$this->picOnViewHeight;
		$rule['options']['class']=$this -> clsname_tbhelper_icon;
// 		$src=$rule['options']["value"];
// 		unset($rule['options']["value"]);
// 		$rule['options']["src"]=$src;
		return "<img ".$this->_options_to_str($fidld,$rule).">";
	}
	private function _varbinary_display($fidld,$rule){
		if(!isset($rule['options']['width']))$rule['options']['width']=$this->picOnDisplayWidth;
		if(!isset($rule['options']['height']))$rule['options']['height']=$this->picOnDisplayHeight;
		$rule['options']['class']=$this->clsname_tbhelper_icon;
// 		$src=$rule['options']["value"];
// 		unset($rule['options']["value"]);
// 		$rule['options']["src"]=$src;
		return "<img ".$this->_options_to_str($fidld,$rule).">";
	}
	
	//------------------- :: text :: ---------------------------------------------------------
	private function _text_add($fidld,$rule){
		return "<input ".$this->_options_to_str($fidld,$rule).">";
	}
	private function _text_edit($fidld,$rule){
		return $this -> _text_add($fidld,$rule);
	}
	private function _text_view($fidld,$rule){
		return htmlspecialchars($rule['options']["value"], ENT_NOQUOTES);
	}
	private function _text_display($fidld,$rule){
		return $this->_text_view($fidld, $rule);
	}
	//--------------------------------------------
	private function _has_html($str){
		return preg_match("/<[a-zA-Z]+[^>]*>/",$str);
	}
	private function iframe_html($str){
		return $str;
	}
}