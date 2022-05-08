<?php
namespace Database;

/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_base
 */
class table_t_base extends \Sigmalab\Database\Core\DBObject
{
	

	/** 
	 * @access private
	 * @var int|null
	 */
	public ?int $base_id;

	/** 
	 * @access private
	 * @var int
	 */
	public int $baseData;

	/** construct object
	 * @param string|null $alias
	*/
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->base_id =  0 ;
	  	$this->baseData =  0 ;
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return table_t_base
	 */
	public function gettable_t_basePrototype(?string $alias=null) : table_t_base
	{
		return new table_t_base($alias);
	}

  
	/** returns primary key tag */
	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition
	{
		return $this->tag_base_id() ;
	}

	/** get primary key value
	 * @return int primary key value with type as defined in database (value of \a base_id )
	 * @noinspection PhpMissingParentCallCommonInspection
	 */
	public function primary_key_value():int
	{
		return( (int)$this->base_id );
		
	}


  /** @inheritDoc */
	public function set_primary_key_value(int $value):void
	{
		$this->base_id = $value;
	}

  
	public function createSelf():\Sigmalab\Database\Core\IDataObject
	{
		if ( get_class($this) !== __CLASS__) {
			\Sigmalab\Database\Core\DataSourceLogger::getInstance()->warning(get_class($this)."::createSelf() not implemented fallback to parent");
			return parent::createSelf();
		}
		return new self();
	}

	/** always contains \a "t_base"
	 */
	public function table_name() :string
	{
		return( "t_base" );
	}

	/** always contains \a "t_base"
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
        		$columnDefinition[ table_t_baseFields::base_id ] = $this->tag_base_id();
		$columnDefinition[ table_t_baseFields::baseData ] = $this->tag_baseData();

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
  
	/** set value to base_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_base_id(?int $value ) : bool
	{
		if ($this->base_id === $value) return false;
		$this->setChangedValue(table_t_baseFields::base_id, $this->base_id);
		$this->base_id = $value;
		return( true );
	}

	/** get value from \a base_id  column
	 * @return int|null value
	 */
	public function get_base_id()  :?int
	{
		return( $this->base_id );
	}
  
	/** set value to baseData  column
	 * @param int $value  value
	 * @return bool true when value changed
	 */
	public function set_baseData(int $value ) : bool
	{
		if ($this->baseData === $value) return false;
		$this->setChangedValue(table_t_baseFields::baseData, $this->baseData);
		$this->baseData = $value;
		return( true );
	}

	/** get value from \a baseData  column
	 * @return int value
	 */
	public function get_baseData()  :int
	{
		return( $this->baseData );
	}
  

	/** Import value (from sql )
	 * @param string $name
	 * @param mixed $value
	 */
  public function importValue(string $name, $value) :void {
    switch($name)
    {
      
        case table_t_baseFields::base_id:
             
             $this->base_id = (int)$value;
             return;
      
        case table_t_baseFields::baseData:
             
             $this->baseData = (int)$value;
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
      
        case table_t_baseFieldKeys::base_id:
             
             $this->base_id = (int)$value;
             return true;
      
        case table_t_baseFieldKeys::baseData:
             
             $this->baseData = (int)$value;
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
      
        case table_t_baseFields::base_id:
              $notNull_base_id = (int)$this->base_id;
             if ( $notNull_base_id === ((int)$value)) return true;
             $this->setChangedValue($name, $this->base_id);
             $this->base_id = (int)$value;
             return true;
      
        case table_t_baseFields::baseData:
              $notNull_baseData = (int)$this->baseData;
             if ( $notNull_baseData === ((int)$value)) return true;
             $this->setChangedValue($name, $this->baseData);
             $this->baseData = (int)$value;
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
      
        case table_t_baseFields::base_id:
             return $this->base_id;
      
        case table_t_baseFields::baseData:
             return $this->baseData;
      
    }
    return parent::getValue ($name);
  }

	//Tags
  
	/** get column definition for \a base_id column
	 * @param string|null $alias  alias for \a base_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_base_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_baseFields::base_id, "int", $alias,$this, false, "", false,table_t_baseFieldKeys::base_id);

		return( $def );
	}
  
	/** get column definition for \a baseData column
	 * @param string|null $alias  alias for \a baseData column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_baseData(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_baseFields::baseData, "int", $alias,$this, false, "", false,table_t_baseFieldKeys::baseData);

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
		return array_merge( array('table_t_base' => new table_t_base()), parent::prototypeMap() );
	}

	//Foreign keys
    

#ifndef KPHP
	// Loaders
        
#endif

    
}

  
