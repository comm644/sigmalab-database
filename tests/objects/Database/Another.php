<?php
namespace Database;

/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_another_link
 */
class Another extends \Sigmalab\Database\Core\DBObject
{
	

	/** 
	 * @access private
	 * @var int|null
	 */
	public ?int $another_link_id;

	/** 
	 * @access private
	 * @var int|null
	 */
	public ?int $owner_id;

	/** 
	 * @access private
	 * @var int|null
	 */
	public ?int $child_id;

	/** construct object
	 * @param string|null $alias
	*/
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->another_link_id =  0 ;
	  	$this->owner_id =  0 ;
	  	$this->child_id =  0 ;
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return Another
	 */
	public function getAnotherPrototype(?string $alias=null) : Another
	{
		return new Another($alias);
	}

  
	/** returns primary key tag */
	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition
	{
		return $this->tag_another_link_id() ;
	}

	/** get primary key value
	 * @return int primary key value with type as defined in database (value of \a another_link_id )
	 * @noinspection PhpMissingParentCallCommonInspection
	 */
	public function primary_key_value():int
	{
		return( (int)$this->another_link_id );
		
	}


  /** @inheritDoc */
	public function set_primary_key_value(int $value):void
	{
		$this->another_link_id = $value;
	}

  
	public function createSelf():\Sigmalab\Database\Core\IDataObject
	{
		if ( get_class($this) !== __CLASS__) {
			\Sigmalab\Database\Core\DataSourceLogger::getInstance()->warning(get_class($this)."::createSelf() not implemented fallback to parent");
			return parent::createSelf();
		}
		return new self();
	}

	/** always contains \a "t_another_link"
	 */
	public function table_name() :string
	{
		return( "t_another_link" );
	}

	/** always contains \a "t_another_link"
	*/
	public function table_description():string
	{
		return( "presents many-to-many link" );
	}
  
	/** @inheritDoc */
  /** return Column Definition array
  * @return \Sigmalab\Database\Core\IDBColumnDefinition[] items - object relation scheme
  */
	public function getColumnDefinition(): array
	{
		$columnDefinition = array();
        		$columnDefinition[ AnotherFields::another_link_id ] = $this->tag_another_link_id();
		$columnDefinition[ AnotherFields::owner_id ] = $this->tag_owner_id();
		$columnDefinition[ AnotherFields::child_id ] = $this->tag_child_id();

		return( $columnDefinition );
	}

	/** get column definitions for foreign keys
	 * @return \Sigmalab\Database\Core\DBForeignKey[]
	 */
	public function getForeignKeys() : array
	{
		$keyDefs = array();
		$keyDefs[ AnotherFields::owner_id ] = $this->key_owner_id();
  $keyDefs[ AnotherFields::child_id ] = $this->key_child_id();
  
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
  
	/** set value to another_link_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_another_link_id(?int $value ) : bool
	{
		if ($this->another_link_id === $value) return false;
		$this->setChangedValue(AnotherFields::another_link_id, $this->another_link_id);
		$this->another_link_id = $value;
		return( true );
	}

	/** get value from \a another_link_id  column
	 * @return int|null value
	 */
	public function get_another_link_id()  :?int
	{
		return( $this->another_link_id );
	}
  
	/** set value to owner_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_owner_id(?int $value ) : bool
	{
		if ($this->owner_id === $value) return false;
		$this->setChangedValue(AnotherFields::owner_id, $this->owner_id);
		$this->owner_id = $value;
		return( true );
	}

	/** get value from \a owner_id  column
	 * @return int|null value
	 */
	public function get_owner_id()  :?int
	{
		return( $this->owner_id );
	}
  
	/** set value to child_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_child_id(?int $value ) : bool
	{
		if ($this->child_id === $value) return false;
		$this->setChangedValue(AnotherFields::child_id, $this->child_id);
		$this->child_id = $value;
		return( true );
	}

	/** get value from \a child_id  column
	 * @return int|null value
	 */
	public function get_child_id()  :?int
	{
		return( $this->child_id );
	}
  

	/** Import value (from sql )
	 * @param string $name
	 * @param mixed $value
	 */
  public function importValue(string $name, $value) :void {
    switch($name)
    {
      
        case AnotherFields::another_link_id:
             
             $this->another_link_id = (int)$value;
             return;
      
        case AnotherFields::owner_id:
             
             $this->owner_id = (int)$value;
             return;
      
        case AnotherFields::child_id:
             
             $this->child_id = (int)$value;
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
      
        case AnotherFieldKeys::another_link_id:
             
             $this->another_link_id = (int)$value;
             return true;
      
        case AnotherFieldKeys::owner_id:
             
             $this->owner_id = (int)$value;
             return true;
      
        case AnotherFieldKeys::child_id:
             
             $this->child_id = (int)$value;
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
      
        case AnotherFields::another_link_id:
              $notNull_another_link_id = (int)$this->another_link_id;
             if ( $notNull_another_link_id === ((int)$value)) return true;
             $this->setChangedValue($name, $this->another_link_id);
             $this->another_link_id = (int)$value;
             return true;
      
        case AnotherFields::owner_id:
              $notNull_owner_id = (int)$this->owner_id;
             if ( $notNull_owner_id === ((int)$value)) return true;
             $this->setChangedValue($name, $this->owner_id);
             $this->owner_id = (int)$value;
             return true;
      
        case AnotherFields::child_id:
              $notNull_child_id = (int)$this->child_id;
             if ( $notNull_child_id === ((int)$value)) return true;
             $this->setChangedValue($name, $this->child_id);
             $this->child_id = (int)$value;
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
      
        case AnotherFields::another_link_id:
             return $this->another_link_id;
      
        case AnotherFields::owner_id:
             return $this->owner_id;
      
        case AnotherFields::child_id:
             return $this->child_id;
      
    }
    return parent::getValue ($name);
  }

	//Tags
  
	/** get column definition for \a another_link_id column
	 * @param string|null $alias  alias for \a another_link_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_another_link_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( AnotherFields::another_link_id, "int", $alias,$this, false, "", false,AnotherFieldKeys::another_link_id);

		return( $def );
	}
  
	/** get column definition for \a owner_id column
	 * @param string|null $alias  alias for \a owner_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_owner_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( AnotherFields::owner_id, "int", $alias,$this, false, "", false,AnotherFieldKeys::owner_id);

		return( $def );
	}
  
	/** get column definition for \a child_id column
	 * @param string|null $alias  alias for \a child_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_child_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( AnotherFields::child_id, "int", $alias,$this, false, "", false,AnotherFieldKeys::child_id);

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
		return array_merge( array('Another' => new Another()), parent::prototypeMap() );
	}

	//Foreign keys
    

	/** Foreign key for tag_owner_id() as link to Database\Data::tag_data_id()
	 * @param \Database\Data $proto foreign object prototype
	 * @return \Sigmalab\Database\Core\DBForeignKey
	 */
	public function key_owner_id(?\Database\Data $proto=null) :\Sigmalab\Database\Core\DBForeignKey
	{
		if ( is_null($proto) ) $proto = new \Database\Data();
		$def = new \Sigmalab\Database\Core\DBForeignKey( $this->tag_owner_id(), $proto->tag_data_id() );
		return( $def );
	}
      

	/** Foreign key for tag_child_id() as link to Database\Dictionary::tag_dictionary_id()
	 * @param \Database\Dictionary $proto foreign object prototype
	 * @return \Sigmalab\Database\Core\DBForeignKey
	 */
	public function key_child_id(?\Database\Dictionary $proto=null) :\Sigmalab\Database\Core\DBForeignKey
	{
		if ( is_null($proto) ) $proto = new \Database\Dictionary();
		$def = new \Sigmalab\Database\Core\DBForeignKey( $this->tag_child_id(), $proto->tag_dictionary_id() );
		return( $def );
	}
      

#ifndef KPHP
	// Loaders
        
	/** load data specified by foreign key owner_id
	* @param $ds \Sigmalab\Database\Core\IDataSource  data source instance
	* @return void
  * @reflection-skip
	*/
	public function load_data( \Sigmalab\Database\Core\IDataSource $ds ):void
	{
		$this->data = $ds->queryStatement(\StmHelper::stmSelectByPrimaryKey(new \Data(), $this->owner_id ));
	}
	
	/** load dictionary specified by foreign key child_id
	* @param $ds \Sigmalab\Database\Core\IDataSource  data source instance
	* @return void
  * @reflection-skip
	*/
	public function load_dictionary( \Sigmalab\Database\Core\IDataSource $ds ):void
	{
		$this->dictionary = $ds->queryStatement(\StmHelper::stmSelectByPrimaryKey(new \Dictionary(), $this->child_id ));
	}
	
#endif

    
}

  
