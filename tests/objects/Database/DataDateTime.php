<?php
namespace Database;

/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_datatime
 */
class DataDateTime extends \Sigmalab\Database\Core\DBObject
{
	

	/** 
	 * @access private
	 * @var int|null
	 */
	public ?int $datatime_id;

	/** 
	 * @access private
	 * @var int|null
	 */
	public ?int $value;

	/** construct object
	 * @param string|null $alias
	*/
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->datatime_id =  0 ;
	  	$this->value =  NULL ;
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return DataDateTime
	 */
	public function getDataDateTimePrototype(?string $alias=null) : DataDateTime
	{
		return new DataDateTime($alias);
	}

  
	/** returns primary key tag */
	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition
	{
		return $this->tag_datatime_id() ;
	}

	/** get primary key value
	 * @return int primary key value with type as defined in database (value of \a datatime_id )
	 * @noinspection PhpMissingParentCallCommonInspection
	 */
	public function primary_key_value():int
	{
		return( (int)$this->datatime_id );
		
	}


  /** @inheritDoc */
	public function set_primary_key_value(int $value):void
	{
		$this->datatime_id = $value;
	}

  
	public function createSelf():\Sigmalab\Database\Core\IDataObject
	{
		if ( get_class($this) !== __CLASS__) {
			\Sigmalab\Database\Core\DataSourceLogger::getInstance()->warning(get_class($this)."::createSelf() not implemented fallback to parent");
			return parent::createSelf();
		}
		return new self();
	}

	/** always contains \a "t_datatime"
	 */
	public function table_name() :string
	{
		return( "t_datatime" );
	}

	/** always contains \a "t_datatime"
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
        		$columnDefinition[ DataDateTimeFields::datatime_id ] = $this->tag_datatime_id();
		$columnDefinition[ DataDateTimeFields::value ] = $this->tag_value();

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
  
	/** set value to datatime_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_datatime_id(?int $value ) : bool
	{
		if ($this->datatime_id === $value) return false;
		$this->setChangedValue(DataDateTimeFields::datatime_id, $this->datatime_id);
		$this->datatime_id = $value;
		return( true );
	}

	/** get value from \a datatime_id  column
	 * @return int|null value
	 */
	public function get_datatime_id()  :?int
	{
		return( $this->datatime_id );
	}
  
	/** set value to value  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_value(?int $value ) : bool
	{
		if ($this->value === $value) return false;
		$this->setChangedValue(DataDateTimeFields::value, $this->value);
		$this->value = $value;
		return( true );
	}

	/** get value from \a value  column
	 * @return int|null value
	 */
	public function get_value() :?int
	{
		return( $this->value );
	}
  

	/** Import value (from sql )
	 * @param string $name
	 * @param mixed $value
	 */
  public function importValue(string $name, $value) :void {
    switch($name)
    {
      
        case DataDateTimeFields::datatime_id:
             
             $this->datatime_id = (int)$value;
             return;
      
        case DataDateTimeFields::value:
             if ( $value === null ) $this->value = null; else 
             $this->value = (int)$value;
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
      
        case DataDateTimeFieldKeys::datatime_id:
             
             $this->datatime_id = (int)$value;
             return true;
      
        case DataDateTimeFieldKeys::value:
             if ( $value === null ) $this->value = null; else 
             $this->value = (int)$value;
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
      
        case DataDateTimeFields::datatime_id:
              $notNull_datatime_id = (int)$this->datatime_id;
             if ( $notNull_datatime_id === ((int)$value)) return true;
             $this->setChangedValue($name, $this->datatime_id);
             $this->datatime_id = (int)$value;
             return true;
      
        case DataDateTimeFields::value:
              $notNull_value = (int)$this->value;
             if ( $notNull_value === ((int)$value)) return true;
             $this->setChangedValue($name, $this->value);
             $this->value = (int)$value;
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
      
        case DataDateTimeFields::datatime_id:
             return $this->datatime_id;
      
        case DataDateTimeFields::value:
             return $this->value;
      
    }
    return parent::getValue ($name);
  }

	//Tags
  
	/** get column definition for \a datatime_id column
	 * @param string|null $alias  alias for \a datatime_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_datatime_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( DataDateTimeFields::datatime_id, "int", $alias,$this, false, "", false,DataDateTimeFieldKeys::datatime_id);

		return( $def );
	}
  
	/** get column definition for \a value column
	 * @param string|null $alias  alias for \a value column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_value(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( DataDateTimeFields::value, "datetime", $alias,$this, false, "", true,DataDateTimeFieldKeys::value);

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
		return array_merge( array('DataDateTime' => new DataDateTime()), parent::prototypeMap() );
	}

	//Foreign keys
    

#ifndef KPHP
	// Loaders
        
#endif

    
}

  

    

