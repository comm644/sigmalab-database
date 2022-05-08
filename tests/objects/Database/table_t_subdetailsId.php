<?php
namespace Database;

/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_subdetails
 */
class table_t_subdetailsId extends table_t_detailsId
{


	/** 
	 * @access private
	 * @var int|null
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


