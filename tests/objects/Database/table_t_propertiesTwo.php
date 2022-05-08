<?php
namespace Database;

/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_propertiesTwo
 */
class table_t_propertiesTwo extends table_t_base
{
	

	/** 
	 * @access private
	 * @var int|null
	 */
	public ?int $propertiesTwo_id;

	/** @kphp-reserved-fields 4
	 */
      

	/** 
	 * @access private
	 * @var int
	 */
	public int $propertiesTwoData;

	/** construct object
	 * @param string|null $alias
	*/
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->propertiesTwo_id =  0 ;
	  	$this->base_id =  0 ;
	  	$this->propertiesTwoData =  0 ;
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return table_t_propertiesTwo
	 */
	public function gettable_t_propertiesTwoPrototype(?string $alias=null) : table_t_propertiesTwo
	{
		return new table_t_propertiesTwo($alias);
	}

  
	/** returns primary key tag */
	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition
	{
		return $this->tag_propertiesTwo_id() ;
	}

	/** get primary key value
	 * @return int primary key value with type as defined in database (value of \a propertiesTwo_id )
	 * @noinspection PhpMissingParentCallCommonInspection
	 */
	public function primary_key_value():int
	{
		return( (int)$this->propertiesTwo_id );
		
	}


  /** @inheritDoc */
	public function set_primary_key_value(int $value):void
	{
		$this->propertiesTwo_id = $value;
	}

  
	public function createSelf():\Sigmalab\Database\Core\IDataObject
	{
		if ( get_class($this) !== __CLASS__) {
			\Sigmalab\Database\Core\DataSourceLogger::getInstance()->warning(get_class($this)."::createSelf() not implemented fallback to parent");
			return parent::createSelf();
		}
		return new self();
	}

	/** always contains \a "t_propertiesTwo"
	 */
	public function table_name() :string
	{
		return( "t_propertiesTwo" );
	}

	/** always contains \a "t_propertiesTwo"
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
        		$columnDefinition[ table_t_propertiesTwoFields::propertiesTwo_id ] = $this->tag_propertiesTwo_id();
		$columnDefinition[ table_t_propertiesTwoFields::base_id ] = $this->tag_base_id();
		$columnDefinition[ table_t_propertiesTwoFields::propertiesTwoData ] = $this->tag_propertiesTwoData();

		return( $columnDefinition );
	}

	/** get column definitions for foreign keys
	 * @return \Sigmalab\Database\Core\DBForeignKey[]
	 */
	public function getForeignKeys() : array
	{
		$keyDefs = array();
		$keyDefs[ table_t_propertiesTwoFields::base_id ] = $this->key_base_id();
  
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
  
	/** set value to propertiesTwo_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_propertiesTwo_id(?int $value ) : bool
	{
		if ($this->propertiesTwo_id === $value) return false;
		$this->setChangedValue(table_t_propertiesTwoFields::propertiesTwo_id, $this->propertiesTwo_id);
		$this->propertiesTwo_id = $value;
		return( true );
	}

	/** get value from \a propertiesTwo_id  column
	 * @return int|null value
	 */
	public function get_propertiesTwo_id()  :?int
	{
		return( $this->propertiesTwo_id );
	}
  
	/** set value to base_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_base_id(?int $value ) : bool
	{
		if ($this->base_id === $value) return false;
		$this->setChangedValue(table_t_propertiesTwoFields::base_id, $this->base_id);
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
  
	/** set value to propertiesTwoData  column
	 * @param int $value  value
	 * @return bool true when value changed
	 */
	public function set_propertiesTwoData(int $value ) : bool
	{
		if ($this->propertiesTwoData === $value) return false;
		$this->setChangedValue(table_t_propertiesTwoFields::propertiesTwoData, $this->propertiesTwoData);
		$this->propertiesTwoData = $value;
		return( true );
	}

	/** get value from \a propertiesTwoData  column
	 * @return int value
	 */
	public function get_propertiesTwoData()  :int
	{
		return( $this->propertiesTwoData );
	}
  

	/** Import value (from sql )
	 * @param string $name
	 * @param mixed $value
	 */
  public function importValue(string $name, $value) :void {
    switch($name)
    {
      
        case table_t_propertiesTwoFields::propertiesTwo_id:
             
             $this->propertiesTwo_id = (int)$value;
             return;
      
        case table_t_propertiesTwoFields::base_id:
             
             $this->base_id = (int)$value;
             return;
      
        case table_t_propertiesTwoFields::propertiesTwoData:
             
             $this->propertiesTwoData = (int)$value;
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
      
        case table_t_propertiesTwoFieldKeys::propertiesTwo_id:
             
             $this->propertiesTwo_id = (int)$value;
             return true;
      
        case table_t_propertiesTwoFieldKeys::base_id:
             
             $this->base_id = (int)$value;
             return true;
      
        case table_t_propertiesTwoFieldKeys::propertiesTwoData:
             
             $this->propertiesTwoData = (int)$value;
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
      
        case table_t_propertiesTwoFields::propertiesTwo_id:
              $notNull_propertiesTwo_id = (int)$this->propertiesTwo_id;
             if ( $notNull_propertiesTwo_id === ((int)$value)) return true;
             $this->setChangedValue($name, $this->propertiesTwo_id);
             $this->propertiesTwo_id = (int)$value;
             return true;
      
        case table_t_propertiesTwoFields::base_id:
              $notNull_base_id = (int)$this->base_id;
             if ( $notNull_base_id === ((int)$value)) return true;
             $this->setChangedValue($name, $this->base_id);
             $this->base_id = (int)$value;
             return true;
      
        case table_t_propertiesTwoFields::propertiesTwoData:
              $notNull_propertiesTwoData = (int)$this->propertiesTwoData;
             if ( $notNull_propertiesTwoData === ((int)$value)) return true;
             $this->setChangedValue($name, $this->propertiesTwoData);
             $this->propertiesTwoData = (int)$value;
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
      
        case table_t_propertiesTwoFields::propertiesTwo_id:
             return $this->propertiesTwo_id;
      
        case table_t_propertiesTwoFields::base_id:
             return $this->base_id;
      
        case table_t_propertiesTwoFields::propertiesTwoData:
             return $this->propertiesTwoData;
      
    }
    return parent::getValue ($name);
  }

	//Tags
  
	/** get column definition for \a propertiesTwo_id column
	 * @param string|null $alias  alias for \a propertiesTwo_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_propertiesTwo_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_propertiesTwoFields::propertiesTwo_id, "int", $alias,$this, false, "", false,table_t_propertiesTwoFieldKeys::propertiesTwo_id);

		return( $def );
	}
  
	/** get column definition for \a base_id column
	 * @param string|null $alias  alias for \a base_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_base_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_propertiesTwoFields::base_id, "int", $alias,$this, false, "", false,table_t_propertiesTwoFieldKeys::base_id);

		return( $def );
	}
  
	/** get column definition for \a propertiesTwoData column
	 * @param string|null $alias  alias for \a propertiesTwoData column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_propertiesTwoData(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_propertiesTwoFields::propertiesTwoData, "int", $alias,$this, false, "", false,table_t_propertiesTwoFieldKeys::propertiesTwoData);

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
		return array_merge( array('table_t_propertiesTwo' => new table_t_propertiesTwo()), parent::prototypeMap() );
	}

	//Foreign keys
    

	/** Foreign key for tag_base_id() as link to Database\table_t_base::tag_base_id()
	 * @param \Database\table_t_base $proto foreign object prototype
	 * @return \Sigmalab\Database\Core\DBForeignKey
	 */
	public function key_base_id(?\Database\table_t_base $proto=null) :\Sigmalab\Database\Core\DBForeignKey
	{
		if ( is_null($proto) ) $proto = new \Database\table_t_base();
		$def = new \Sigmalab\Database\Core\DBForeignKey( $this->tag_base_id(), $proto->tag_base_id() );
		return( $def );
	}
      
	public function set_parent_key_value(int $value){
		$this->set_base_id($value);
	}

	public function get_parent_key_value():?int{
		return $this->get_base_id();
	}

	/** Get foreign key of parent class
	* @param \Sigmalab\Database\Core\IDataObject|null $proto foreign object prototype
	* @return \Sigmalab\Database\Core\DBForeignKey|null
	*/
	public function getParentKey(?\Sigmalab\Database\Core\IDataObject $proto=NULL): ?\Sigmalab\Database\Core\DBForeignKey
	{
		if ( !$proto ) {
			return $this->key_base_id(null);
		}
		else if ( $proto instanceof table_t_base ) {
			return $this->key_base_id($proto);
		}
		return null;
	}

        
	/** Create prototype of parent class.
	 * @return  \Sigmalab\Database\Core\IDataObject|null
	*/
	public function parentPrototype() : ?\Sigmalab\Database\Core\IDataObject
	{
		return $this->gettable_t_basePrototype();
	}
        

#ifndef KPHP
	// Loaders
        
#endif

    
}

  
