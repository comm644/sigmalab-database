<?php
namespace Database;

/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_dataNotNullable
 */
class DataNotNullableId extends \Sigmalab\Database\Core\DBObject
{


	/** 
	 * @access private
	 * @var int|null
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


