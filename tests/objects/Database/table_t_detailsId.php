<?php
namespace Database;

/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_details
 */
class table_t_detailsId extends table_t_baseId
{


	/** 
	 * @access private
	 * @var int|null
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


