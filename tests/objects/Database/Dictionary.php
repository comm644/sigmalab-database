<?php
namespace Database;

/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_dictionary
 */
class Dictionary extends \Sigmalab\Database\Core\DBObject
{
	

	/** 
	 * @access private
	 * @var int|null
	 */
	public ?int $dictionary_id;

	/** 
	 * @access private
	 * @var string|null
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

  
