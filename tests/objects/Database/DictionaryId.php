<?php
namespace Database;

/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_dictionary
 */
class DictionaryId extends \Sigmalab\Database\Core\DBObject
{


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


