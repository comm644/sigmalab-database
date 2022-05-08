<?php
namespace Database;

/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table t_propertiesOne
 */
class table_t_propertiesOneId extends table_t_baseId
{


	/** 
	 * @access private
	 * @var int|null
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


