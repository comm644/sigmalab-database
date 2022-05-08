<?php
namespace Database;

/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_dataNotNullable
 */
class DataNotNullable extends \Sigmalab\Database\Core\DBObject
{
	

	/** 
	 * @access private
	 * @var int|null
	 */
	public ?int $dataNotNullableId;

	/** 
	 * @access private
	 * @var string
	 */
	public string $valueA;

	/** 
	 * @access private
	 * @var string
	 */
	public string $valueB;

	/** construct object
	 * @param string|null $alias
	*/
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->dataNotNullableId =  0 ;
	  	$this->valueA =  '' ;
	  	$this->valueB =  '' ;
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return DataNotNullable
	 */
	public function getDataNotNullablePrototype(?string $alias=null) : DataNotNullable
	{
		return new DataNotNullable($alias);
	}

  
	/** returns primary key tag */
	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition
	{
		return $this->tag_dataNotNullableId() ;
	}

	/** get primary key value
	 * @return int primary key value with type as defined in database (value of \a dataNotNullableId )
	 * @noinspection PhpMissingParentCallCommonInspection
	 */
	public function primary_key_value():int
	{
		return( (int)$this->dataNotNullableId );
		
	}


  /** @inheritDoc */
	public function set_primary_key_value(int $value):void
	{
		$this->dataNotNullableId = $value;
	}

  
	public function createSelf():\Sigmalab\Database\Core\IDataObject
	{
		if ( get_class($this) !== __CLASS__) {
			\Sigmalab\Database\Core\DataSourceLogger::getInstance()->warning(get_class($this)."::createSelf() not implemented fallback to parent");
			return parent::createSelf();
		}
		return new self();
	}

	/** always contains \a "t_dataNotNullable"
	 */
	public function table_name() :string
	{
		return( "t_dataNotNullable" );
	}

	/** always contains \a "t_dataNotNullable"
	*/
	public function table_description():string
	{
		return( "" );
	}
  
	/** @inheritDoc */
  /** return Column Definition array
  * @return \Sigmalab\Database\Core\IDBColumnDefinition[] items - object relation scheme
  */
	public function getColumnDefinition(): array
	{
		$columnDefinition = array();
        		$columnDefinition[ DataNotNullableFields::dataNotNullableId ] = $this->tag_dataNotNullableId();
		$columnDefinition[ DataNotNullableFields::valueA ] = $this->tag_valueA();
		$columnDefinition[ DataNotNullableFields::valueB ] = $this->tag_valueB();

		return( $columnDefinition );
	}

	/** get column definitions for foreign keys
	 * @return \Sigmalab\Database\Core\DBForeignKey[]
	 */
	public function getForeignKeys() : array
	{
		$keyDefs = array();
		
		return( $keyDefs );
	}

	/** Indicates whether object newly created (return true when created)
	* @return bool
	*/
	public function isNew() : bool
	{
		$val = $this->primary_key_value() ;
		return( ($val === 0) || ($val === -1) );
	}

	// Set/Get methods
  
	/** set value to dataNotNullableId  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_dataNotNullableId(?int $value ) : bool
	{
		if ($this->dataNotNullableId === $value) return false;
		$this->setChangedValue(DataNotNullableFields::dataNotNullableId, $this->dataNotNullableId);
		$this->dataNotNullableId = $value;
		return( true );
	}

	/** get value from \a dataNotNullableId  column
	 * @return int|null value
	 */
	public function get_dataNotNullableId()  :?int
	{
		return( $this->dataNotNullableId );
	}
  
	/** set value to valueA  column
	 * @param string $value  value
	 * @return bool true when value changed
	 */
	public function set_valueA(string $value ) : bool
	{
		if ($this->valueA === $value) return false;
		$this->setChangedValue(DataNotNullableFields::valueA, $this->valueA);
		$this->valueA = $value;
		return( true );
	}

	/** get value from \a valueA  column
	 * @return string value
	 */
	public function get_valueA()  :string
	{
		return( $this->valueA );
	}
  
	/** set value to valueB  column
	 * @param string $value  value
	 * @return bool true when value changed
	 */
	public function set_valueB(string $value ) : bool
	{
		if ($this->valueB === $value) return false;
		$this->setChangedValue(DataNotNullableFields::valueB, $this->valueB);
		$this->valueB = $value;
		return( true );
	}

	/** get value from \a valueB  column
	 * @return string value
	 */
	public function get_valueB()  :string
	{
		return( $this->valueB );
	}
  

	/** Import value (from sql )
	 * @param string $name
	 * @param mixed $value
	 */
  public function importValue(string $name, $value) :void {
    switch($name)
    {
      
        case DataNotNullableFields::dataNotNullableId:
             
             $this->dataNotNullableId = (int)$value;
             return;
      
        case DataNotNullableFields::valueA:
             
             $this->valueA = (string)$value;
             return;
      
        case DataNotNullableFields::valueB:
             
             $this->valueB = (string)$value;
             return;
      
    }
    parent::importValue($name, $value );
  }

	/** Import value (from sql )
	 * @param mixed $value
	 */
  public function importValueByKey(int $key, $value) :bool {
    switch($key)
    {
      
        case DataNotNullableFieldKeys::dataNotNullableId:
             
             $this->dataNotNullableId = (int)$value;
             return true;
      
        case DataNotNullableFieldKeys::valueA:
             
             $this->valueA = (string)$value;
             return true;
      
        case DataNotNullableFieldKeys::valueB:
             
             $this->valueB = (string)$value;
             return true;
      
    }
    return parent::importValueByKey($key, $value );
  }

	/** Set value by name (required for import )
	 * @param string $name
	 * @param mixed $value
	 * @return bool
	 */
  public function setValue(string $name, $value) :bool {
    switch($name)
    {
      
        case DataNotNullableFields::dataNotNullableId:
              $notNull_dataNotNullableId = (int)$this->dataNotNullableId;
             if ( $notNull_dataNotNullableId === ((int)$value)) return true;
             $this->setChangedValue($name, $this->dataNotNullableId);
             $this->dataNotNullableId = (int)$value;
             return true;
      
        case DataNotNullableFields::valueA:
              $notNull_valueA = (string)$this->valueA;
             if ( $notNull_valueA === ((string)$value)) return true;
             $this->setChangedValue($name, $this->valueA);
             $this->valueA = (string)$value;
             return true;
      
        case DataNotNullableFields::valueB:
              $notNull_valueB = (string)$this->valueB;
             if ( $notNull_valueB === ((string)$value)) return true;
             $this->setChangedValue($name, $this->valueB);
             $this->valueB = (string)$value;
             return true;
      
    }

    return parent::setValue($name, $value);
  }
	/** Set value by name (required for import )
	 * @param string $name
	 * @return mixed
	 */
  public function getValue(string $name) {
    switch($name)
    {
      
        case DataNotNullableFields::dataNotNullableId:
             return $this->dataNotNullableId;
      
        case DataNotNullableFields::valueA:
             return $this->valueA;
      
        case DataNotNullableFields::valueB:
             return $this->valueB;
      
    }
    return parent::getValue ($name);
  }

	//Tags
  
	/** get column definition for \a dataNotNullableId column
	 * @param string|null $alias  alias for \a dataNotNullableId column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_dataNotNullableId(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( DataNotNullableFields::dataNotNullableId, "int", $alias,$this, false, "", false,DataNotNullableFieldKeys::dataNotNullableId);

		return( $def );
	}
  
	/** get column definition for \a valueA column
	 * @param string|null $alias  alias for \a valueA column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_valueA(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( DataNotNullableFields::valueA, "string", $alias,$this, false, "", false,DataNotNullableFieldKeys::valueA);

		return( $def );
	}
  
	/** get column definition for \a valueB column
	 * @param string|null $alias  alias for \a valueB column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_valueB(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( DataNotNullableFields::valueB, "string", $alias,$this, false, "", false,DataNotNullableFieldKeys::valueB);

		return( $def );
	}
  

	/** Gets prototype map for an object.
	*
	* array: table name => \Sigmalab\Database\Core\DBObject
	*
	* @return \Sigmalab\Database\Core\DBObject[]
	*/
	public function prototypeMap() : array
	{
		return array_merge( array('DataNotNullable' => new DataNotNullable()), parent::prototypeMap() );
	}

	//Foreign keys
    

#ifndef KPHP
	// Loaders
        
#endif

    
}

  
