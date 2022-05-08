<?php
namespace Database;

/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_data
 */
class Data extends \Sigmalab\Database\Core\DBObject
{
	

	/** 
	 * @access private
	 * @var int|null
	 */
	public ?int $data_id;

	/** 
	 * @access private
	 * @var int|null
	 */
	public ?int $date;

	/** 
	 * @access private
	 * @var int|null
	 */
	public ?int $value;

	/** 
	 * @access private
	 * @var string|null
	 */
	public ?string $string;

	/** 
	 * @access private
	 * @var string|null
	 */
	public ?string $text;

	/** 
	 * @access private
	 * @var string|null
	 */
	public ?string $blob;

	/** 
	 * @access private
	 * @var float|null
	 */
	public ?float $real;

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
		
	  	$this->data_id =  0 ;
	  	$this->date =  NULL ;
	  	$this->value =  NULL ;
	  	$this->string =  NULL ;
	  	$this->text =  NULL ;
	  	$this->blob =  NULL ;
	  	$this->real =  NULL ;
	  	$this->dictionary_id =  NULL ;
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return Data
	 */
	public function getDataPrototype(?string $alias=null) : Data
	{
		return new Data($alias);
	}

  
	/** returns primary key tag */
	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition
	{
		return $this->tag_data_id() ;
	}

	/** get primary key value
	 * @return int primary key value with type as defined in database (value of \a data_id )
	 * @noinspection PhpMissingParentCallCommonInspection
	 */
	public function primary_key_value():int
	{
		return( (int)$this->data_id );
		
	}


  /** @inheritDoc */
	public function set_primary_key_value(int $value):void
	{
		$this->data_id = $value;
	}

  
	public function createSelf():\Sigmalab\Database\Core\IDataObject
	{
		if ( get_class($this) !== __CLASS__) {
			\Sigmalab\Database\Core\DataSourceLogger::getInstance()->warning(get_class($this)."::createSelf() not implemented fallback to parent");
			return parent::createSelf();
		}
		return new self();
	}

	/** always contains \a "t_data"
	 */
	public function table_name() :string
	{
		return( "t_data" );
	}

	/** always contains \a "t_data"
	*/
	public function table_description():string
	{
		return( "presents data object" );
	}
  
	/** @inheritDoc */
  /** return Column Definition array
  * @return \Sigmalab\Database\Core\IDBColumnDefinition[] items - object relation scheme
  */
	public function getColumnDefinition(): array
	{
		$columnDefinition = array();
        		$columnDefinition[ DataFields::data_id ] = $this->tag_data_id();
		$columnDefinition[ DataFields::date ] = $this->tag_date();
		$columnDefinition[ DataFields::value ] = $this->tag_value();
		$columnDefinition[ DataFields::string ] = $this->tag_string();
		$columnDefinition[ DataFields::text ] = $this->tag_text();
		$columnDefinition[ DataFields::blob ] = $this->tag_blob();
		$columnDefinition[ DataFields::real ] = $this->tag_real();
		$columnDefinition[ DataFields::dictionary_id ] = $this->tag_dictionary_id();

		return( $columnDefinition );
	}

	/** get column definitions for foreign keys
	 * @return \Sigmalab\Database\Core\DBForeignKey[]
	 */
	public function getForeignKeys() : array
	{
		$keyDefs = array();
		$keyDefs[ DataFields::dictionary_id ] = $this->key_dictionary_id();
  
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
  
	/** set value to data_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_data_id(?int $value ) : bool
	{
		if ($this->data_id === $value) return false;
		$this->setChangedValue(DataFields::data_id, $this->data_id);
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
  
	/** set value to date  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_date(?int $value ) : bool
	{
		if ($this->date === $value) return false;
		$this->setChangedValue(DataFields::date, $this->date);
		$this->date = $value;
		return( true );
	}

	/** get value from \a date  column
	 * @return int|null value
	 */
	public function get_date() :?int
	{
		return( $this->date );
	}
  
	/** set value to value  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_value(?int $value ) : bool
	{
		if ($this->value === $value) return false;
		$this->setChangedValue(DataFields::value, $this->value);
		$this->value = $value;
		return( true );
	}

	/** get value from \a value  column
	 * @return int|null value
	 */
	public function get_value()  :?int
	{
		return( $this->value );
	}
  
	/** set value to string  column
	 * @param string|null $value  value
	 * @return bool true when value changed
	 */
	public function set_string(?string $value ) : bool
	{
		if ($this->string === $value) return false;
		$this->setChangedValue(DataFields::string, $this->string);
		$this->string = $value;
		return( true );
	}

	/** get value from \a string  column
	 * @return string|null value
	 */
	public function get_string()  :?string
	{
		return( $this->string );
	}
  
	/** set value to text  column
	 * @param string|null $value  value
	 * @return bool true when value changed
	 */
	public function set_text(?string $value ) : bool
	{
		if ($this->text === $value) return false;
		$this->setChangedValue(DataFields::text, $this->text);
		$this->text = $value;
		return( true );
	}

	/** get value from \a text  column
	 * @return string|null value
	 */
	public function get_text()  :?string
	{
		return( $this->text );
	}
  
	/** set value to blob  column
	 * @param string|null $value  value
	 * @return bool true when value changed
	 */
	public function set_blob(?string $value ) : bool
	{
		if ($this->blob === $value) return false;
		$this->setChangedValue(DataFields::blob, $this->blob);
		$this->blob = $value;
		return( true );
	}

	/** get value from \a blob  column
	 * @return string|null value
	 */
	public function get_blob() :?string
	{
		return( $this->blob );
	}
  
	/** set value to real  column
	 * @param float|null $value  value
	 * @return bool true when value changed
	 */
	public function set_real(?float $value ) : bool
	{
		if ($this->real === $value) return false;
		$this->setChangedValue(DataFields::real, $this->real);
		$this->real = $value;
		return( true );
	}

	/** get value from \a real  column
	 * @return float|null value
	 */
	public function get_real()  :?float
	{
		return( $this->real );
	}
  
	/** set value to dictionary_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_dictionary_id(?int $value ) : bool
	{
		if ($this->dictionary_id === $value) return false;
		$this->setChangedValue(DataFields::dictionary_id, $this->dictionary_id);
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
      
        case DataFields::data_id:
             
             $this->data_id = (int)$value;
             return;
      
        case DataFields::date:
             if ( $value === null ) $this->date = null; else 
             $this->date = (int)$value;
             return;
      
        case DataFields::value:
             if ( $value === null ) $this->value = null; else 
             $this->value = (int)$value;
             return;
      
        case DataFields::string:
             if ( $value === null ) $this->string = null; else 
             $this->string = (string)$value;
             return;
      
        case DataFields::text:
             if ( $value === null ) $this->text = null; else 
             $this->text = (string)$value;
             return;
      
        case DataFields::blob:
             if ( $value === null ) $this->blob = null; else 
             $this->blob = (string)$value;
             return;
      
        case DataFields::real:
             if ( $value === null ) $this->real = null; else 
             $this->real = (float)$value;
             return;
      
        case DataFields::dictionary_id:
             if ( $value === null ) $this->dictionary_id = null; else 
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
      
        case DataFieldKeys::data_id:
             
             $this->data_id = (int)$value;
             return true;
      
        case DataFieldKeys::date:
             if ( $value === null ) $this->date = null; else 
             $this->date = (int)$value;
             return true;
      
        case DataFieldKeys::value:
             if ( $value === null ) $this->value = null; else 
             $this->value = (int)$value;
             return true;
      
        case DataFieldKeys::string:
             if ( $value === null ) $this->string = null; else 
             $this->string = (string)$value;
             return true;
      
        case DataFieldKeys::text:
             if ( $value === null ) $this->text = null; else 
             $this->text = (string)$value;
             return true;
      
        case DataFieldKeys::blob:
             if ( $value === null ) $this->blob = null; else 
             $this->blob = (string)$value;
             return true;
      
        case DataFieldKeys::real:
             if ( $value === null ) $this->real = null; else 
             $this->real = (float)$value;
             return true;
      
        case DataFieldKeys::dictionary_id:
             if ( $value === null ) $this->dictionary_id = null; else 
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
      
        case DataFields::data_id:
              $notNull_data_id = (int)$this->data_id;
             if ( $notNull_data_id === ((int)$value)) return true;
             $this->setChangedValue($name, $this->data_id);
             $this->data_id = (int)$value;
             return true;
      
        case DataFields::date:
              $notNull_date = (int)$this->date;
             if ( $notNull_date === ((int)$value)) return true;
             $this->setChangedValue($name, $this->date);
             $this->date = (int)$value;
             return true;
      
        case DataFields::value:
              $notNull_value = (int)$this->value;
             if ( $notNull_value === ((int)$value)) return true;
             $this->setChangedValue($name, $this->value);
             $this->value = (int)$value;
             return true;
      
        case DataFields::string:
              $notNull_string = (string)$this->string;
             if ( $notNull_string === ((string)$value)) return true;
             $this->setChangedValue($name, $this->string);
             $this->string = (string)$value;
             return true;
      
        case DataFields::text:
              $notNull_text = (string)$this->text;
             if ( $notNull_text === ((string)$value)) return true;
             $this->setChangedValue($name, $this->text);
             $this->text = (string)$value;
             return true;
      
        case DataFields::blob:
              $notNull_blob = (string)$this->blob;
             if ( $notNull_blob === ((string)$value)) return true;
             $this->setChangedValue($name, $this->blob);
             $this->blob = (string)$value;
             return true;
      
        case DataFields::real:
              $notNull_real = (float)$this->real;
             if ( $notNull_real === ((float)$value)) return true;
             $this->setChangedValue($name, $this->real);
             $this->real = (float)$value;
             return true;
      
        case DataFields::dictionary_id:
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
      
        case DataFields::data_id:
             return $this->data_id;
      
        case DataFields::date:
             return $this->date;
      
        case DataFields::value:
             return $this->value;
      
        case DataFields::string:
             return $this->string;
      
        case DataFields::text:
             return $this->text;
      
        case DataFields::blob:
             return $this->blob;
      
        case DataFields::real:
             return $this->real;
      
        case DataFields::dictionary_id:
             return $this->dictionary_id;
      
    }
    return parent::getValue ($name);
  }

	//Tags
  
	/** get column definition for \a data_id column
	 * @param string|null $alias  alias for \a data_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_data_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( DataFields::data_id, "int", $alias,$this, false, "", false,DataFieldKeys::data_id);

		return( $def );
	}
  
	/** get column definition for \a date column
	 * @param string|null $alias  alias for \a date column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_date(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( DataFields::date, "datetime", $alias,$this, false, "", true,DataFieldKeys::date);

		return( $def );
	}
  
	/** get column definition for \a value column
	 * @param string|null $alias  alias for \a value column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_value(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( DataFields::value, "int", $alias,$this, false, "", true,DataFieldKeys::value);

		return( $def );
	}
  
	/** get column definition for \a string column
	 * @param string|null $alias  alias for \a string column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_string(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( DataFields::string, "string", $alias,$this, false, "", true,DataFieldKeys::string);

		return( $def );
	}
  
	/** get column definition for \a text column
	 * @param string|null $alias  alias for \a text column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_text(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( DataFields::text, "string", $alias,$this, false, "", true,DataFieldKeys::text);

		return( $def );
	}
  
	/** get column definition for \a blob column
	 * @param string|null $alias  alias for \a blob column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_blob(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( DataFields::blob, "blob", $alias,$this, false, "", true,DataFieldKeys::blob);

		return( $def );
	}
  
	/** get column definition for \a real column
	 * @param string|null $alias  alias for \a real column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_real(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( DataFields::real, "float", $alias,$this, false, "", true,DataFieldKeys::real);

		return( $def );
	}
  
	/** get column definition for \a dictionary_id column
	 * @param string|null $alias  alias for \a dictionary_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_dictionary_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( DataFields::dictionary_id, "int", $alias,$this, false, "", true,DataFieldKeys::dictionary_id);

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
		return array_merge( array('Data' => new Data()), parent::prototypeMap() );
	}

	//Foreign keys
    

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

  
