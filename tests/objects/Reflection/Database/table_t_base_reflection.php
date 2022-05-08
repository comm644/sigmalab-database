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
class table_t_base_reflection implements \Sigmalab\SimpleReflection\ICanReflection
{
	/** table_t_base */
	private table_t_base $instance;

	public const Field_base_id = "base_id";
	public const Field_baseData = "baseData";

	
	public function __construct(table_t_base $instance) 
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
			case self::Field_base_id: return true;
			case self::Field_baseData: return true;
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
		return [self::Field_base_id,
		self::Field_baseData];
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
			case self::Field_base_id: return \Sigmalab\SimpleReflection\TypeName::$intValue;
			case self::Field_baseData: return \Sigmalab\SimpleReflection\TypeName::$intValue;
			default:
				//throw new ReflectionException("Property '{$name}' not found in table_t_base"); 
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
		case self::Field_base_id:
			if ($value instanceof \Sigmalab\SimpleReflection\ValueScalar) {
				$this->instance->base_id = $value->get_as_int();
			}

			break;
/* int: int type:int isArray:  */
		case self::Field_baseData:
			if ($value instanceof \Sigmalab\SimpleReflection\ValueScalar) {
				$this->instance->baseData = $value->get_as_int();
			}

			break;
			default:
				//throw new ReflectionException("Property '{$name}' not found in table_t_base"); 
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
			case self::Field_base_id: return new \Sigmalab\SimpleReflection\ValueScalar( $this->instance->base_id );
			case self::Field_baseData: return new \Sigmalab\SimpleReflection\ValueScalar( $this->instance->baseData );
			default:
				//throw new ReflectionException("Property '$name' not found in table_t_base");

				
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
		\Sigmalab\SimpleReflection\ClassRegistry::registerClass(table_t_base::class, function(){
			return instance_cast(new table_t_base, IReflectedObject::class ); 
		});
		\Sigmalab\SimpleReflection\ClassRegistry::registerReflection(self::class, function(object $instance){
			/** @noinspection PhpParamsInspection */ 
			return new table_t_base_reflection(instance_cast($instance, table_t_base::class)); 
		});
		
	}
	

	/**
	* @inheritDoc
	*/
	public function invoke_as_mixed(string $methodName, array $args) 
	{
		switch ($methodName)
		{
 //type: int 
			case 'primary_key_value':
				return $this->invoke_primary_key_value($args);
				break;
 //type: string 
			case 'table_name':
				return $this->invoke_table_name($args);
				break;
 //type: string 
			case 'table_description':
				return $this->invoke_table_description($args);
				break;
 //type: bool 
			case 'isNew':
				return $this->invoke_isNew($args);
				break;
 //type: bool 
			case 'set_base_id':
				return $this->invoke_set_base_id($args);
				break;
 //type: int 
			case 'get_base_id':
				return $this->invoke_get_base_id($args);
				break;
 //type: bool 
			case 'set_baseData':
				return $this->invoke_set_baseData($args);
				break;
 //type: int 
			case 'get_baseData':
				return $this->invoke_get_baseData($args);
				break;
 //type: bool 
			case 'importValueByKey':
				return $this->invoke_importValueByKey($args);
				break;
 //type: bool 
			case 'setValue':
				return $this->invoke_setValue($args);
				break;
			default:
				//throw new ReflectionException("Property '$methodName' not found in table_t_base");

				
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
			case 'gettable_t_basePrototype':
				$this->invoke_gettable_t_basePrototype($args);
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
			case 'createSelf':
				$this->invoke_createSelf($args);
				break;
			case 'table_name':
				$this->invoke_table_name($args);
				break;
			case 'table_description':
				$this->invoke_table_description($args);
				break;
			case 'getColumnDefinition':
				$this->invoke_getColumnDefinition($args);
				break;
			case 'getForeignKeys':
				$this->invoke_getForeignKeys($args);
				break;
			case 'isNew':
				$this->invoke_isNew($args);
				break;
			case 'set_base_id':
				$this->invoke_set_base_id($args);
				break;
			case 'get_base_id':
				$this->invoke_get_base_id($args);
				break;
			case 'set_baseData':
				$this->invoke_set_baseData($args);
				break;
			case 'get_baseData':
				$this->invoke_get_baseData($args);
				break;
			case 'importValue':
				$this->invoke_importValue($args);
				break;
			case 'importValueByKey':
				$this->invoke_importValueByKey($args);
				break;
			case 'setValue':
				$this->invoke_setValue($args);
				break;
			case 'getValue':
				$this->invoke_getValue($args);
				break;
			case 'tag_base_id':
				$this->invoke_tag_base_id($args);
				break;
			case 'tag_baseData':
				$this->invoke_tag_baseData($args);
				break;
			case 'prototypeMap':
				$this->invoke_prototypeMap($args);
				break;
			default:
				//throw new ReflectionException("Property '$methodName' not found in table_t_base");

				
		}
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_gettable_t_basePrototype(array $args)
	{
//type: Parameter #0 [ <optional> string or NULL $alias = NULL ]
//param: string

		/** @var string $arg0  simple type string*/      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new ReflectionException("Property '0' not found in table_t_base");

//return: Database\table_t_base
		$this->instance->gettable_t_basePrototype($arg0);
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
		else throw new ReflectionException("Property '0' not found in table_t_base");

//return: void
		$this->instance->set_primary_key_value($arg0);
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
	private function invoke_getForeignKeys(array $args)
	{
//return: array
		return $this->instance->getForeignKeys();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_isNew(array $args)
	{
//return: bool
		return $this->instance->isNew();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_set_base_id(array $args)
	{
//type: Parameter #0 [ <required> int or NULL $value ]
//param: int

		/** @var int $arg0  simple type int*/      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_int();
		else throw new ReflectionException("Property '0' not found in table_t_base");

//return: bool
		return $this->instance->set_base_id($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_get_base_id(array $args)
	{
//return: int
		return $this->instance->get_base_id();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_set_baseData(array $args)
	{
//type: Parameter #0 [ <required> int $value ]
//param: int

		/** @var int $arg0  simple type int*/      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_int();
		else throw new ReflectionException("Property '0' not found in table_t_base");

//return: bool
		return $this->instance->set_baseData($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_get_baseData(array $args)
	{
//return: int
		return $this->instance->get_baseData();
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_importValue(array $args)
	{
//type: Parameter #0 [ <required> string $name ]
//param: string

		/** @var string $arg0  simple type string*/      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new ReflectionException("Property '0' not found in table_t_base");

//type: Parameter #1 [ <required> $value ]
//param: mixed

		/** @var mixed $arg1  - mixed */      
		$value1 = $args[1];
		if ( $value1 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg1 = $value1->get_as_mixed();
		else throw new ReflectionException("Property '1' not found in table_t_base");

//return: void
		$this->instance->importValue($arg0,$arg1);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_importValueByKey(array $args)
	{
//type: Parameter #0 [ <required> int $key ]
//param: int

		/** @var int $arg0  simple type int*/      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_int();
		else throw new ReflectionException("Property '0' not found in table_t_base");

//type: Parameter #1 [ <required> $value ]
//param: mixed

		/** @var mixed $arg1  - mixed */      
		$value1 = $args[1];
		if ( $value1 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg1 = $value1->get_as_mixed();
		else throw new ReflectionException("Property '1' not found in table_t_base");

//return: bool
		return $this->instance->importValueByKey($arg0,$arg1);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_setValue(array $args)
	{
//type: Parameter #0 [ <required> string $name ]
//param: string

		/** @var string $arg0  simple type string*/      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new ReflectionException("Property '0' not found in table_t_base");

//type: Parameter #1 [ <required> $value ]
//param: mixed

		/** @var mixed $arg1  - mixed */      
		$value1 = $args[1];
		if ( $value1 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg1 = $value1->get_as_mixed();
		else throw new ReflectionException("Property '1' not found in table_t_base");

//return: bool
		return $this->instance->setValue($arg0,$arg1);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_getValue(array $args)
	{
//type: Parameter #0 [ <required> string $name ]
//param: string

		/** @var string $arg0  simple type string*/      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new ReflectionException("Property '0' not found in table_t_base");

//return: 
		$this->instance->getValue($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_tag_base_id(array $args)
	{
//type: Parameter #0 [ <optional> string or NULL $alias = NULL ]
//param: string

		/** @var string $arg0  simple type string*/      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new ReflectionException("Property '0' not found in table_t_base");

//return: Sigmalab\Database\Core\IDBColumnDefinition
		$this->instance->tag_base_id($arg0);
	}

	/**
	 * @param \Sigmalab\SimpleReflection\ValueMixed[] $args
	 * @throws \Exception
	 * 
	 */
	private function invoke_tag_baseData(array $args)
	{
//type: Parameter #0 [ <optional> string or NULL $alias = NULL ]
//param: string

		/** @var string $arg0  simple type string*/      
		$value0 = $args[0];
		if ( $value0 instanceof \Sigmalab\SimpleReflection\ValueScalar) $arg0 = $value0->get_as_string();
		else throw new ReflectionException("Property '0' not found in table_t_base");

//return: Sigmalab\Database\Core\IDBColumnDefinition
		$this->instance->tag_baseData($arg0);
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
			//throw new ReflectionException("Property '$name' not found in \Database\table_t_base");
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
			//throw new ReflectionException("Property '$name' not found in \Database\table_t_base");
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
			case self::Field_base_id: $this->instance->base_id  = $value; break;
			case self::Field_baseData: $this->instance->baseData  = $value; break;
			default: 
			//throw new ReflectionException("Property '$name' not found in \Database\table_t_base");
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
			case self::Field_base_id: return (int)$this->instance->base_id;
			case self::Field_baseData: return (int)$this->instance->baseData;
			default: 
			//throw new ReflectionException("Property '$name' not found in \Database\table_t_base");
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
			//throw new ReflectionException("Property '$name' not found in \Database\table_t_base");
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
			//throw new ReflectionException("Property '$name' not found in \Database\table_t_base");
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
			//throw new ReflectionException("Property '$name' not found in \Database\table_t_base");
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
			//throw new ReflectionException("Property '$name' not found in \Database\table_t_base");
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
			case self::Field_base_id: $this->instance->base_id  = null; break;
			default: 
			//throw new ReflectionException("Property '$name' not found in \Database\table_t_base");
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
			case self::Field_base_id: 
				if ( is_null($value) ) $this->instance->base_id = null;
				else $this->instance->base_id  = (int)$value; 
				break;
			case self::Field_baseData: $this->instance->baseData  = (int)$value; break;
			default: 
			//throw new ReflectionException("Property '$name' not found in \Database\table_t_base");
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
			case self::Field_base_id: return $this->instance->base_id; break;
			case self::Field_baseData: return $this->instance->baseData; break;
			default: 
			//throw new ReflectionException("Property '$name' not found in \Database\table_t_base");
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
			//throw new ReflectionException("Property '$name' not found in \Database\table_t_base");
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
			//throw new ReflectionException("Property '$name' not found in \Database\table_t_base");
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
			//throw new ReflectionException("Property '$name' not found in \Database\table_t_base");
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
			//throw new ReflectionException("Property '$name' not found in \Database\table_t_base");
		}
		/** @noinspection PhpUnreachableStatementInspection */
		return [];
	}
}
