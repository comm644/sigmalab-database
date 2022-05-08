<?php
namespace Database;

/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_link
 */
class table_t_linkId extends \Sigmalab\Database\Core\DBObject
{


	/** 
	 * @access private
	 * @var int|null
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


