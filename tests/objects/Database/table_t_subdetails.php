<?php
namespace Database;

/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_subdetails
 */
class table_t_subdetails extends table_t_details
{
	

	/** 
	 * @access private
	 * @var int|null
	 */
	public ?int $subdetails_id;

	/** @kphp-reserved-fields 7
	 */
      

	/** 
	 * @access private
	 * @var int
	 */
	public int $subDetailsData;

	/** construct object
	 * @param string|null $alias
	*/
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->subdetails_id =  0 ;
	  	$this->details_id =  0 ;
	  	$this->subDetailsData =  0 ;
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return table_t_subdetails
	 */
	public function gettable_t_subdetailsPrototype(?string $alias=null) : table_t_subdetails
	{
		return new table_t_subdetails($alias);
	}

  
	/** returns primary key tag */
	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition
	{
		return $this->tag_subdetails_id() ;
	}

	/** get primary key value
	 * @return int primary key value with type as defined in database (value of \a subdetails_id )
	 * @noinspection PhpMissingParentCallCommonInspection
	 */
	public function primary_key_value():int
	{
		return( (int)$this->subdetails_id );
		
	}


  /** @inheritDoc */
	public function set_primary_key_value(int $value):void
	{
		$this->subdetails_id = $value;
	}

  
	public function createSelf():\Sigmalab\Database\Core\IDataObject
	{
		if ( get_class($this) !== __CLASS__) {
			\Sigmalab\Database\Core\DataSourceLogger::getInstance()->warning(get_class($this)."::createSelf() not implemented fallback to parent");
			return parent::createSelf();
		}
		return new self();
	}

	/** always contains \a "t_subdetails"
	 */
	public function table_name() :string
	{
		return( "t_subdetails" );
	}

	/** always contains \a "t_subdetails"
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
        		$columnDefinition[ table_t_subdetailsFields::subdetails_id ] = $this->tag_subdetails_id();
		$columnDefinition[ table_t_subdetailsFields::details_id ] = $this->tag_details_id();
		$columnDefinition[ table_t_subdetailsFields::subDetailsData ] = $this->tag_subDetailsData();

		return( $columnDefinition );
	}

	/** get column definitions for foreign keys
	 * @return \Sigmalab\Database\Core\DBForeignKey[]
	 */
	public function getForeignKeys() : array
	{
		$keyDefs = array();
		$keyDefs[ table_t_subdetailsFields::details_id ] = $this->key_details_id();
  
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
  
	/** set value to subdetails_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_subdetails_id(?int $value ) : bool
	{
		if ($this->subdetails_id === $value) return false;
		$this->setChangedValue(table_t_subdetailsFields::subdetails_id, $this->subdetails_id);
		$this->subdetails_id = $value;
		return( true );
	}

	/** get value from \a subdetails_id  column
	 * @return int|null value
	 */
	public function get_subdetails_id()  :?int
	{
		return( $this->subdetails_id );
	}
  
	/** set value to details_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_details_id(?int $value ) : bool
	{
		if ($this->details_id === $value) return false;
		$this->setChangedValue(table_t_subdetailsFields::details_id, $this->details_id);
		$this->details_id = $value;
		return( true );
	}

	/** get value from \a details_id  column
	 * @return int|null value
	 */
	public function get_details_id()  :?int
	{
		return( $this->details_id );
	}
  
	/** set value to subDetailsData  column
	 * @param int $value  value
	 * @return bool true when value changed
	 */
	public function set_subDetailsData(int $value ) : bool
	{
		if ($this->subDetailsData === $value) return false;
		$this->setChangedValue(table_t_subdetailsFields::subDetailsData, $this->subDetailsData);
		$this->subDetailsData = $value;
		return( true );
	}

	/** get value from \a subDetailsData  column
	 * @return int value
	 */
	public function get_subDetailsData()  :int
	{
		return( $this->subDetailsData );
	}
  

	/** Import value (from sql )
	 * @param string $name
	 * @param mixed $value
	 */
  public function importValue(string $name, $value) :void {
    switch($name)
    {
      
        case table_t_subdetailsFields::subdetails_id:
             
             $this->subdetails_id = (int)$value;
             return;
      
        case table_t_subdetailsFields::details_id:
             
             $this->details_id = (int)$value;
             return;
      
        case table_t_subdetailsFields::subDetailsData:
             
             $this->subDetailsData = (int)$value;
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
      
        case table_t_subdetailsFieldKeys::subdetails_id:
             
             $this->subdetails_id = (int)$value;
             return true;
      
        case table_t_subdetailsFieldKeys::details_id:
             
             $this->details_id = (int)$value;
             return true;
      
        case table_t_subdetailsFieldKeys::subDetailsData:
             
             $this->subDetailsData = (int)$value;
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
      
        case table_t_subdetailsFields::subdetails_id:
              $notNull_subdetails_id = (int)$this->subdetails_id;
             if ( $notNull_subdetails_id === ((int)$value)) return true;
             $this->setChangedValue($name, $this->subdetails_id);
             $this->subdetails_id = (int)$value;
             return true;
      
        case table_t_subdetailsFields::details_id:
              $notNull_details_id = (int)$this->details_id;
             if ( $notNull_details_id === ((int)$value)) return true;
             $this->setChangedValue($name, $this->details_id);
             $this->details_id = (int)$value;
             return true;
      
        case table_t_subdetailsFields::subDetailsData:
              $notNull_subDetailsData = (int)$this->subDetailsData;
             if ( $notNull_subDetailsData === ((int)$value)) return true;
             $this->setChangedValue($name, $this->subDetailsData);
             $this->subDetailsData = (int)$value;
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
      
        case table_t_subdetailsFields::subdetails_id:
             return $this->subdetails_id;
      
        case table_t_subdetailsFields::details_id:
             return $this->details_id;
      
        case table_t_subdetailsFields::subDetailsData:
             return $this->subDetailsData;
      
    }
    return parent::getValue ($name);
  }

	//Tags
  
	/** get column definition for \a subdetails_id column
	 * @param string|null $alias  alias for \a subdetails_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_subdetails_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_subdetailsFields::subdetails_id, "int", $alias,$this, false, "", false,table_t_subdetailsFieldKeys::subdetails_id);

		return( $def );
	}
  
	/** get column definition for \a details_id column
	 * @param string|null $alias  alias for \a details_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_details_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_subdetailsFields::details_id, "int", $alias,$this, false, "", false,table_t_subdetailsFieldKeys::details_id);

		return( $def );
	}
  
	/** get column definition for \a subDetailsData column
	 * @param string|null $alias  alias for \a subDetailsData column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_subDetailsData(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_subdetailsFields::subDetailsData, "int", $alias,$this, false, "", false,table_t_subdetailsFieldKeys::subDetailsData);

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
		return array_merge( array('table_t_subdetails' => new table_t_subdetails()), parent::prototypeMap() );
	}

	//Foreign keys
    

	/** Foreign key for tag_details_id() as link to Database\table_t_details::tag_details_id()
	 * @param \Database\table_t_details $proto foreign object prototype
	 * @return \Sigmalab\Database\Core\DBForeignKey
	 */
	public function key_details_id(?\Database\table_t_details $proto=null) :\Sigmalab\Database\Core\DBForeignKey
	{
		if ( is_null($proto) ) $proto = new \Database\table_t_details();
		$def = new \Sigmalab\Database\Core\DBForeignKey( $this->tag_details_id(), $proto->tag_details_id() );
		return( $def );
	}
      
	public function set_parent_key_value(int $value){
		$this->set_details_id($value);
	}

	public function get_parent_key_value():?int{
		return $this->get_details_id();
	}

	/** Get foreign key of parent class
	* @param \Sigmalab\Database\Core\IDataObject|null $proto foreign object prototype
	* @return \Sigmalab\Database\Core\DBForeignKey|null
	*/
	public function getParentKey(?\Sigmalab\Database\Core\IDataObject $proto=NULL): ?\Sigmalab\Database\Core\DBForeignKey
	{
		if ( !$proto ) {
			return $this->key_details_id(null);
		}
		else if ( $proto instanceof table_t_details ) {
			return $this->key_details_id($proto);
		}
		return null;
	}

        
	/** Create prototype of parent class.
	 * @return  \Sigmalab\Database\Core\IDataObject|null
	*/
	public function parentPrototype() : ?\Sigmalab\Database\Core\IDataObject
	{
		return $this->gettable_t_detailsPrototype();
	}
        

#ifndef KPHP
	// Loaders
        
#endif

    
}

  
