<?php
namespace Database;

/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_datatime
 */
class DataDateTimeId extends \Sigmalab\Database\Core\DBObject
{


	/** 
	 * @access private
	 * @var int|null
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


