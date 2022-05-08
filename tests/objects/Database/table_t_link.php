<?php
namespace Database;

/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_link
 */
class table_t_link extends \Sigmalab\Database\Core\DBObject
{
	

	/** 
	 * @access private
	 * @var int|null
	 */
	public ?int $link_id;

	/** 
	 * @access private
	 * @var int|null
	 */
	public ?int $data_id;

	/** 
	 * @access private
	 * @var int|null
	 */
	public ?int $dictionary_id;

	/** construct object
	 * @param string|null $alias
	*/
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->link_id =  0 ;
	  	$this->data_id =  0 ;
	  	$this->dictionary_id =  0 ;
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return table_t_link
	 */
	public function gettable_t_linkPrototype(?string $alias=null) : table_t_link
	{
		return new table_t_link($alias);
	}

  
	/** returns primary key tag */
	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition
	{
		return $this->tag_link_id() ;
	}

	/** get primary key value
	 * @return int primary key value with type as defined in database (value of \a link_id )
	 * @noinspection PhpMissingParentCallCommonInspection
	 */
	public function primary_key_value():int
	{
		return( (int)$this->link_id );
		
	}


  /** @inheritDoc */
	public function set_primary_key_value(int $value):void
	{
		$this->link_id = $value;
	}

  
	public function createSelf():\Sigmalab\Database\Core\IDataObject
	{
		if ( get_class($this) !== __CLASS__) {
			\Sigmalab\Database\Core\DataSourceLogger::getInstance()->warning(get_class($this)."::createSelf() not implemented fallback to parent");
			return parent::createSelf();
		}
		return new self();
	}

	/** always contains \a "t_link"
	 */
	public function table_name() :string
	{
		return( "t_link" );
	}

	/** always contains \a "t_link"
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
        		$columnDefinition[ table_t_linkFields::link_id ] = $this->tag_link_id();
		$columnDefinition[ table_t_linkFields::data_id ] = $this->tag_data_id();
		$columnDefinition[ table_t_linkFields::dictionary_id ] = $this->tag_dictionary_id();

		return( $columnDefinition );
	}

	/** get column definitions for foreign keys
	 * @return \Sigmalab\Database\Core\DBForeignKey[]
	 */
	public function getForeignKeys() : array
	{
		$keyDefs = array();
		$keyDefs[ table_t_linkFields::data_id ] = $this->key_data_id();
  $keyDefs[ table_t_linkFields::dictionary_id ] = $this->key_dictionary_id();
  
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
  
	/** set value to link_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_link_id(?int $value ) : bool
	{
		if ($this->link_id === $value) return false;
		$this->setChangedValue(table_t_linkFields::link_id, $this->link_id);
		$this->link_id = $value;
		return( true );
	}

	/** get value from \a link_id  column
	 * @return int|null value
	 */
	public function get_link_id()  :?int
	{
		return( $this->link_id );
	}
  
	/** set value to data_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_data_id(?int $value ) : bool
	{
		if ($this->data_id === $value) return false;
		$this->setChangedValue(table_t_linkFields::data_id, $this->data_id);
		$this->data_id = $value;
		return( true );
	}

	/** get value from \a data_id  column
	 * @return int|null value
	 */
	public function get_data_id()  :?int
	{
		return( $this->data_id );
	}
  
	/** set value to dictionary_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_dictionary_id(?int $value ) : bool
	{
		if ($this->dictionary_id === $value) return false;
		$this->setChangedValue(table_t_linkFields::dictionary_id, $this->dictionary_id);
		$this->dictionary_id = $value;
		return( true );
	}

	/** get value from \a dictionary_id  column
	 * @return int|null value
	 */
	public function get_dictionary_id()  :?int
	{
		return( $this->dictionary_id );
	}
  

	/** Import value (from sql )
	 * @param string $name
	 * @param mixed $value
	 */
  public function importValue(string $name, $value) :void {
    switch($name)
    {
      
        case table_t_linkFields::link_id:
             
             $this->link_id = (int)$value;
             return;
      
        case table_t_linkFields::data_id:
             
             $this->data_id = (int)$value;
             return;
      
        case table_t_linkFields::dictionary_id:
             
             $this->dictionary_id = (int)$value;
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
      
        case table_t_linkFieldKeys::link_id:
             
             $this->link_id = (int)$value;
             return true;
      
        case table_t_linkFieldKeys::data_id:
             
             $this->data_id = (int)$value;
             return true;
      
        case table_t_linkFieldKeys::dictionary_id:
             
             $this->dictionary_id = (int)$value;
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
      
        case table_t_linkFields::link_id:
              $notNull_link_id = (int)$this->link_id;
             if ( $notNull_link_id === ((int)$value)) return true;
             $this->setChangedValue($name, $this->link_id);
             $this->link_id = (int)$value;
             return true;
      
        case table_t_linkFields::data_id:
              $notNull_data_id = (int)$this->data_id;
             if ( $notNull_data_id === ((int)$value)) return true;
             $this->setChangedValue($name, $this->data_id);
             $this->data_id = (int)$value;
             return true;
      
        case table_t_linkFields::dictionary_id:
              $notNull_dictionary_id = (int)$this->dictionary_id;
             if ( $notNull_dictionary_id === ((int)$value)) return true;
             $this->setChangedValue($name, $this->dictionary_id);
             $this->dictionary_id = (int)$value;
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
      
        case table_t_linkFields::link_id:
             return $this->link_id;
      
        case table_t_linkFields::data_id:
             return $this->data_id;
      
        case table_t_linkFields::dictionary_id:
             return $this->dictionary_id;
      
    }
    return parent::getValue ($name);
  }

	//Tags
  
	/** get column definition for \a link_id column
	 * @param string|null $alias  alias for \a link_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_link_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_linkFields::link_id, "int", $alias,$this, false, "", false,table_t_linkFieldKeys::link_id);

		return( $def );
	}
  
	/** get column definition for \a data_id column
	 * @param string|null $alias  alias for \a data_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_data_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_linkFields::data_id, "int", $alias,$this, false, "", false,table_t_linkFieldKeys::data_id);

		return( $def );
	}
  
	/** get column definition for \a dictionary_id column
	 * @param string|null $alias  alias for \a dictionary_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_dictionary_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_linkFields::dictionary_id, "int", $alias,$this, false, "", false,table_t_linkFieldKeys::dictionary_id);

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
		return array_merge( array('table_t_link' => new table_t_link()), parent::prototypeMap() );
	}

	//Foreign keys
    

	/** Foreign key for tag_data_id() as link to Database\Data::tag_data_id()
	 * @param \Database\Data $proto foreign object prototype
	 * @return \Sigmalab\Database\Core\DBForeignKey
	 */
	public function key_data_id(?\Database\Data $proto=null) :\Sigmalab\Database\Core\DBForeignKey
	{
		if ( is_null($proto) ) $proto = new \Database\Data();
		$def = new \Sigmalab\Database\Core\DBForeignKey( $this->tag_data_id(), $proto->tag_data_id() );
		return( $def );
	}
      

	/** Foreign key for tag_dictionary_id() as link to Database\Dictionary::tag_dictionary_id()
	 * @param \Database\Dictionary $proto foreign object prototype
	 * @return \Sigmalab\Database\Core\DBForeignKey
	 */
	public function key_dictionary_id(?\Database\Dictionary $proto=null) :\Sigmalab\Database\Core\DBForeignKey
	{
		if ( is_null($proto) ) $proto = new \Database\Dictionary();
		$def = new \Sigmalab\Database\Core\DBForeignKey( $this->tag_dictionary_id(), $proto->tag_dictionary_id() );
		return( $def );
	}
      

#ifndef KPHP
	// Loaders
        
	/** load data specified by foreign key data_id
	* @param $ds \Sigmalab\Database\Core\IDataSource  data source instance
	* @return void
  * @reflection-skip
	*/
	public function load_data( \Sigmalab\Database\Core\IDataSource $ds ):void
	{
		$this->data = $ds->queryStatement(\StmHelper::stmSelectByPrimaryKey(new \Database\Data(), $this->data_id ));
	}
	
	/** load dictionary specified by foreign key dictionary_id
	* @param $ds \Sigmalab\Database\Core\IDataSource  data source instance
	* @return void
  * @reflection-skip
	*/
	public function load_dictionary( \Sigmalab\Database\Core\IDataSource $ds ):void
	{
		$this->dictionary = $ds->queryStatement(\StmHelper::stmSelectByPrimaryKey(new \Database\Dictionary(), $this->dictionary_id ));
	}
	
#endif

    
}

  
