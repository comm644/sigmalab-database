<?php 
/**
 * @noinspection KphpReturnTypeMismatchInspection
 * @noinspection NoTypeDeclarationInspection
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpIllegalPsrClassPathInspection
 * @noinspection DegradedSwitchInspection 
 */
namespace Database;



use ADO\src\Sigmalab\Database\Core\DBSettings;
use Sigmalab\Database\DatabaseArgumentException;
use Sigmalab\Database\Expressions\ExprEQ;
use Sigmalab\Database\Expressions\IExpression;
use Sigmalab\Database\Sql\SQLJoin;
use Sigmalab\IsKPHP;
use Sigmalab\SimpleReflection\ClassRegistry;
use Sigmalab\SimpleReflection\ICanReflection;
use Sigmalab\SimpleReflection\PhpReflection;

use \Sigmalab\SimpleReflection\IReflectedObject;
use \Sigmalab\SimpleReflection\ReflectionException;

//autogenerated
class DictionaryId_reflection implements \Sigmalab\SimpleReflection\ICanReflection
{
	/** DictionaryId */
	private DictionaryId $instance;

	public const Field_dictionary_id = "dictionary_id";

	
	public function __construct(DictionaryId $instance) 
	{
		$this->instance = $instance;
	}	
	/**
	 * @kphp-required
	 * @param string $name
	 * @return bool
	 */
	public function isPropertyExists(string $name):bool
	{
		//autogenerated map
		switch ($name) {
			case self::Field_dictionary_id: return true;
		}
		return false;
	}
	
	/**
	 * @kphp-required
	 * @return string[]
	 *
	 */
	public function getProperties() : array
	{
		return [self::Field_dictionary_id];
	}
	
	/**
	 * @kphp-required
	 * @param string $name
	 * @return \Sigmalab\SimpleReflection\TypeName
	 *
	 */
	public function getPropertyType(string $name) : \Sigmalab\SimpleReflection\TypeName
	{
		//autogenerated map
		switch ($name) {
			case self::Field_dictionary_id: return \Sigmalab\SimpleReflection\TypeName::$intValue;
			default:
				//throw new ReflectionException("Property '{$name}' not found in DictionaryId"); 
		}
		return \Sigmalab\SimpleReflection\TypeName::$intValue;
	}
	

	/**
	 * @kphp-required
	 * @param string $name
	 * @param \Sigmalab\SimpleReflection\ValueMixed $value
	 */
	public function setPropertyValue(string $name, \Sigmalab\SimpleReflection\ValueMixed $value) : void
	{
		//autogenerated map
		switch ($name) {
/* int: int type:int isArray:  */
		case self::Field_dictionary_id:
			if ($value instanceof \Sigmalab\SimpleReflection\ValueScalar) {
				$this->instance->dictionary_id = $value->get_as_int();
			}

			break;
			default:
				//throw new ReflectionException("Property '{$name}' not found in DictionaryId"); 
		}
	}

	/**
	 * @kphp-required
	 * @param string $name
	 * @return \Sigmalab\SimpleReflection\ValueMixed
	 */
	public function getPropertyValue(string $name) :\Sigmalab\SimpleReflection\ValueMixed
	{
		//autogenerated map
		switch ($name) {
			case self::Field_dictionary_id: return new \Sigmalab\SimpleReflection\ValueScalar( $this->instance->dictionary_id );
			default:
				//throw new ReflectionException("Property '$name' not found in DictionaryId");

				
		}
		return null;
	}
	
	/**  execute register class via reflection class instance */
	public function dynamicRegister(){
		self::registerClass();
	}
	/** @noinspection PhpFullyQualifiedNameUsageInspection */
	public static function registerClass()
	{   
		\Sigmalab\SimpleReflection\ClassRegistry::registerClass(DictionaryId::class, function(){
			return instance_cast(new DictionaryId, IReflectedObject::class ); 
		});
		\Sigmalab\SimpleReflection\ClassRegistry::registerReflection(self::class, function(object $instance){
			/** @noinspection PhpParamsInspection */ 
			return new DictionaryId_reflection(instance_cast($instance, DictionaryId::class)); 
		});
		
	}
	

	/**
	* @inheritDoc
	*/
	public function invoke_as_mixed(string $methodName, array $args) 
	{
		switch ($methodName)
		{
 //type: string 
			case 'table_name':
				return $this->invoke_table_name($args);
				break;
 //type: string 
			case 'table_description':
				return $this->invoke_table_description($args);
				break;
 //type: int 
			case 'primary_key_value':
				return $this->invoke_primary_key_value($args);
				break;
 //type: bool 
			case 'set_dictionary_id':
				return $this->invoke_set_dictionary_id($args);
				break;
 //type: int 
			case 'get_dictionary_id':
				return $this->invoke_get_dictionary_id($args);
				break;
			default:
				//throw new ReflectionException("Property '$methodName' not found in DictionaryId");

				
		}
	}
	/**
	* @inheritDoc
	*/
	public function invoke_as_object(string $methodName, array $args) :?IReflectedObject
	{
		return null;
	}

	/**
	 * @param string $methodName
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 */
	public function invoke_as_void(string $methodName, array $args) :void
	{
		switch ($methodName)
		{
			case 'createSelf':
				$this->invoke_createSelf($args);
				break;
			case 'table_name':
				$this->invoke_table_name($args);
				break;
			case 'table_description':
				$this->invoke_table_description($args);
				break;
			case 'getPrimaryKeyTag':
				$this->invoke_getPrimaryKeyTag($args);
				break;
			case 'primary_key_value':
				$this->invoke_primary_key_value($args);
				break;
			case 'set_primary_key_value':
				$this->invoke_set_primary_key_value($args);
				break;
			case 'set_dictionary_id':
				$this->invoke_set_dictionary_id($args);
				break;
			case 'get_dictionary_id':
				$this->invoke_get_dictionary_id($args);
				break;
			case 'tag_dictionary_id':
				$this->invoke_tag_dictionary_id($args);
				break;
			case 'getColumnDefinition':
				$this->invoke_getColumnDefinition($args);
				break;
			case 'getDictionaryIdPrototype':
				$this->invoke_getDictionaryIdPrototype($args);
				break;
			case 'prototypeMap':
				$this->invoke_prototypeMap($args);
				break;
			default:
				//throw new ReflectionException("Property '$methodName' not found in DictionaryId");

				
		}
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_createSelf(array $args)
	{
//return: Sigmalab\Database\Core\IDataObject
		$this->instance->createSelf();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_table_name(array $args)
	{
//return: string
		return $this->instance->table_name();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_table_description(array $args)
	{
//return: string
		return $this->instance->table_description();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_getPrimaryKeyTag(array $args)
	{
//return: Sigmalab\Database\Core\IDBColumnDefinition
		$this->instance->getPrimaryKeyTag();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_primary_key_value(array $args)
	{
//return: int
		return $this->instance->primary_key_value();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_set_primary_key_value(array $args)
	{
//type: Parameter #0 [ <required> int $value ]
//param: int

		/** @var int $arg0  simple type int*/      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_int();
		else throw new ReflectionException("Property '0' not found in DictionaryId");

//return: void
		$this->instance->set_primary_key_value($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_set_dictionary_id(array $args)
	{
//type: Parameter #0 [ <required> int or NULL $value ]
//param: int

		/** @var int $arg0  simple type int*/      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_int();
		else throw new ReflectionException("Property '0' not found in DictionaryId");

//return: bool
		return $this->instance->set_dictionary_id($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_get_dictionary_id(array $args)
	{
//return: int
		return $this->instance->get_dictionary_id();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_tag_dictionary_id(array $args)
	{
//type: Parameter #0 [ <optional> string or NULL $alias = NULL ]
//param: string

		/** @var string $arg0  simple type string*/      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new ReflectionException("Property '0' not found in DictionaryId");

//return: Sigmalab\Database\Core\IDBColumnDefinition
		$this->instance->tag_dictionary_id($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_getColumnDefinition(array $args)
	{
//return: array
		return $this->instance->getColumnDefinition();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_getDictionaryIdPrototype(array $args)
	{
//type: Parameter #0 [ <optional> string or NULL $alias = NULL ]
//param: string

		/** @var string $arg0  simple type string*/      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new ReflectionException("Property '0' not found in DictionaryId");

//return: Database\DictionaryId
		$this->instance->getDictionaryIdPrototype($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_prototypeMap(array $args)
	{
//return: array
		return $this->instance->prototypeMap();
	}
	/**
	 * @param string $name
	 * @param string $value
	 * @throws \Exception
	 */
	public function set_as_string(string  $name, string $value):void
	{
		switch ($name) {
			default: 
			//throw new ReflectionException("Property '$name' not found in \Database\DictionaryId");
		}
	}
	/**
	 * @param string $name
	 * @return string
	 * @throws \Exception
	 */
	public function get_as_string(string  $name):string
	{
		switch ($name) {
			default: 
			//throw new ReflectionException("Property '$name' not found in \Database\DictionaryId");
		}
		/** @noinspection PhpUnreachableStatementInspection */
		return "";
	}
	/**
	 * @param string $name
	 * @param int $value
	 * @throws \Exception
	 */
	public function set_as_int(string  $name, int $value):void
	{
		switch ($name) {
			case self::Field_dictionary_id: $this->instance->dictionary_id  = $value; break;
			default: 
			//throw new ReflectionException("Property '$name' not found in \Database\DictionaryId");
		}
	}
	/**
	 * @param string $name
	 * @return int
	 * @throws \Exception
	 */
	public function get_as_int(string  $name):int
	{
		switch ($name) {
			case self::Field_dictionary_id: return (int)$this->instance->dictionary_id;
			default: 
			//throw new ReflectionException("Property '$name' not found in \Database\DictionaryId");
		}
		/** @noinspection PhpUnreachableStatementInspection */
		return 0;
	}
	/**
	 * @param string $name
	 * @param float $value
	 * @throws \Exception
	 */
	public function set_as_float(string  $name, float $value):void
	{
		switch ($name) {
			default: 
			//throw new ReflectionException("Property '$name' not found in \Database\DictionaryId");
		}
	}
	/**
	 * @param string $name
	 * @return float
	 * @throws \Exception
	 */
	public function get_as_float(string  $name):float
	{
		switch ($name) {
			default: 
			//throw new ReflectionException("Property '$name' not found in \Database\DictionaryId");
		}
		/** @noinspection PhpUnreachableStatementInspection */
		return 0.0;
	}
	/**
	 * @param string $name
	 * @param bool $value
	 * @throws \Exception
	 */
	public function set_as_bool(string  $name, bool $value):void
	{
		switch ($name) {
			default: 
			//throw new ReflectionException("Property '$name' not found in \Database\DictionaryId");
		}
	}
	/**
	 * @param string $name
	 * @return bool
	 * @throws \Exception
	 */
	public function get_as_bool(string  $name):bool
	{
		switch ($name) {
			default: 
			//throw new ReflectionException("Property '$name' not found in \Database\DictionaryId");
		}
		/** @noinspection PhpUnreachableStatementInspection */
		return false;
	}
	/**
	 * @param string $name
	 * @throws \Exception
	 */
	public function set_as_null(string  $name):void
	{
		switch ($name) {
			case self::Field_dictionary_id: $this->instance->dictionary_id  = null; break;
			default: 
			//throw new ReflectionException("Property '$name' not found in \Database\DictionaryId");
		}
	}
	/**
	 * @param string $name
	 * @param mixed $value
	 * @throws \Exception
	 */
	public function set_as_mixed(string $name, $value):void
	{
		switch ($name) {
			case self::Field_dictionary_id: 
				if ( is_null($value) ) $this->instance->dictionary_id = null;
				else $this->instance->dictionary_id  = (int)$value; 
				break;
			default: 
			//throw new ReflectionException("Property '$name' not found in \Database\DictionaryId");
		}
	}
	/**
	 * @param string $name
	 * @return mixed
	 * @throws \Exception
	 */
	public function get_as_mixed(string $name)
	{
		switch ($name) {
			case self::Field_dictionary_id: return $this->instance->dictionary_id; break;
			default: 
			//throw new ReflectionException("Property '$name' not found in \Database\DictionaryId");
		}
		/** @noinspection PhpUnreachableStatementInspection */
		return 0;
	}
	/**
	 * @param string $name
	 * @param \Sigmalab\SimpleReflection\IReflectedObject $value
	 * @throws \Exception
	 */
	public function set_as_object(string $name, \Sigmalab\SimpleReflection\IReflectedObject $value):void
	{
		switch ($name) {
			default: 
			//throw new ReflectionException("Property '$name' not found in \Database\DictionaryId");
		}
	}

	/**
	 * @param string $name
	 * @return \Sigmalab\SimpleReflection\IReflectedObject|null 
	 * @throws \Exception
	 */
	public function get_as_object(string $name):?\Sigmalab\SimpleReflection\IReflectedObject 
	{
		switch ($name) {
			default: 
			//throw new ReflectionException("Property '$name' not found in \Database\DictionaryId");
		}
		/** @noinspection PhpUnreachableStatementInspection */
		return null;
	}

	/**
	 * @param string $name
	 * @param \Sigmalab\SimpleReflection\IReflectedObject[] $value
	 * @throws \Exception
	 */
	public function set_as_objects(string $name, array $value):void
	{
		switch ($name) {
			default: 
			//throw new ReflectionException("Property '$name' not found in \Database\DictionaryId");
		}
	}

	/**
	 * @param string $name
	 * @return \Sigmalab\SimpleReflection\IReflectedObject[] 
	 * @throws \Exception
	 */
	public function get_as_objects(string $name):array
	{
		switch ($name) {
			default: 
			//throw new ReflectionException("Property '$name' not found in \Database\DictionaryId");
		}
		/** @noinspection PhpUnreachableStatementInspection */
		return [];
	}
}
