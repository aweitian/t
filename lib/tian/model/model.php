<?php
/**
 * @author awei.tian
 * date: 2013-11-20
 * function:模型用于保持数据以及与其相关的业务逻辑
 * 模型是单独的数据对象。它可以是数据表中的一行，
 * 或者一个用户输入的表单。 数据对象的每个字段对应模型中的一个属性。
 * 每个属性有一个标签（label）， 并且可以通过一系列规则进行验证。
 */
C::addAutoloadPath("validator", LIB_PATH."/validate/validator.php");
abstract class model{
	protected $errors=array();       // attribute name => array of errors
	protected $validators;           // validators
	protected $scenario='';          // scenario
	public function __get($name){
		return false;
	}
	public function __set($name,$val){
		return false;
	}
	abstract public function attributeNames();
	/**
	 * Returns the attribute labels.
	 * Attribute labels are mainly used in error messages of validation.
	 * By default an attribute label is generated using {@link generateAttributeLabel}.
	 * This method allows you to explicitly specify attribute labels.
	 *
	 * Note, in order to inherit labels defined in the parent class, a child class needs to
	 * merge the parent labels with child labels using functions like array_merge().
	 *
	 * @return array attribute labels (name=>label)
	 * @see generateAttributeLabel
	 */
	public function attributeLabels()
	{
		return array();
	}
	/**
	 ** <pre>
	 * array(
	 *     array('username', 'require'),
	 *     array('username', 'length', 'minSize'=>3, 'maxSize'=>12),
	 *     array('password', 'compare', 'compareAttribute'=>'password2', 'on'=>'register'),
	 *     array('password', 'authenticate', 'on'=>'login'),
	 * );
	 * </pre>
	 */
	public function rules()
	{
		return array();
	}
	public function validate($attributes=null, $clearErrors=true)
	{
		if($clearErrors)
			$this->clearErrors();

		foreach($this->getValidators() as $validator)
			$validator->validate($this,$attributes);

		return !$this->hasErrors();

	}
	public function addError($attribute,$error)
	{
		$this->errors[$attribute][]=$error;
	}
	public function hasErrors($attribute=null)
	{
		if($attribute===null)
			return $this->errors!==array();
		else
			return isset($this->errors[$attribute]);
	}
	public function getErrors(){
		return $this->errors;
	}
	/**
	 * @param string $attribute
	 * @return array(validator1,validator2)
	 */
	public function getValidators($attribute=null)
	{
		if($this->validators===null)
			$this->validators=$this->createValidators();
	
		$validators=array();
		$scenario=$this->getScenario();
		foreach($this->validators as $validator)
		{
			if($validator->applyTo($scenario))
			{
				if($attribute===null || in_array($attribute,$validator->attributes,true))
					$validators[]=$validator;
			}
		}
		return $validators;
	}
	
	public function createValidators()
	{
		$validators=array();
		foreach($this->rules() as $rule)
		{
			if(isset($rule[0],$rule[1]))  // attributes, validator name
				$validators[]=validator::createValidator($rule[1],$this,$rule[0],array_slice($rule,2));
			else
				throw new Exception('The rule must specify attributes to be validated and the validator name.');
		}
		return $validators;
	}
	public function getScenario()
	{
		return $this->scenario;
	}
	public function getAttributeLabel($attribute)
	{
		$labels=$this->attributeLabels();
		if(isset($labels[$attribute]))
			return $labels[$attribute];
		else
			return $this->generateAttributeLabel($attribute);
	}
	public function clearErrors($attribute=null)
	{
		if($attribute===null)
			$this->errors=array();
		else
			unset($this->errors[$attribute]);
	}
	/**
	 * Generates a user friendly attribute label.
	 * This is done by replacing underscores or dashes with blanks and
	 * changing the first letter of each word to upper case.
	 * For example, 'department_name' or 'DepartmentName' becomes 'Department Name'.
	 * @param string $name the column name
	 * @return string the attribute label
	 */
	public function generateAttributeLabel($name)
	{
		return ucwords(trim(strtolower(str_replace(array('-','_','.'),' ',preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $name)))));
	}
}