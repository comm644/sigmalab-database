<?php
namespace Database;

/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_data
 */
class DataId extends \Sigmalab\Database\Core\DBObject
{


	/** 
	 * @access private
	 * @var int|null
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


