<?php
#ifndef KPHP
/** @noinspection PhpMultipleClassesDeclarationsInOneFile */
#endif

/*
 *
 *  DONT EDIT THIS FILE. AUTO CREATED BY mkobject.xsl
 *
 *  File: 
 */

namespace Database;
    
//@class DataFields

//namespace Database\Constants;
class DataFields
{
	
	public const data_id = 'data_id';
	public const date = 'date';
	public const value = 'value';
	public const string = 'string';
	public const text = 'text';
	public const blob = 'blob';
	public const real = 'real';
	public const dictionary_id = 'dictionary_id';
}

  
//@class DataFieldKeys

//namespace Database\Constants;
class DataFieldKeys
{

	public const data_id = 101;
	public const date = 102;
	public const value = 103;
	public const string = 104;
	public const text = 105;
	public const blob = 106;
	public const real = 107;
	public const dictionary_id = 108;
}


  

//@class DataId
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_data
 * @kphp-serializable
 */
class DataId extends \Sigmalab\Database\Core\DBObject
{


	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 1
	 */
	public ?int $data_id;

	/** construct object
	 * @param string|null $alias
	 */
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->data_id =  0 ;
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
  
	/** get column definition for \a data_id column
	 * @param string|null $alias  alias for \a data_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_data_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( DataFields::data_id, "int", $alias,$this, false, "", false,DataFieldKeys::data_id);

		return( $def );
	}
  

	/**  @inheritDoc */
  /** return Column Definition array
  * @return \Sigmalab\Database\Core\IDBColumnDefinition[] items - object relation scheme
  */
	public function getColumnDefinition(): array
	{
		$columnDefinition = array();
		$columnDefinition[ DataFields::data_id ] = $this->tag_data_id();

		return( $columnDefinition );
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return DataId
	 */
	public function getDataIdPrototype(?string $alias=null) : DataId
	{
		return new DataId($alias);
	}

	/** Gets prototype map for an object.
	*
	* array: table name => \Sigmalab\Database\Core\DBObject
	*
	* @return \Sigmalab\Database\Core\DBObject[]
	*/
	public function prototypeMap() : array
	{
		return array_merge( array('DataId' => new DataId()), parent::prototypeMap() );
	}

	//Foreign keys
    
}


//@class Data
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_data
 * @kphp-serializable
 */
class Data extends \Sigmalab\Database\Core\DBObject
{
	

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 1
	 */
	public ?int $data_id;

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 2
	 */
	public ?int $date;

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 3
	 */
	public ?int $value;

	/** 
	 * @access private
	 * @var string|null
	 * @kphp-serialized-field 4
	 */
	public ?string $string;

	/** 
	 * @access private
	 * @var string|null
	 * @kphp-serialized-field 5
	 */
	public ?string $text;

	/** 
	 * @access private
	 * @var string|null
	 * @kphp-serialized-field 6
	 */
	public ?string $blob;

	/** 
	 * @access private
	 * @var float|null
	 * @kphp-serialized-field 7
	 */
	public ?float $real;

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 8
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

  
//@class DictionaryFields

//namespace Database\Constants;
class DictionaryFields
{
	
	public const dictionary_id = 'dictionary_id';
	public const text = 'text';
}

  
//@class DictionaryFieldKeys

//namespace Database\Constants;
class DictionaryFieldKeys
{

	public const dictionary_id = 201;
	public const text = 202;
}


  

//@class DictionaryId
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_dictionary
 * @kphp-serializable
 */
class DictionaryId extends \Sigmalab\Database\Core\DBObject
{


	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 1
	 */
	public ?int $dictionary_id;

	/** construct object
	 * @param string|null $alias
	 */
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->dictionary_id =  0 ;
		}

  
	public function createSelf():\Sigmalab\Database\Core\IDataObject
	{
		if ( get_class($this) !== __CLASS__) {
			\Sigmalab\Database\Core\DataSourceLogger::getInstance()->warning(get_class($this)."::createSelf() not implemented fallback to parent");
			return parent::createSelf();
		}
		return new self();
	}

	/** always contains \a "t_dictionary"
	 */
	public function table_name() :string
	{
		return( "t_dictionary" );
	}

	/** always contains \a "t_dictionary"
	*/
	public function table_description():string
	{
		return( "presents dictionary object" );
	}
  
	/** returns primary key tag */
	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition
	{
		return $this->tag_dictionary_id() ;
	}

	/** get primary key value
	 * @return int primary key value with type as defined in database (value of \a dictionary_id )
	 * @noinspection PhpMissingParentCallCommonInspection
	 */
	public function primary_key_value():int
	{
		return( (int)$this->dictionary_id );
		
	}


  /** @inheritDoc */
	public function set_primary_key_value(int $value):void
	{
		$this->dictionary_id = $value;
	}

  
	/** set value to dictionary_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_dictionary_id(?int $value ) : bool
	{
		if ($this->dictionary_id === $value) return false;
		$this->setChangedValue(DictionaryFields::dictionary_id, $this->dictionary_id);
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
  
	/** get column definition for \a dictionary_id column
	 * @param string|null $alias  alias for \a dictionary_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_dictionary_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( DictionaryFields::dictionary_id, "int", $alias,$this, false, "", false,DictionaryFieldKeys::dictionary_id);

		return( $def );
	}
  

	/**  @inheritDoc */
  /** return Column Definition array
  * @return \Sigmalab\Database\Core\IDBColumnDefinition[] items - object relation scheme
  */
	public function getColumnDefinition(): array
	{
		$columnDefinition = array();
		$columnDefinition[ DictionaryFields::dictionary_id ] = $this->tag_dictionary_id();

		return( $columnDefinition );
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return DictionaryId
	 */
	public function getDictionaryIdPrototype(?string $alias=null) : DictionaryId
	{
		return new DictionaryId($alias);
	}

	/** Gets prototype map for an object.
	*
	* array: table name => \Sigmalab\Database\Core\DBObject
	*
	* @return \Sigmalab\Database\Core\DBObject[]
	*/
	public function prototypeMap() : array
	{
		return array_merge( array('DictionaryId' => new DictionaryId()), parent::prototypeMap() );
	}

	//Foreign keys
    
}


//@class Dictionary
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_dictionary
 * @kphp-serializable
 */
class Dictionary extends \Sigmalab\Database\Core\DBObject
{
	

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 1
	 */
	public ?int $dictionary_id;

	/** 
	 * @access private
	 * @var string|null
	 * @kphp-serialized-field 2
	 */
	public ?string $text;

	/** construct object
	 * @param string|null $alias
	*/
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->dictionary_id =  0 ;
	  	$this->text =  NULL ;
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return Dictionary
	 */
	public function getDictionaryPrototype(?string $alias=null) : Dictionary
	{
		return new Dictionary($alias);
	}

  
	/** returns primary key tag */
	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition
	{
		return $this->tag_dictionary_id() ;
	}

	/** get primary key value
	 * @return int primary key value with type as defined in database (value of \a dictionary_id )
	 * @noinspection PhpMissingParentCallCommonInspection
	 */
	public function primary_key_value():int
	{
		return( (int)$this->dictionary_id );
		
	}


  /** @inheritDoc */
	public function set_primary_key_value(int $value):void
	{
		$this->dictionary_id = $value;
	}

  
	public function createSelf():\Sigmalab\Database\Core\IDataObject
	{
		if ( get_class($this) !== __CLASS__) {
			\Sigmalab\Database\Core\DataSourceLogger::getInstance()->warning(get_class($this)."::createSelf() not implemented fallback to parent");
			return parent::createSelf();
		}
		return new self();
	}

	/** always contains \a "t_dictionary"
	 */
	public function table_name() :string
	{
		return( "t_dictionary" );
	}

	/** always contains \a "t_dictionary"
	*/
	public function table_description():string
	{
		return( "presents dictionary object" );
	}
  
	/** @inheritDoc */
  /** return Column Definition array
  * @return \Sigmalab\Database\Core\IDBColumnDefinition[] items - object relation scheme
  */
	public function getColumnDefinition(): array
	{
		$columnDefinition = array();
        		$columnDefinition[ DictionaryFields::dictionary_id ] = $this->tag_dictionary_id();
		$columnDefinition[ DictionaryFields::text ] = $this->tag_text();

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
  
	/** set value to dictionary_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_dictionary_id(?int $value ) : bool
	{
		if ($this->dictionary_id === $value) return false;
		$this->setChangedValue(DictionaryFields::dictionary_id, $this->dictionary_id);
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
  
	/** set value to text  column
	 * @param string|null $value  value
	 * @return bool true when value changed
	 */
	public function set_text(?string $value ) : bool
	{
		if ($this->text === $value) return false;
		$this->setChangedValue(DictionaryFields::text, $this->text);
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
  

	/** Import value (from sql )
	 * @param string $name
	 * @param mixed $value
	 */
  public function importValue(string $name, $value) :void {
    switch($name)
    {
      
        case DictionaryFields::dictionary_id:
             
             $this->dictionary_id = (int)$value;
             return;
      
        case DictionaryFields::text:
             if ( $value === null ) $this->text = null; else 
             $this->text = (string)$value;
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
      
        case DictionaryFieldKeys::dictionary_id:
             
             $this->dictionary_id = (int)$value;
             return true;
      
        case DictionaryFieldKeys::text:
             if ( $value === null ) $this->text = null; else 
             $this->text = (string)$value;
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
      
        case DictionaryFields::dictionary_id:
              $notNull_dictionary_id = (int)$this->dictionary_id;
             if ( $notNull_dictionary_id === ((int)$value)) return true;
             $this->setChangedValue($name, $this->dictionary_id);
             $this->dictionary_id = (int)$value;
             return true;
      
        case DictionaryFields::text:
              $notNull_text = (string)$this->text;
             if ( $notNull_text === ((string)$value)) return true;
             $this->setChangedValue($name, $this->text);
             $this->text = (string)$value;
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
      
        case DictionaryFields::dictionary_id:
             return $this->dictionary_id;
      
        case DictionaryFields::text:
             return $this->text;
      
    }
    return parent::getValue ($name);
  }

	//Tags
  
	/** get column definition for \a dictionary_id column
	 * @param string|null $alias  alias for \a dictionary_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_dictionary_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( DictionaryFields::dictionary_id, "int", $alias,$this, false, "", false,DictionaryFieldKeys::dictionary_id);

		return( $def );
	}
  
	/** get column definition for \a text column
	 * @param string|null $alias  alias for \a text column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_text(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( DictionaryFields::text, "string", $alias,$this, false, "", true,DictionaryFieldKeys::text);

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
		return array_merge( array('Dictionary' => new Dictionary()), parent::prototypeMap() );
	}

	//Foreign keys
    

#ifndef KPHP
	// Loaders
        
#endif

    
}

  
//@class table_t_linkFields

//namespace Database\Constants;
class table_t_linkFields
{
	
	public const link_id = 'link_id';
	public const data_id = 'data_id';
	public const dictionary_id = 'dictionary_id';
}

  
//@class table_t_linkFieldKeys

//namespace Database\Constants;
class table_t_linkFieldKeys
{

	public const link_id = 301;
	public const data_id = 302;
	public const dictionary_id = 303;
}


  

//@class table_t_linkId
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_link
 * @kphp-serializable
 */
class table_t_linkId extends \Sigmalab\Database\Core\DBObject
{


	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 1
	 */
	public ?int $link_id;

	/** construct object
	 * @param string|null $alias
	 */
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->link_id =  0 ;
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
  
	/** get column definition for \a link_id column
	 * @param string|null $alias  alias for \a link_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_link_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_linkFields::link_id, "int", $alias,$this, false, "", false,table_t_linkFieldKeys::link_id);

		return( $def );
	}
  

	/**  @inheritDoc */
  /** return Column Definition array
  * @return \Sigmalab\Database\Core\IDBColumnDefinition[] items - object relation scheme
  */
	public function getColumnDefinition(): array
	{
		$columnDefinition = array();
		$columnDefinition[ table_t_linkFields::link_id ] = $this->tag_link_id();

		return( $columnDefinition );
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return table_t_linkId
	 */
	public function gettable_t_linkIdPrototype(?string $alias=null) : table_t_linkId
	{
		return new table_t_linkId($alias);
	}

	/** Gets prototype map for an object.
	*
	* array: table name => \Sigmalab\Database\Core\DBObject
	*
	* @return \Sigmalab\Database\Core\DBObject[]
	*/
	public function prototypeMap() : array
	{
		return array_merge( array('table_t_linkId' => new table_t_linkId()), parent::prototypeMap() );
	}

	//Foreign keys
    
}


//@class table_t_link
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_link
 * @kphp-serializable
 */
class table_t_link extends \Sigmalab\Database\Core\DBObject
{
	

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 1
	 */
	public ?int $link_id;

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 2
	 */
	public ?int $data_id;

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 3
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

  
//@class AnotherFields

//namespace Database\Constants;
class AnotherFields
{
	
	public const another_link_id = 'another_link_id';
	public const owner_id = 'owner_id';
	public const child_id = 'child_id';
}

  
//@class AnotherFieldKeys

//namespace Database\Constants;
class AnotherFieldKeys
{

	public const another_link_id = 401;
	public const owner_id = 402;
	public const child_id = 403;
}


  

//@class AnotherId
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_another_link
 * @kphp-serializable
 */
class AnotherId extends \Sigmalab\Database\Core\DBObject
{


	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 1
	 */
	public ?int $another_link_id;

	/** construct object
	 * @param string|null $alias
	 */
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->another_link_id =  0 ;
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
  
	/** get column definition for \a another_link_id column
	 * @param string|null $alias  alias for \a another_link_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_another_link_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( AnotherFields::another_link_id, "int", $alias,$this, false, "", false,AnotherFieldKeys::another_link_id);

		return( $def );
	}
  

	/**  @inheritDoc */
  /** return Column Definition array
  * @return \Sigmalab\Database\Core\IDBColumnDefinition[] items - object relation scheme
  */
	public function getColumnDefinition(): array
	{
		$columnDefinition = array();
		$columnDefinition[ AnotherFields::another_link_id ] = $this->tag_another_link_id();

		return( $columnDefinition );
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return AnotherId
	 */
	public function getAnotherIdPrototype(?string $alias=null) : AnotherId
	{
		return new AnotherId($alias);
	}

	/** Gets prototype map for an object.
	*
	* array: table name => \Sigmalab\Database\Core\DBObject
	*
	* @return \Sigmalab\Database\Core\DBObject[]
	*/
	public function prototypeMap() : array
	{
		return array_merge( array('AnotherId' => new AnotherId()), parent::prototypeMap() );
	}

	//Foreign keys
    
}


//@class Another
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_another_link
 * @kphp-serializable
 */
class Another extends \Sigmalab\Database\Core\DBObject
{
	

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 1
	 */
	public ?int $another_link_id;

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 2
	 */
	public ?int $owner_id;

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 3
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

  
//@class table_t_baseFields

//namespace Database\Constants;
class table_t_baseFields
{
	
	public const base_id = 'base_id';
	public const baseData = 'baseData';
}

  
//@class table_t_baseFieldKeys

//namespace Database\Constants;
class table_t_baseFieldKeys
{

	public const base_id = 501;
	public const baseData = 502;
}


  

//@class table_t_baseId
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_base
 * @kphp-serializable
 */
class table_t_baseId extends \Sigmalab\Database\Core\DBObject
{


	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 1
	 */
	public ?int $base_id;

	/** construct object
	 * @param string|null $alias
	 */
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->base_id =  0 ;
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
  
	/** get column definition for \a base_id column
	 * @param string|null $alias  alias for \a base_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_base_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_baseFields::base_id, "int", $alias,$this, false, "", false,table_t_baseFieldKeys::base_id);

		return( $def );
	}
  

	/**  @inheritDoc */
  /** return Column Definition array
  * @return \Sigmalab\Database\Core\IDBColumnDefinition[] items - object relation scheme
  */
	public function getColumnDefinition(): array
	{
		$columnDefinition = array();
		$columnDefinition[ table_t_baseFields::base_id ] = $this->tag_base_id();

		return( $columnDefinition );
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return table_t_baseId
	 */
	public function gettable_t_baseIdPrototype(?string $alias=null) : table_t_baseId
	{
		return new table_t_baseId($alias);
	}

	/** Gets prototype map for an object.
	*
	* array: table name => \Sigmalab\Database\Core\DBObject
	*
	* @return \Sigmalab\Database\Core\DBObject[]
	*/
	public function prototypeMap() : array
	{
		return array_merge( array('table_t_baseId' => new table_t_baseId()), parent::prototypeMap() );
	}

	//Foreign keys
    
}


//@class table_t_base
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_base
 * @kphp-serializable
 */
class table_t_base extends \Sigmalab\Database\Core\DBObject
{
	

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 1
	 */
	public ?int $base_id;

	/** 
	 * @access private
	 * @var int
	 * @kphp-serialized-field 2
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

  
//@class table_t_detailsFields

//namespace Database\Constants;
class table_t_detailsFields
{
	
	public const details_id = 'details_id';
	public const base_id = 'base_id';
	public const detailsData = 'detailsData';
}

  
//@class table_t_detailsFieldKeys

//namespace Database\Constants;
class table_t_detailsFieldKeys
{

	public const details_id = 601;
	public const base_id = 602;
	public const detailsData = 603;
}


  

//@class table_t_detailsId
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_details
 * @kphp-serializable
 */
class table_t_detailsId extends table_t_baseId
{


	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 1
	 */
	public ?int $details_id;

	/** @kphp-reserved-fields 2
	 */
      

	/** construct object
	 * @param string|null $alias
	 */
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->details_id =  0 ;
	  	$this->base_id =  0 ;
		}

  
	public function createSelf():\Sigmalab\Database\Core\IDataObject
	{
		if ( get_class($this) !== __CLASS__) {
			\Sigmalab\Database\Core\DataSourceLogger::getInstance()->warning(get_class($this)."::createSelf() not implemented fallback to parent");
			return parent::createSelf();
		}
		return new self();
	}

	/** always contains \a "t_details"
	 */
	public function table_name() :string
	{
		return( "t_details" );
	}

	/** always contains \a "t_details"
	*/
	public function table_description():string
	{
		return( "" );
	}
  
	/** returns primary key tag */
	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition
	{
		return $this->tag_details_id() ;
	}

	/** get primary key value
	 * @return int primary key value with type as defined in database (value of \a details_id )
	 * @noinspection PhpMissingParentCallCommonInspection
	 */
	public function primary_key_value():int
	{
		return( (int)$this->details_id );
		
	}


  /** @inheritDoc */
	public function set_primary_key_value(int $value):void
	{
		$this->details_id = $value;
	}

  
	/** set value to details_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_details_id(?int $value ) : bool
	{
		if ($this->details_id === $value) return false;
		$this->setChangedValue(table_t_detailsFields::details_id, $this->details_id);
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
  
	/** set value to base_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_base_id(?int $value ) : bool
	{
		if ($this->base_id === $value) return false;
		$this->setChangedValue(table_t_detailsFields::base_id, $this->base_id);
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
  
	/** get column definition for \a details_id column
	 * @param string|null $alias  alias for \a details_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_details_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_detailsFields::details_id, "int", $alias,$this, false, "", false,table_t_detailsFieldKeys::details_id);

		return( $def );
	}
  
	/** get column definition for \a base_id column
	 * @param string|null $alias  alias for \a base_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_base_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_detailsFields::base_id, "int", $alias,$this, false, "", false,table_t_detailsFieldKeys::base_id);

		return( $def );
	}
  

	/**  @inheritDoc */
  /** return Column Definition array
  * @return \Sigmalab\Database\Core\IDBColumnDefinition[] items - object relation scheme
  */
	public function getColumnDefinition(): array
	{
		$columnDefinition = array();
		$columnDefinition[ table_t_detailsFields::details_id ] = $this->tag_details_id();
		$columnDefinition[ table_t_detailsFields::base_id ] = $this->tag_base_id();

		return( $columnDefinition );
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return table_t_detailsId
	 */
	public function gettable_t_detailsIdPrototype(?string $alias=null) : table_t_detailsId
	{
		return new table_t_detailsId($alias);
	}

	/** Gets prototype map for an object.
	*
	* array: table name => \Sigmalab\Database\Core\DBObject
	*
	* @return \Sigmalab\Database\Core\DBObject[]
	*/
	public function prototypeMap() : array
	{
		return array_merge( array('table_t_detailsId' => new table_t_detailsId()), parent::prototypeMap() );
	}

	//Foreign keys
    

	/** Foreign key for tag_base_id() as link to Database\table_t_base::tag_base_id()
	 * @param \Database\table_t_baseId $proto foreign object prototype
	 * @return \Sigmalab\Database\Core\DBForeignKey
	 */
	public function key_base_id(?\Database\table_t_baseId $proto=null) :\Sigmalab\Database\Core\DBForeignKey
	{
		if ( is_null($proto) ) $proto = new \Database\table_t_baseId();
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
		/** @noinspection PhpParamsInspection */
		//kphp required strict types.
		return $this->key_base_id(instance_cast($proto, table_t_baseId::class));
	}

   
	/** Create prototype of parent class.
	 * @return   table_t_baseId
	*/
	public function parentPrototype() : ?\Sigmalab\Database\Core\IDataObject
	{
		return $this->gettable_t_baseIdPrototype();
	}
        
}


//@class table_t_details
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_details
 * @kphp-serializable
 */
class table_t_details extends table_t_base
{
	

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 3
	 */
	public ?int $details_id;

	/** @kphp-reserved-fields 4
	 */
      

	/** 
	 * @access private
	 * @var int
	 * @kphp-serialized-field 5
	 */
	public int $detailsData;

	/** construct object
	 * @param string|null $alias
	*/
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->details_id =  0 ;
	  	$this->base_id =  0 ;
	  	$this->detailsData =  0 ;
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return table_t_details
	 */
	public function gettable_t_detailsPrototype(?string $alias=null) : table_t_details
	{
		return new table_t_details($alias);
	}

  
	/** returns primary key tag */
	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition
	{
		return $this->tag_details_id() ;
	}

	/** get primary key value
	 * @return int primary key value with type as defined in database (value of \a details_id )
	 * @noinspection PhpMissingParentCallCommonInspection
	 */
	public function primary_key_value():int
	{
		return( (int)$this->details_id );
		
	}


  /** @inheritDoc */
	public function set_primary_key_value(int $value):void
	{
		$this->details_id = $value;
	}

  
	public function createSelf():\Sigmalab\Database\Core\IDataObject
	{
		if ( get_class($this) !== __CLASS__) {
			\Sigmalab\Database\Core\DataSourceLogger::getInstance()->warning(get_class($this)."::createSelf() not implemented fallback to parent");
			return parent::createSelf();
		}
		return new self();
	}

	/** always contains \a "t_details"
	 */
	public function table_name() :string
	{
		return( "t_details" );
	}

	/** always contains \a "t_details"
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
        		$columnDefinition[ table_t_detailsFields::details_id ] = $this->tag_details_id();
		$columnDefinition[ table_t_detailsFields::base_id ] = $this->tag_base_id();
		$columnDefinition[ table_t_detailsFields::detailsData ] = $this->tag_detailsData();

		return( $columnDefinition );
	}

	/** get column definitions for foreign keys
	 * @return \Sigmalab\Database\Core\DBForeignKey[]
	 */
	public function getForeignKeys() : array
	{
		$keyDefs = array();
		$keyDefs[ table_t_detailsFields::base_id ] = $this->key_base_id();
  
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
  
	/** set value to details_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_details_id(?int $value ) : bool
	{
		if ($this->details_id === $value) return false;
		$this->setChangedValue(table_t_detailsFields::details_id, $this->details_id);
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
  
	/** set value to base_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_base_id(?int $value ) : bool
	{
		if ($this->base_id === $value) return false;
		$this->setChangedValue(table_t_detailsFields::base_id, $this->base_id);
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
  
	/** set value to detailsData  column
	 * @param int $value  value
	 * @return bool true when value changed
	 */
	public function set_detailsData(int $value ) : bool
	{
		if ($this->detailsData === $value) return false;
		$this->setChangedValue(table_t_detailsFields::detailsData, $this->detailsData);
		$this->detailsData = $value;
		return( true );
	}

	/** get value from \a detailsData  column
	 * @return int value
	 */
	public function get_detailsData()  :int
	{
		return( $this->detailsData );
	}
  

	/** Import value (from sql )
	 * @param string $name
	 * @param mixed $value
	 */
  public function importValue(string $name, $value) :void {
    switch($name)
    {
      
        case table_t_detailsFields::details_id:
             
             $this->details_id = (int)$value;
             return;
      
        case table_t_detailsFields::base_id:
             
             $this->base_id = (int)$value;
             return;
      
        case table_t_detailsFields::detailsData:
             
             $this->detailsData = (int)$value;
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
      
        case table_t_detailsFieldKeys::details_id:
             
             $this->details_id = (int)$value;
             return true;
      
        case table_t_detailsFieldKeys::base_id:
             
             $this->base_id = (int)$value;
             return true;
      
        case table_t_detailsFieldKeys::detailsData:
             
             $this->detailsData = (int)$value;
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
      
        case table_t_detailsFields::details_id:
              $notNull_details_id = (int)$this->details_id;
             if ( $notNull_details_id === ((int)$value)) return true;
             $this->setChangedValue($name, $this->details_id);
             $this->details_id = (int)$value;
             return true;
      
        case table_t_detailsFields::base_id:
              $notNull_base_id = (int)$this->base_id;
             if ( $notNull_base_id === ((int)$value)) return true;
             $this->setChangedValue($name, $this->base_id);
             $this->base_id = (int)$value;
             return true;
      
        case table_t_detailsFields::detailsData:
              $notNull_detailsData = (int)$this->detailsData;
             if ( $notNull_detailsData === ((int)$value)) return true;
             $this->setChangedValue($name, $this->detailsData);
             $this->detailsData = (int)$value;
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
      
        case table_t_detailsFields::details_id:
             return $this->details_id;
      
        case table_t_detailsFields::base_id:
             return $this->base_id;
      
        case table_t_detailsFields::detailsData:
             return $this->detailsData;
      
    }
    return parent::getValue ($name);
  }

	//Tags
  
	/** get column definition for \a details_id column
	 * @param string|null $alias  alias for \a details_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_details_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_detailsFields::details_id, "int", $alias,$this, false, "", false,table_t_detailsFieldKeys::details_id);

		return( $def );
	}
  
	/** get column definition for \a base_id column
	 * @param string|null $alias  alias for \a base_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_base_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_detailsFields::base_id, "int", $alias,$this, false, "", false,table_t_detailsFieldKeys::base_id);

		return( $def );
	}
  
	/** get column definition for \a detailsData column
	 * @param string|null $alias  alias for \a detailsData column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_detailsData(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_detailsFields::detailsData, "int", $alias,$this, false, "", false,table_t_detailsFieldKeys::detailsData);

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
		return array_merge( array('table_t_details' => new table_t_details()), parent::prototypeMap() );
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

  
//@class table_t_subdetailsFields

//namespace Database\Constants;
class table_t_subdetailsFields
{
	
	public const subdetails_id = 'subdetails_id';
	public const details_id = 'details_id';
	public const subDetailsData = 'subDetailsData';
}

  
//@class table_t_subdetailsFieldKeys

//namespace Database\Constants;
class table_t_subdetailsFieldKeys
{

	public const subdetails_id = 701;
	public const details_id = 702;
	public const subDetailsData = 703;
}


  

//@class table_t_subdetailsId
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_subdetails
 * @kphp-serializable
 */
class table_t_subdetailsId extends table_t_detailsId
{


	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 1
	 */
	public ?int $subdetails_id;

	/** @kphp-reserved-fields 2
	 */
      

	/** construct object
	 * @param string|null $alias
	 */
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->subdetails_id =  0 ;
	  	$this->details_id =  0 ;
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
  

	/**  @inheritDoc */
  /** return Column Definition array
  * @return \Sigmalab\Database\Core\IDBColumnDefinition[] items - object relation scheme
  */
	public function getColumnDefinition(): array
	{
		$columnDefinition = array();
		$columnDefinition[ table_t_subdetailsFields::subdetails_id ] = $this->tag_subdetails_id();
		$columnDefinition[ table_t_subdetailsFields::details_id ] = $this->tag_details_id();

		return( $columnDefinition );
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return table_t_subdetailsId
	 */
	public function gettable_t_subdetailsIdPrototype(?string $alias=null) : table_t_subdetailsId
	{
		return new table_t_subdetailsId($alias);
	}

	/** Gets prototype map for an object.
	*
	* array: table name => \Sigmalab\Database\Core\DBObject
	*
	* @return \Sigmalab\Database\Core\DBObject[]
	*/
	public function prototypeMap() : array
	{
		return array_merge( array('table_t_subdetailsId' => new table_t_subdetailsId()), parent::prototypeMap() );
	}

	//Foreign keys
    

	/** Foreign key for tag_details_id() as link to Database\table_t_details::tag_details_id()
	 * @param \Database\table_t_detailsId $proto foreign object prototype
	 * @return \Sigmalab\Database\Core\DBForeignKey
	 */
	public function key_details_id(?\Database\table_t_detailsId $proto=null) :\Sigmalab\Database\Core\DBForeignKey
	{
		if ( is_null($proto) ) $proto = new \Database\table_t_detailsId();
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
		/** @noinspection PhpParamsInspection */
		//kphp required strict types.
		return $this->key_details_id(instance_cast($proto, table_t_detailsId::class));
	}

   
	/** Create prototype of parent class.
	 * @return   table_t_detailsId
	*/
	public function parentPrototype() : ?\Sigmalab\Database\Core\IDataObject
	{
		return $this->gettable_t_detailsIdPrototype();
	}
        
}


//@class table_t_subdetails
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_subdetails
 * @kphp-serializable
 */
class table_t_subdetails extends table_t_details
{
	

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 6
	 */
	public ?int $subdetails_id;

	/** @kphp-reserved-fields 7
	 */
      

	/** 
	 * @access private
	 * @var int
	 * @kphp-serialized-field 8
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

  
//@class table_t_propertiesOneFields

//namespace Database\Constants;
class table_t_propertiesOneFields
{
	
	public const propertiesOne_id = 'propertiesOne_id';
	public const base_id = 'base_id';
	public const propertiesOneData = 'propertiesOneData';
}

  
//@class table_t_propertiesOneFieldKeys

//namespace Database\Constants;
class table_t_propertiesOneFieldKeys
{

	public const propertiesOne_id = 801;
	public const base_id = 802;
	public const propertiesOneData = 803;
}


  

//@class table_t_propertiesOneId
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_propertiesOne
 * @kphp-serializable
 */
class table_t_propertiesOneId extends table_t_baseId
{


	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 1
	 */
	public ?int $propertiesOne_id;

	/** @kphp-reserved-fields 2
	 */
      

	/** construct object
	 * @param string|null $alias
	 */
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->propertiesOne_id =  0 ;
	  	$this->base_id =  0 ;
		}

  
	public function createSelf():\Sigmalab\Database\Core\IDataObject
	{
		if ( get_class($this) !== __CLASS__) {
			\Sigmalab\Database\Core\DataSourceLogger::getInstance()->warning(get_class($this)."::createSelf() not implemented fallback to parent");
			return parent::createSelf();
		}
		return new self();
	}

	/** always contains \a "t_propertiesOne"
	 */
	public function table_name() :string
	{
		return( "t_propertiesOne" );
	}

	/** always contains \a "t_propertiesOne"
	*/
	public function table_description():string
	{
		return( "" );
	}
  
	/** returns primary key tag */
	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition
	{
		return $this->tag_propertiesOne_id() ;
	}

	/** get primary key value
	 * @return int primary key value with type as defined in database (value of \a propertiesOne_id )
	 * @noinspection PhpMissingParentCallCommonInspection
	 */
	public function primary_key_value():int
	{
		return( (int)$this->propertiesOne_id );
		
	}


  /** @inheritDoc */
	public function set_primary_key_value(int $value):void
	{
		$this->propertiesOne_id = $value;
	}

  
	/** set value to propertiesOne_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_propertiesOne_id(?int $value ) : bool
	{
		if ($this->propertiesOne_id === $value) return false;
		$this->setChangedValue(table_t_propertiesOneFields::propertiesOne_id, $this->propertiesOne_id);
		$this->propertiesOne_id = $value;
		return( true );
	}

	/** get value from \a propertiesOne_id  column
	 * @return int|null value
	 */
	public function get_propertiesOne_id()  :?int
	{
		return( $this->propertiesOne_id );
	}
  
	/** set value to base_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_base_id(?int $value ) : bool
	{
		if ($this->base_id === $value) return false;
		$this->setChangedValue(table_t_propertiesOneFields::base_id, $this->base_id);
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
  
	/** get column definition for \a propertiesOne_id column
	 * @param string|null $alias  alias for \a propertiesOne_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_propertiesOne_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_propertiesOneFields::propertiesOne_id, "int", $alias,$this, false, "", false,table_t_propertiesOneFieldKeys::propertiesOne_id);

		return( $def );
	}
  
	/** get column definition for \a base_id column
	 * @param string|null $alias  alias for \a base_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_base_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_propertiesOneFields::base_id, "int", $alias,$this, false, "", false,table_t_propertiesOneFieldKeys::base_id);

		return( $def );
	}
  

	/**  @inheritDoc */
  /** return Column Definition array
  * @return \Sigmalab\Database\Core\IDBColumnDefinition[] items - object relation scheme
  */
	public function getColumnDefinition(): array
	{
		$columnDefinition = array();
		$columnDefinition[ table_t_propertiesOneFields::propertiesOne_id ] = $this->tag_propertiesOne_id();
		$columnDefinition[ table_t_propertiesOneFields::base_id ] = $this->tag_base_id();

		return( $columnDefinition );
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return table_t_propertiesOneId
	 */
	public function gettable_t_propertiesOneIdPrototype(?string $alias=null) : table_t_propertiesOneId
	{
		return new table_t_propertiesOneId($alias);
	}

	/** Gets prototype map for an object.
	*
	* array: table name => \Sigmalab\Database\Core\DBObject
	*
	* @return \Sigmalab\Database\Core\DBObject[]
	*/
	public function prototypeMap() : array
	{
		return array_merge( array('table_t_propertiesOneId' => new table_t_propertiesOneId()), parent::prototypeMap() );
	}

	//Foreign keys
    

	/** Foreign key for tag_base_id() as link to Database\table_t_base::tag_base_id()
	 * @param \Database\table_t_baseId $proto foreign object prototype
	 * @return \Sigmalab\Database\Core\DBForeignKey
	 */
	public function key_base_id(?\Database\table_t_baseId $proto=null) :\Sigmalab\Database\Core\DBForeignKey
	{
		if ( is_null($proto) ) $proto = new \Database\table_t_baseId();
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
		/** @noinspection PhpParamsInspection */
		//kphp required strict types.
		return $this->key_base_id(instance_cast($proto, table_t_baseId::class));
	}

   
	/** Create prototype of parent class.
	 * @return   table_t_baseId
	*/
	public function parentPrototype() : ?\Sigmalab\Database\Core\IDataObject
	{
		return $this->gettable_t_baseIdPrototype();
	}
        
}


//@class table_t_propertiesOne
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_propertiesOne
 * @kphp-serializable
 */
class table_t_propertiesOne extends table_t_base
{
	

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 3
	 */
	public ?int $propertiesOne_id;

	/** @kphp-reserved-fields 4
	 */
      

	/** 
	 * @access private
	 * @var int
	 * @kphp-serialized-field 5
	 */
	public int $propertiesOneData;

	/** construct object
	 * @param string|null $alias
	*/
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->propertiesOne_id =  0 ;
	  	$this->base_id =  0 ;
	  	$this->propertiesOneData =  0 ;
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return table_t_propertiesOne
	 */
	public function gettable_t_propertiesOnePrototype(?string $alias=null) : table_t_propertiesOne
	{
		return new table_t_propertiesOne($alias);
	}

  
	/** returns primary key tag */
	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition
	{
		return $this->tag_propertiesOne_id() ;
	}

	/** get primary key value
	 * @return int primary key value with type as defined in database (value of \a propertiesOne_id )
	 * @noinspection PhpMissingParentCallCommonInspection
	 */
	public function primary_key_value():int
	{
		return( (int)$this->propertiesOne_id );
		
	}


  /** @inheritDoc */
	public function set_primary_key_value(int $value):void
	{
		$this->propertiesOne_id = $value;
	}

  
	public function createSelf():\Sigmalab\Database\Core\IDataObject
	{
		if ( get_class($this) !== __CLASS__) {
			\Sigmalab\Database\Core\DataSourceLogger::getInstance()->warning(get_class($this)."::createSelf() not implemented fallback to parent");
			return parent::createSelf();
		}
		return new self();
	}

	/** always contains \a "t_propertiesOne"
	 */
	public function table_name() :string
	{
		return( "t_propertiesOne" );
	}

	/** always contains \a "t_propertiesOne"
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
        		$columnDefinition[ table_t_propertiesOneFields::propertiesOne_id ] = $this->tag_propertiesOne_id();
		$columnDefinition[ table_t_propertiesOneFields::base_id ] = $this->tag_base_id();
		$columnDefinition[ table_t_propertiesOneFields::propertiesOneData ] = $this->tag_propertiesOneData();

		return( $columnDefinition );
	}

	/** get column definitions for foreign keys
	 * @return \Sigmalab\Database\Core\DBForeignKey[]
	 */
	public function getForeignKeys() : array
	{
		$keyDefs = array();
		$keyDefs[ table_t_propertiesOneFields::base_id ] = $this->key_base_id();
  
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
  
	/** set value to propertiesOne_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_propertiesOne_id(?int $value ) : bool
	{
		if ($this->propertiesOne_id === $value) return false;
		$this->setChangedValue(table_t_propertiesOneFields::propertiesOne_id, $this->propertiesOne_id);
		$this->propertiesOne_id = $value;
		return( true );
	}

	/** get value from \a propertiesOne_id  column
	 * @return int|null value
	 */
	public function get_propertiesOne_id()  :?int
	{
		return( $this->propertiesOne_id );
	}
  
	/** set value to base_id  column
	 * @param int|null $value  value
	 * @return bool true when value changed
	 */
	public function set_base_id(?int $value ) : bool
	{
		if ($this->base_id === $value) return false;
		$this->setChangedValue(table_t_propertiesOneFields::base_id, $this->base_id);
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
  
	/** set value to propertiesOneData  column
	 * @param int $value  value
	 * @return bool true when value changed
	 */
	public function set_propertiesOneData(int $value ) : bool
	{
		if ($this->propertiesOneData === $value) return false;
		$this->setChangedValue(table_t_propertiesOneFields::propertiesOneData, $this->propertiesOneData);
		$this->propertiesOneData = $value;
		return( true );
	}

	/** get value from \a propertiesOneData  column
	 * @return int value
	 */
	public function get_propertiesOneData()  :int
	{
		return( $this->propertiesOneData );
	}
  

	/** Import value (from sql )
	 * @param string $name
	 * @param mixed $value
	 */
  public function importValue(string $name, $value) :void {
    switch($name)
    {
      
        case table_t_propertiesOneFields::propertiesOne_id:
             
             $this->propertiesOne_id = (int)$value;
             return;
      
        case table_t_propertiesOneFields::base_id:
             
             $this->base_id = (int)$value;
             return;
      
        case table_t_propertiesOneFields::propertiesOneData:
             
             $this->propertiesOneData = (int)$value;
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
      
        case table_t_propertiesOneFieldKeys::propertiesOne_id:
             
             $this->propertiesOne_id = (int)$value;
             return true;
      
        case table_t_propertiesOneFieldKeys::base_id:
             
             $this->base_id = (int)$value;
             return true;
      
        case table_t_propertiesOneFieldKeys::propertiesOneData:
             
             $this->propertiesOneData = (int)$value;
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
      
        case table_t_propertiesOneFields::propertiesOne_id:
              $notNull_propertiesOne_id = (int)$this->propertiesOne_id;
             if ( $notNull_propertiesOne_id === ((int)$value)) return true;
             $this->setChangedValue($name, $this->propertiesOne_id);
             $this->propertiesOne_id = (int)$value;
             return true;
      
        case table_t_propertiesOneFields::base_id:
              $notNull_base_id = (int)$this->base_id;
             if ( $notNull_base_id === ((int)$value)) return true;
             $this->setChangedValue($name, $this->base_id);
             $this->base_id = (int)$value;
             return true;
      
        case table_t_propertiesOneFields::propertiesOneData:
              $notNull_propertiesOneData = (int)$this->propertiesOneData;
             if ( $notNull_propertiesOneData === ((int)$value)) return true;
             $this->setChangedValue($name, $this->propertiesOneData);
             $this->propertiesOneData = (int)$value;
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
      
        case table_t_propertiesOneFields::propertiesOne_id:
             return $this->propertiesOne_id;
      
        case table_t_propertiesOneFields::base_id:
             return $this->base_id;
      
        case table_t_propertiesOneFields::propertiesOneData:
             return $this->propertiesOneData;
      
    }
    return parent::getValue ($name);
  }

	//Tags
  
	/** get column definition for \a propertiesOne_id column
	 * @param string|null $alias  alias for \a propertiesOne_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_propertiesOne_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_propertiesOneFields::propertiesOne_id, "int", $alias,$this, false, "", false,table_t_propertiesOneFieldKeys::propertiesOne_id);

		return( $def );
	}
  
	/** get column definition for \a base_id column
	 * @param string|null $alias  alias for \a base_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_base_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_propertiesOneFields::base_id, "int", $alias,$this, false, "", false,table_t_propertiesOneFieldKeys::base_id);

		return( $def );
	}
  
	/** get column definition for \a propertiesOneData column
	 * @param string|null $alias  alias for \a propertiesOneData column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_propertiesOneData(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( table_t_propertiesOneFields::propertiesOneData, "int", $alias,$this, false, "", false,table_t_propertiesOneFieldKeys::propertiesOneData);

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
		return array_merge( array('table_t_propertiesOne' => new table_t_propertiesOne()), parent::prototypeMap() );
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

  
//@class table_t_propertiesTwoFields

//namespace Database\Constants;
class table_t_propertiesTwoFields
{
	
	public const propertiesTwo_id = 'propertiesTwo_id';
	public const base_id = 'base_id';
	public const propertiesTwoData = 'propertiesTwoData';
}

  
//@class table_t_propertiesTwoFieldKeys

//namespace Database\Constants;
class table_t_propertiesTwoFieldKeys
{

	public const propertiesTwo_id = 901;
	public const base_id = 902;
	public const propertiesTwoData = 903;
}


  

//@class table_t_propertiesTwoId
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_propertiesTwo
 * @kphp-serializable
 */
class table_t_propertiesTwoId extends table_t_baseId
{


	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 1
	 */
	public ?int $propertiesTwo_id;

	/** @kphp-reserved-fields 2
	 */
      

	/** construct object
	 * @param string|null $alias
	 */
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->propertiesTwo_id =  0 ;
	  	$this->base_id =  0 ;
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
  

	/**  @inheritDoc */
  /** return Column Definition array
  * @return \Sigmalab\Database\Core\IDBColumnDefinition[] items - object relation scheme
  */
	public function getColumnDefinition(): array
	{
		$columnDefinition = array();
		$columnDefinition[ table_t_propertiesTwoFields::propertiesTwo_id ] = $this->tag_propertiesTwo_id();
		$columnDefinition[ table_t_propertiesTwoFields::base_id ] = $this->tag_base_id();

		return( $columnDefinition );
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return table_t_propertiesTwoId
	 */
	public function gettable_t_propertiesTwoIdPrototype(?string $alias=null) : table_t_propertiesTwoId
	{
		return new table_t_propertiesTwoId($alias);
	}

	/** Gets prototype map for an object.
	*
	* array: table name => \Sigmalab\Database\Core\DBObject
	*
	* @return \Sigmalab\Database\Core\DBObject[]
	*/
	public function prototypeMap() : array
	{
		return array_merge( array('table_t_propertiesTwoId' => new table_t_propertiesTwoId()), parent::prototypeMap() );
	}

	//Foreign keys
    

	/** Foreign key for tag_base_id() as link to Database\table_t_base::tag_base_id()
	 * @param \Database\table_t_baseId $proto foreign object prototype
	 * @return \Sigmalab\Database\Core\DBForeignKey
	 */
	public function key_base_id(?\Database\table_t_baseId $proto=null) :\Sigmalab\Database\Core\DBForeignKey
	{
		if ( is_null($proto) ) $proto = new \Database\table_t_baseId();
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
		/** @noinspection PhpParamsInspection */
		//kphp required strict types.
		return $this->key_base_id(instance_cast($proto, table_t_baseId::class));
	}

   
	/** Create prototype of parent class.
	 * @return   table_t_baseId
	*/
	public function parentPrototype() : ?\Sigmalab\Database\Core\IDataObject
	{
		return $this->gettable_t_baseIdPrototype();
	}
        
}


//@class table_t_propertiesTwo
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_propertiesTwo
 * @kphp-serializable
 */
class table_t_propertiesTwo extends table_t_base
{
	

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 3
	 */
	public ?int $propertiesTwo_id;

	/** @kphp-reserved-fields 4
	 */
      

	/** 
	 * @access private
	 * @var int
	 * @kphp-serialized-field 5
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

  
//@class DataNotNullableFields

//namespace Database\Constants;
class DataNotNullableFields
{
	
	public const dataNotNullableId = 'dataNotNullableId';
	public const valueA = 'valueA';
	public const valueB = 'valueB';
}

  
//@class DataNotNullableFieldKeys

//namespace Database\Constants;
class DataNotNullableFieldKeys
{

	public const dataNotNullableId = 1001;
	public const valueA = 1002;
	public const valueB = 1003;
}


  

//@class DataNotNullableId
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_dataNotNullable
 * @kphp-serializable
 */
class DataNotNullableId extends \Sigmalab\Database\Core\DBObject
{


	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 1
	 */
	public ?int $dataNotNullableId;

	/** construct object
	 * @param string|null $alias
	 */
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->dataNotNullableId =  0 ;
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
  
	/** get column definition for \a dataNotNullableId column
	 * @param string|null $alias  alias for \a dataNotNullableId column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_dataNotNullableId(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( DataNotNullableFields::dataNotNullableId, "int", $alias,$this, false, "", false,DataNotNullableFieldKeys::dataNotNullableId);

		return( $def );
	}
  

	/**  @inheritDoc */
  /** return Column Definition array
  * @return \Sigmalab\Database\Core\IDBColumnDefinition[] items - object relation scheme
  */
	public function getColumnDefinition(): array
	{
		$columnDefinition = array();
		$columnDefinition[ DataNotNullableFields::dataNotNullableId ] = $this->tag_dataNotNullableId();

		return( $columnDefinition );
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return DataNotNullableId
	 */
	public function getDataNotNullableIdPrototype(?string $alias=null) : DataNotNullableId
	{
		return new DataNotNullableId($alias);
	}

	/** Gets prototype map for an object.
	*
	* array: table name => \Sigmalab\Database\Core\DBObject
	*
	* @return \Sigmalab\Database\Core\DBObject[]
	*/
	public function prototypeMap() : array
	{
		return array_merge( array('DataNotNullableId' => new DataNotNullableId()), parent::prototypeMap() );
	}

	//Foreign keys
    
}


//@class DataNotNullable
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_dataNotNullable
 * @kphp-serializable
 */
class DataNotNullable extends \Sigmalab\Database\Core\DBObject
{
	

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 1
	 */
	public ?int $dataNotNullableId;

	/** 
	 * @access private
	 * @var string
	 * @kphp-serialized-field 2
	 */
	public string $valueA;

	/** 
	 * @access private
	 * @var string
	 * @kphp-serialized-field 3
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

  
//@class DataDateTimeFields

//namespace Database\Constants;
class DataDateTimeFields
{
	
	public const datatime_id = 'datatime_id';
	public const value = 'value';
}

  
//@class DataDateTimeFieldKeys

//namespace Database\Constants;
class DataDateTimeFieldKeys
{

	public const datatime_id = 1101;
	public const value = 1102;
}


  

//@class DataDateTimeId
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_datatime
 * @kphp-serializable
 */
class DataDateTimeId extends \Sigmalab\Database\Core\DBObject
{


	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 1
	 */
	public ?int $datatime_id;

	/** construct object
	 * @param string|null $alias
	 */
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		
	  	$this->datatime_id =  0 ;
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
  
	/** get column definition for \a datatime_id column
	 * @param string|null $alias  alias for \a datatime_id column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_datatime_id(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( DataDateTimeFields::datatime_id, "int", $alias,$this, false, "", false,DataDateTimeFieldKeys::datatime_id);

		return( $def );
	}
  

	/**  @inheritDoc */
  /** return Column Definition array
  * @return \Sigmalab\Database\Core\IDBColumnDefinition[] items - object relation scheme
  */
	public function getColumnDefinition(): array
	{
		$columnDefinition = array();
		$columnDefinition[ DataDateTimeFields::datatime_id ] = $this->tag_datatime_id();

		return( $columnDefinition );
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return DataDateTimeId
	 */
	public function getDataDateTimeIdPrototype(?string $alias=null) : DataDateTimeId
	{
		return new DataDateTimeId($alias);
	}

	/** Gets prototype map for an object.
	*
	* array: table name => \Sigmalab\Database\Core\DBObject
	*
	* @return \Sigmalab\Database\Core\DBObject[]
	*/
	public function prototypeMap() : array
	{
		return array_merge( array('DataDateTimeId' => new DataDateTimeId()), parent::prototypeMap() );
	}

	//Foreign keys
    
}


//@class DataDateTime
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_datatime
 * @kphp-serializable
 */
class DataDateTime extends \Sigmalab\Database\Core\DBObject
{
	

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 1
	 */
	public ?int $datatime_id;

	/** 
	 * @access private
	 * @var int|null
	 * @kphp-serialized-field 2
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

  

    

//@class DataDictionaryRelation

/** \ingroup table_relations
   Relation adapter for loading Dictionary
   objects as members of  Data
*/
class DataDictionaryRelation extends \Sigmalab\Database\Relations\DBRelationAdapter
{
	/** @inheritDoc */
	protected function getObject( int $objectId, int $memberId ):\Sigmalab\Database\Core\DBObject
	{
		$obj = new table_t_link;

		$obj->data_id = $objectId;
		$obj->dictionary_id = $memberId;
		return( $obj );
	}

	/** @inheritDoc */
	protected function getDataObject(int $objectId ) : \Sigmalab\Database\Core\DBObject
	{
		$obj = new \Database\Data();
		$obj->data_id = $objectId;
		return( $obj );
	}
	/** @inheritDoc */
	protected function getMemberObject(int $memberId ): \Sigmalab\Database\Core\DBObject
	{
		$obj = new \Database\Dictionary();
		$obj->dictionary_id = $memberId;
		return( $obj );
	}
	/** returns foreing keys for linking
	 */
	protected function getForeignKeys()
	{
		return( [
			table_t_linkFields::data_id,
			table_t_linkFields::dictionary_id
		] );
	}

	/** select Database\Dictionary objects by Data primary key ID.
	 * @param int $objectID  primary key of Data.
	 * @param \Sigmalab\Database\Core\IDataSource $ds
	 * @return \Database\Dictionary[]  collection ob member objects.
	 * @throws \Sigmalab\Database\DatabaseException
	*/
	public function selectDictionarys( int $objectID, \Sigmalab\Database\Core\IDataSource $ds ):array
	{
		//return $this->select( $objectID, $ds);
		//KPHP mode
		return array_map(function (\Sigmalab\Database\Core\IDataObject $x) {
			return instance_cast($x, \Database\Dictionary::class);},
			$this->select( $objectID, $ds));
	}
}

  

//@class DictionaryDataRelation

/** \ingroup table_relations
   Relation adapter for loading Data
   objects as members of  Dictionary
*/
class DictionaryDataRelation extends \Sigmalab\Database\Relations\DBRelationAdapter
{
	/** @inheritDoc */
	protected function getObject( int $objectId, int $memberId ):\Sigmalab\Database\Core\DBObject
	{
		$obj = new table_t_link;

		$obj->dictionary_id = $objectId;
		$obj->data_id = $memberId;
		return( $obj );
	}

	/** @inheritDoc */
	protected function getDataObject(int $objectId ) : \Sigmalab\Database\Core\DBObject
	{
		$obj = new \Database\Dictionary();
		$obj->dictionary_id = $objectId;
		return( $obj );
	}
	/** @inheritDoc */
	protected function getMemberObject(int $memberId ): \Sigmalab\Database\Core\DBObject
	{
		$obj = new \Database\Data();
		$obj->data_id = $memberId;
		return( $obj );
	}
	/** returns foreing keys for linking
	 */
	protected function getForeignKeys()
	{
		return( [
			table_t_linkFields::dictionary_id,
			table_t_linkFields::data_id
		] );
	}

	/** select Database\Data objects by Dictionary primary key ID.
	 * @param int $objectID  primary key of Dictionary.
	 * @param \Sigmalab\Database\Core\IDataSource $ds
	 * @return \Database\Data[]  collection ob member objects.
	 * @throws \Sigmalab\Database\DatabaseException
	*/
	public function selectDatas( int $objectID, \Sigmalab\Database\Core\IDataSource $ds ):array
	{
		//return $this->select( $objectID, $ds);
		//KPHP mode
		return array_map(function (\Sigmalab\Database\Core\IDataObject $x) {
			return instance_cast($x, \Database\Data::class);},
			$this->select( $objectID, $ds));
	}
}

  

    

//@class AnotherDataDictionaryRelation

/** \ingroup table_relations
   Relation adapter for loading Dictionary
   objects as members of  Data
*/
class AnotherDataDictionaryRelation extends \Sigmalab\Database\Relations\DBRelationAdapter
{
	/** @inheritDoc */
	protected function getObject( int $objectId, int $memberId ):\Sigmalab\Database\Core\DBObject
	{
		$obj = new Another;

		$obj->owner_id = $objectId;
		$obj->child_id = $memberId;
		return( $obj );
	}

	/** @inheritDoc */
	protected function getDataObject(int $objectId ) : \Sigmalab\Database\Core\DBObject
	{
		$obj = new \Database\Data();
		$obj->data_id = $objectId;
		return( $obj );
	}
	/** @inheritDoc */
	protected function getMemberObject(int $memberId ): \Sigmalab\Database\Core\DBObject
	{
		$obj = new \Database\Dictionary();
		$obj->dictionary_id = $memberId;
		return( $obj );
	}
	/** returns foreing keys for linking
	 */
	protected function getForeignKeys()
	{
		return( [
			AnotherFields::owner_id,
			AnotherFields::child_id
		] );
	}

	/** select Database\Dictionary objects by Data primary key ID.
	 * @param int $objectID  primary key of Data.
	 * @param \Sigmalab\Database\Core\IDataSource $ds
	 * @return \Database\Dictionary[]  collection ob member objects.
	 * @throws \Sigmalab\Database\DatabaseException
	*/
	public function selectDictionarys( int $objectID, \Sigmalab\Database\Core\IDataSource $ds ):array
	{
		//return $this->select( $objectID, $ds);
		//KPHP mode
		return array_map(function (\Sigmalab\Database\Core\IDataObject $x) {
			return instance_cast($x, \Database\Dictionary::class);},
			$this->select( $objectID, $ds));
	}
}

  