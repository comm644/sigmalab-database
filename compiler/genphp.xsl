<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                version="1.0" xmlns:xls="http://www.w3.org/1999/XSL/Transform"
                xmlns:xs="http://www.w3.org/1999/XSL/Transform">

  <xsl:output method="text"
    encoding="utf-8"
    />
  <xsl:variable name="baseclass" select="//baseclass/@name"/>
  <xsl:variable name="prefix" select="//prefix/@name"/>

  <xsl:variable name="eol">
    <xsl:text>
</xsl:text>
</xsl:variable>


  <xsl:template match="/">
    <xsl:apply-templates select="database"/>
    <xsl:apply-templates select="database/include"/>
  </xsl:template>

  <xsl:template match="database">
<xsl:text>&lt;?php</xsl:text>
#ifndef KPHP
/** @noinspection PhpMultipleClassesDeclarationsInOneFile */
#endif

/*
 *
 *  DONT EDIT THIS FILE. AUTO CREATED BY mkobject.xsl
 *
 *  File: <!-- <xsl:value-of select="$file"/> -->
 */

namespace <xsl:value-of select="/database/namespace/@name"/>;
    <xsl:apply-templates select="database/include"/>

    <xsl:apply-templates select="table"/>
    <xsl:apply-templates select="table[count(@pure-class)!=0]" >
      <xsl:with-param name="pure" select="'yes'"/>
    </xsl:apply-templates>
  <xsl:apply-templates select="table[@type='relation']" mode="relation"/>
  <xsl:apply-templates select="table[count(@enum)!=0]" mode="enum"/>

</xsl:template>

<xsl:template match="table" >
  <xsl:param name="pure" select="'no'"/>
  <xsl:variable name="class">
    <xsl:choose>
      <xsl:when test="$pure='yes' and count( @pure-class ) != 0"><xsl:value-of select="@pure-class"/></xsl:when>
      <xsl:when test="count( @class ) != 0"><xsl:value-of select="@class"/></xsl:when>
      <xsl:otherwise><xsl:value-of select="$prefix"/><xsl:value-of select="@name"/></xsl:otherwise>
    </xsl:choose>
  </xsl:variable>
  <xsl:variable name="pkname" select="column[@primary-key='yes']/@name"/>
  <xsl:variable name="table-name" select="@name"/>
  <xsl:variable name="table" select="."/>
  <xsl:variable name="table-index" select="position()"/>

  <xsl:variable name="foreign-keys" select="column[count(@foreign-key) !=0]"/>
  <xsl:variable name="parent-key" select="./column[@parent-key = 'yes']"/>
  <xsl:variable name="parent-key2" select="//table[@name = $parent-key/@foreign-table]/column[@parent-key = 'yes']"/>
  <xsl:variable name="parent-key3" select="//table[@name = $parent-key2/@foreign-table]/column[@parent-key = 'yes']"/>
  <xsl:variable name="use-baseclass">
    <xsl:choose>
      <xsl:when test="@baseclass != '' and $pure='no'"><xsl:value-of select="@baseclass"/></xsl:when>
      <xsl:otherwise><xsl:value-of select="$baseclass"/></xsl:otherwise>
    </xsl:choose>
  </xsl:variable>
    <xsl:variable name="use-baseclass-ns">
      <xsl:value-of select="@baseclass-ns"/>
      <xsl:if test="@baseclass-ns != ''">\</xsl:if>
    </xsl:variable>
<xsl:message >
  count: <xsl:value-of select="@name"/> -- <xsl:value-of select="count($parent-key)" /> -- <xsl:value-of select="count($parent-key2)" />
</xsl:message>
//@class <xsl:value-of select="$class"/>Fields

//namespace <xsl:value-of select="/database/namespace/@name"/>\Constants;
class <xsl:value-of select="$class"/>Fields<xsl:text/>
{
	<xsl:for-each select="column">
	public const <xsl:value-of select="@name"/> = '<xsl:value-of select="@name"/>';<xsl:text/>
</xsl:for-each>
}

  <xsl:variable name="key-start-index" select="
        count($parent-key) * count(//table[@name = $parent-key/@foreign-table]/column)
        + count($parent-key2) * count(//table[@name = $parent-key2/@foreign-table]/column)
        + count($parent-key3) * count(//table[@name = $parent-key3/@foreign-table]/column)
"/>
//@class <xsl:value-of select="$class"/>FieldKeys

//namespace <xsl:value-of select="/database/namespace/@name"/>\Constants;
class <xsl:value-of select="$class"/>FieldKeys<xsl:text/>
{
<xsl:for-each select="column">
	public const <xsl:value-of select="@name"/> = <xsl:value-of select="position()+$table-index*100"/>;<xsl:text/>
</xsl:for-each>
}


  <xsl:if test="$pure !='yes'">

//@class <xsl:value-of select="$class"/>Id
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table <xsl:value-of select="@name"/>
 * @kphp-serializable
 */
class <xsl:value-of select="$class"/>Id extends <xsl:text/>
  <xsl:choose>
    <xsl:when test="@baseclass = '\Sigmalab\Database\Core\DBObject'"><xsl:value-of select="$use-baseclass"/></xsl:when>
    <xsl:when test="count(@baseclass) !=0 ">
      <xsl:value-of select="$use-baseclass-ns"/><xsl:value-of select="$use-baseclass"/><xsl:text>Id</xsl:text>
    </xsl:when>
    <xsl:otherwise>\Sigmalab\Database\Core\DBObject</xsl:otherwise>
  </xsl:choose>
{
<xsl:text/>
  <xsl:variable name="id-columns" select="column[@primary-key='yes' or @foreign-key='yes' or @parent-key='yes']"/>
  <xsl:apply-templates select="$id-columns" mode="create"/>

	/** construct object
	 * @param string|null $alias
	 */
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		<xsl:apply-templates select="$id-columns" mode="init"/>
		}

  <xs:apply-templates select="." mode="insert_table_name"/>
  <xsl:apply-templates select="." mode="set_primary_key_value">
    <xsl:with-param name="class" select="$class"/>
  </xsl:apply-templates>
  <xsl:apply-templates select="$id-columns" mode="insert-get-set">
    <xsl:with-param name="class" select="$class"/>
  </xsl:apply-templates>
  <xsl:apply-templates select="$id-columns" mode="insert-tags">
    <xsl:with-param name="class" select="$class"/>
  </xsl:apply-templates>

	/**  @inheritDoc */
  /** return Column Definition array
  * @return \Sigmalab\Database\Core\IDBColumnDefinition[] items - object relation scheme
  */
	public function getColumnDefinition():array
	{
		$columnDefinition = array();
<xsl:text/>
		<xsl:apply-templates select="$id-columns" mode="define">
      <xsl:with-param name="table" select="@name"/>
      <xsl:with-param name="class" select="$class"/>
    </xsl:apply-templates>
		return( $columnDefinition );
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return <xsl:value-of select="$class"/>Id
	 */
	public function get<xsl:value-of select="$class"/>IdPrototype(?string $alias=null) : <xsl:value-of select="$class"/>Id
	{
		return new <xsl:value-of select="$class"/>Id($alias);
	}

	/** Gets prototype map for an object.
	*
	* array: table name => \Sigmalab\Database\Core\DBObject
	*
	* @return \Sigmalab\Database\Core\DBObject[]
	*/
	public function prototypeMap() : array
	{
		return array_merge( array('<xsl:value-of select="$class"/>Id' =&gt; new <xsl:value-of select="$class"/>Id()), parent::prototypeMap() );
	}

	//Foreign keys
    <xsl:for-each select="$parent-key">
      <xsl:variable name="owner-tag">$this->tag_<xsl:value-of select="@name"/>()</xsl:variable>
      <xsl:variable name="foreign-tag">$proto->tag_<xsl:value-of select="@foreign-key"/>()</xsl:variable>
      <xsl:variable name="foreign-class">
        <xsl:apply-templates select="." mode="get-foreign-class">
          <xsl:with-param name="prefix" select="$prefix"/>
          <xsl:with-param name="table-name" select="$table-name"/>
        </xsl:apply-templates>
       </xsl:variable>
      <xsl:variable name="foreign-class-ns">
        <xsl:choose>
          <xsl:when test="count(@class-ns)=0">
            <xsl:value-of select="/database/namespace/@name"/><xsl:text>\</xsl:text>
          </xsl:when>
          <xsl:otherwise>
            <xsl:value-of select="@class-ns"/>
          </xsl:otherwise>
        </xsl:choose>
        <xsl:if test="@class-ns !=''">\</xsl:if>
      </xsl:variable>

	/** Foreign key for tag_<xsl:value-of select="@name"/>() as link to <xsl:value-of select="$foreign-class-ns"/><xsl:value-of select="$foreign-class"/>::tag_<xsl:value-of select="@foreign-key"/>()
	 * @param \<xsl:value-of select="$foreign-class-ns"/><xsl:value-of select="$foreign-class"/>Id $proto foreign object prototype
	 * @return \Sigmalab\Database\Core\DBForeignKey
	 */
	public function key_<xsl:value-of select="@name"/>(?\<xsl:value-of select="$foreign-class-ns"/>
      <xsl:value-of select="$foreign-class"/>Id $proto=null) :\Sigmalab\Database\Core\DBForeignKey
	{
		if ( is_null($proto) ) $proto = new \<xsl:value-of select="$foreign-class-ns"/><xsl:value-of select="$foreign-class"/>Id();
		$def = new \Sigmalab\Database\Core\DBForeignKey( <xsl:value-of select="$owner-tag"/>, <xsl:value-of select="$foreign-tag"/> );
		return( $def );
	}
      <xsl:if test="@parent-key='yes'">
	public function set_parent_key_value(int $value){
		$this-&gt;set_<xsl:value-of select="@name"/>($value);
	}

	public function get_parent_key_value():?int{
		return $this-&gt;get_<xsl:value-of select="@name"/>();
	}

	/** Get foreign key of parent class
	* @param \Sigmalab\Database\Core\IDataObject|null $proto foreign object prototype
	* @return \Sigmalab\Database\Core\DBForeignKey|null
	*/
	public function getParentKey(?\Sigmalab\Database\Core\IDataObject $proto=NULL): ?\Sigmalab\Database\Core\DBForeignKey
	{
		if ( !$proto ) {
			return $this-&gt;key_<xsl:value-of select="@name"/>(null);
		}
		/** @noinspection PhpParamsInspection */
		//kphp required strict types.
		return $this-&gt;key_<xsl:value-of select="@name"/>(instance_cast($proto, <xsl:value-of select="$foreign-class"/>Id::class));
	}

   <xsl:if test="$baseclass != $use-baseclass">
	/** Create prototype of parent class.
	 * @return   <xsl:value-of select="$use-baseclass-ns"/><xsl:value-of select="$use-baseclass"/>Id
	*/
	public function parentPrototype() : ?\Sigmalab\Database\Core\IDataObject
	{
		return $this->get<xsl:value-of select="$use-baseclass"/>IdPrototype();
	}
        </xsl:if>

      </xsl:if>
    </xsl:for-each>
}
</xsl:if>

//@class <xsl:value-of select="$class"/>
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** \ingroup table_objects
 *
 * Class describes object-table mapping information for table <xsl:value-of select="@name"/>
 * @kphp-serializable
 */
class <xsl:value-of select="$class"/> extends <xsl:text/>
  <xsl:choose>
    <xsl:when test="$pure='yes'">\Sigmalab\Database\Core\DBObject</xsl:when>
    <xsl:otherwise>
      <xsl:value-of select="$use-baseclass-ns"/><xsl:value-of select="$use-baseclass"/>
    </xsl:otherwise>
  </xsl:choose>
{
	<xsl:apply-templates select="column" mode="create">
<!--    <xsl:with-param name="start-index" select="count(//table[@name = $parent-key/@foreign-table]/column[count(@parent-key) = 0])"/>-->
    <xsl:with-param name="start-index" select="
        count($parent-key) * count(//table[@name = $parent-key/@foreign-table]/column)
        + count($parent-key2) * count(//table[@name = $parent-key2/@foreign-table]/column)
        + count($parent-key3) * count(//table[@name = $parent-key3/@foreign-table]/column)
"/>
    <xsl:with-param name="pure" select="$pure"/>
  </xsl:apply-templates>

	/** construct object
	 * @param string|null $alias
	*/
	public function __construct(?string $alias=null)
	{
		parent::__construct();
		if ($alias) $this->setTableAlias($alias);
		<xsl:apply-templates select="column" mode="init"/>
	}

	/** Gets parent prototype.
	 * @param string|null $alias
	 * @return <xsl:value-of select="$class"/>
	 */
	public function get<xsl:value-of select="$class"/>Prototype(?string $alias=null) : <xsl:value-of select="$class"/>
	{
		return new <xsl:value-of select="$class"/>($alias);
	}

  <xsl:apply-templates select="." mode="set_primary_key_value">
    <xsl:with-param name="class" select="$class"/>
  </xsl:apply-templates>

  <xsl:apply-templates select="." mode="insert_table_name"/>
	/** @inheritDoc */
  /** return Column Definition array
  * @return \Sigmalab\Database\Core\IDBColumnDefinition[] items - object relation scheme
  */
	public function getColumnDefinition():array
	{
		$columnDefinition = array();
        <xsl:text/>
		<xsl:apply-templates select="column" mode="define">
          <xsl:with-param name="table" select="@name"/>
          <xsl:with-param name="class" select="$class"/>
        </xsl:apply-templates>
		return( $columnDefinition );
	}

	/** get column definitions for foreign keys
	 * @return \Sigmalab\Database\Core\DBForeignKey[]
	 */
	public function getForeignKeys() : array
	{
		$keyDefs = array();
		<xsl:apply-templates select="$foreign-keys" mode="define-fk">
      <xsl:with-param name="class" select="$class"/>
    </xsl:apply-templates>
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
  <xsl:apply-templates select="column" mode="insert-get-set">
    <xsl:with-param name="class" select="$class"/>
  </xsl:apply-templates>

	/** Import value (from sql )
	 * @param string $name
	 * @param mixed $value
	 */
  public function importValue(string $name, $value) :void {
    switch($name)
    {
      <xsl:for-each select="column">
        case <xsl:value-of select="$class"/>Fields::<xsl:value-of select="@name"/>:
             <xsl:if test="@default = 'null'">
               <xsl:text/>if ( $value === null ) $this-><xsl:value-of select="@name"/> = null; else <xsl:text/>
             </xsl:if>
             $this-><xsl:value-of select="@name"/> = (<xsl:apply-templates select="." mode="get-type-cast"/>)$value;
             return;
      </xsl:for-each>
    }
    parent::importValue($name, $value );
  }

	/** Import value (from sql )
	 * @param mixed $value
	 */
  public function importValueByKey(int $key, $value) :bool {
    switch($key)
    {
      <xsl:for-each select="column">
        case <xsl:value-of select="$class"/>FieldKeys::<xsl:value-of select="@name"/>:
             <xsl:if test="@default = 'null'">
               <xsl:text/>if ( $value === null ) $this-><xsl:value-of select="@name"/> = null; else <xsl:text/>
             </xsl:if>
             $this-><xsl:value-of select="@name"/> = (<xsl:apply-templates select="." mode="get-type-cast"/>)$value;
             return true;
      </xsl:for-each>
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
      <xsl:for-each select="column">
        case <xsl:value-of select="$class"/>Fields::<xsl:value-of select="@name"/>:
              $notNull_<xsl:value-of select="@name"/> = (<xsl:apply-templates select="." mode="get-type-cast"/>)$this-><xsl:value-of select="@name"/>;
             if ( $notNull_<xsl:value-of select="@name"/> === ((<xsl:apply-templates select="." mode="get-type-cast"/>)$value)) return true;
             $this->setChangedValue($name, $this-><xsl:value-of select="@name"/>);
             $this-><xsl:value-of select="@name"/> = (<xsl:apply-templates select="." mode="get-type-cast"/>)$value;
             return true;
      </xsl:for-each>
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
      <xsl:for-each select="column">
        case <xsl:value-of select="$class"/>Fields::<xsl:value-of select="@name"/>:
             return $this-><xsl:value-of select="@name"/>;
      </xsl:for-each>
    }
    return parent::getValue ($name);
  }

	//Tags
  <xsl:apply-templates select="column" mode="insert-tags">
    <xsl:with-param name="class" select="$class"/>
  </xsl:apply-templates>

	/** Gets prototype map for an object.
	*
	* array: table name => \Sigmalab\Database\Core\DBObject
	*
	* @return \Sigmalab\Database\Core\DBObject[]
	*/
	public function prototypeMap() : array
	{
		return array_merge( array('<xsl:value-of select="$class"/>' =&gt; new <xsl:value-of select="$class"/>()), parent::prototypeMap() );
	}

  <xsl:if test="count($foreign-keys) != 0">
	//Foreign keys
    <xsl:for-each select="$foreign-keys">
      <xsl:variable name="owner-tag">$this->tag_<xsl:value-of select="@name"/>()</xsl:variable>
      <xsl:variable name="foreign-tag">$proto->tag_<xsl:value-of select="@foreign-key"/>()</xsl:variable>
      <xsl:variable name="foreign-class">
        <xsl:apply-templates select="." mode="get-foreign-class">
          <xsl:with-param name="prefix" select="$prefix"/>
          <xsl:with-param name="table-name" select="$table-name"/>
        </xsl:apply-templates>
       </xsl:variable>
      <xsl:variable name="foreign-class-ns">
        <xsl:choose>
          <xsl:when test="count(@class-ns)=0">
            <xsl:value-of select="/database/namespace/@name"/><xsl:text>\</xsl:text>
          </xsl:when>
          <xsl:otherwise>
            <xsl:value-of select="@class-ns"/>
          </xsl:otherwise>
        </xsl:choose>
        <xsl:if test="@class-ns !=''">\</xsl:if>
      </xsl:variable>

	/** Foreign key for tag_<xsl:value-of select="@name"/>() as link to <xsl:value-of select="$foreign-class-ns"/><xsl:value-of select="$foreign-class"/>::tag_<xsl:value-of select="@foreign-key"/>()
	 * @param \<xsl:value-of select="$foreign-class-ns"/><xsl:value-of select="$foreign-class"/> $proto foreign object prototype
	 * @return \Sigmalab\Database\Core\DBForeignKey
	 */
	public function key_<xsl:value-of select="@name"/>(?\<xsl:value-of select="$foreign-class-ns"/>
      <xsl:value-of select="$foreign-class"/> $proto=null) :\Sigmalab\Database\Core\DBForeignKey
	{
		if ( is_null($proto) ) $proto = new \<xsl:value-of select="$foreign-class-ns"/><xsl:value-of select="$foreign-class"/>();
		$def = new \Sigmalab\Database\Core\DBForeignKey( <xsl:value-of select="$owner-tag"/>, <xsl:value-of select="$foreign-tag"/> );
		return( $def );
	}
      <xsl:if test="@parent-key='yes'">
	public function set_parent_key_value(int $value){
		$this-&gt;set_<xsl:value-of select="@name"/>($value);
	}

	public function get_parent_key_value():?int{
		return $this-&gt;get_<xsl:value-of select="@name"/>();
	}

	/** Get foreign key of parent class
	* @param \Sigmalab\Database\Core\IDataObject|null $proto foreign object prototype
	* @return \Sigmalab\Database\Core\DBForeignKey|null
	*/
	public function getParentKey(?\Sigmalab\Database\Core\IDataObject $proto=NULL): ?\Sigmalab\Database\Core\DBForeignKey
	{
		if ( !$proto ) {
			return $this-&gt;key_<xsl:value-of select="@name"/>(null);
		}
		else if ( $proto instanceof <xsl:value-of select="$foreign-class"/> ) {
			return $this-&gt;key_<xsl:value-of select="@name"/>($proto);
		}
		return null;
	}

        <xsl:if test="$baseclass != $use-baseclass">
	/** Create prototype of parent class.
	 * @return  \Sigmalab\Database\Core\IDataObject|null
	*/
	public function parentPrototype() : ?\Sigmalab\Database\Core\IDataObject
	{
		return $this->get<xsl:value-of select="$use-baseclass"/>Prototype();
	}
        </xsl:if>

      </xsl:if>
    </xsl:for-each>
  </xsl:if>

    <xsl:variable name="loaders" select="$foreign-keys[count(@member) != 0 and  count( @class ) != 0]"/>
    <xsl:if test="count($loaders) != 0">
#ifndef KPHP
	// Loaders
        <xsl:for-each select="$loaders">
	/** load <xsl:value-of select="@member"/> specified by foreign key <xsl:value-of select="@name"/>
	* @param $ds \Sigmalab\Database\Core\IDataSource  data source instance
	* @return void
  * @reflection-skip
	*/
	public function load_<xsl:value-of select="@member"/>( \Sigmalab\Database\Core\IDataSource $ds ):void
	{
		$this-><xsl:value-of select="@member"/> = $ds->queryStatement(\StmHelper::stmSelectByPrimaryKey(new <xsl:text/>
          <xsl:if test="count(@class-ns) != 0">\</xsl:if><xsl:value-of select="@class-ns"/>\<xsl:value-of select="@class"/>(), $this-><xsl:value-of select="@name"/> ));
	}
	</xsl:for-each>
#endif
    </xsl:if>
    <xsl:if test="count(item) !=0">
	/** Gets default values for initialize table
	* @return <xsl:value-of select="$class"/>[]
	*/
	public static function getDefaultValues() : array{
		$result = array();
		<xsl:for-each select="item">
		$item = new <xsl:value-of select="$class"/>();<xsl:text/>
		<xsl:for-each select="value">
		$item->set_<xsl:value-of select="@name"/>(<xsl:apply-templates select="." mode="insert-value"><xsl:with-param name="table" select="$table"/></xsl:apply-templates>);<xsl:text/>
		</xsl:for-each>
		$result[] = $item;
		</xsl:for-each>
		return $result;
	}
	</xsl:if>
}

  </xsl:template>


  <xsl:template mode="insert-value" match="value">
    <xsl:param name="table"/>
    <xsl:variable name="value-name" select="@name"/>
    <xsl:variable name="column" select="$table/column[@name=$value-name]"/>

    <xsl:choose>
      <xsl:when test="$column/@type = 'varchar' or column/@type='text'">
        <xsl:text/>"<xsl:value-of select="@value"/>"<xsl:text/>
      </xsl:when>
      <xsl:otherwise>
        <xsl:value-of select="@value"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>


  <xsl:template match="column" mode="define">
    <xsl:param name="table"/>
    <xsl:param name="class"/>
    <xsl:text>		</xsl:text>$columnDefinition[ <xsl:value-of select="$class"/>Fields::<xsl:value-of select="@name"/> ] = $this->tag_<xsl:value-of select="@name"/>();<xsl:text>
</xsl:text>
  </xsl:template>

  <xsl:template match="column" mode="get-foreign-class">
    <xsl:param name="prefix"/>
    <xsl:param name="table-name"/>
    <xsl:variable name="foreign-table" select="@foreign-table"/>
    <xsl:choose>
      <xsl:when test="count(@class) != 0">
        <xsl:value-of select="@class"/>
      </xsl:when>
      <xsl:when test="count(/database/table[@name=$foreign-table]/@class) != 0">
            <!-- use class defined in foreigh table -->
        <xsl:value-of select="/database/table[@name=$foreign-table]/@class"/>
      </xsl:when>
      <xsl:when test="count(/database/table[@name=$foreign-table]) != 0">
            <!-- use table name as class name defined in foreigh table -->
        <xsl:value-of select="$prefix"/>
        <xsl:value-of select="/database/table[@name=$foreign-table]/@name"/>
      </xsl:when>
      <xsl:otherwise>
        <xsl:message terminate="yes">
          <xsl:text/>GenPhp Error: Can't generate foreign key for <xsl:value-of select="$table-name"/>::<xsl:value-of select="@name"/>
          <xsl:text/> as <xsl:value-of select="$foreign-table"/>::<xsl:value-of select="@foreign-key"/> because @class not defined and foreign table is not accessible.
        </xsl:message>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>


  <xsl:template match="column" mode="define-fk">
    <xsl:param name="class"/>
    <xsl:text/>$keyDefs[ <xsl:value-of select="$class"/>Fields::<xsl:value-of select="@name"/> ] = $this->key_<xsl:value-of select="@name"/>();
  </xsl:template>

  <xsl:template match="column[@parent-key='yes']" mode="create">
    <xsl:param name="start-index" select="0"/>
    <xsl:param name="pure"/>

    <xsl:choose>
      <xsl:when test="$pure='yes'">
        <xsl:call-template name="create">
          <xsl:with-param name="start-index" select="$start-index"/>
          <xsl:with-param name="column" select="."/>
        </xsl:call-template>
      </xsl:when>
      <xsl:otherwise>

	/** @kphp-reserved-fields <xsl:value-of select="position() + $start-index"/>
	 */
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>
  <xsl:template match="column" mode="create" name="create">
    <xsl:param name="start-index" select="0"/>
    <xsl:param name="column" select="."/>

	/** <xsl:value-of select="$column/@description"/>
	 * @access private
	 * @var <xsl:apply-templates select="$column" mode="get-type-nullable-php-doc"/>
	 * @kphp-serialized-field <xsl:value-of select="position() + $start-index"/>
	 */
	public <xsl:apply-templates select="$column" mode="get-type-nullable"/> $<xsl:value-of select="$column/@name"/><xsl:text>;</xsl:text>
  </xsl:template>



  <xsl:template match="column" mode="init">
    <xsl:variable name="default">
      <xsl:choose>
        <xsl:when test="@default = 'null'"> NULL </xsl:when>
        <xsl:when test="@default = 'NULL'"> NULL </xsl:when>
        <xsl:when test="@type = 'blob' and @default != 'null'"> "" </xsl:when>
        <xsl:when test="@type = 'jsonb' and @default != 'null'"> "" </xsl:when>
        <xsl:when test="@type = 'text' and @default != 'null'"> "" </xsl:when>
        <xsl:when test="@type = 'varchar'"> '' </xsl:when>
        <xsl:when test="@type = 'int' and @default = 'not null'"> 0 </xsl:when>
        <xsl:when test="@type = 'int' and count(@default) > 0"> 0 </xsl:when>
        <xsl:when test="@type = 'datetime' and @default = 'not null'"> "" </xsl:when>
        <xsl:when test="@type = 'datetime' and @default = 'null'"> null </xsl:when>
        <xsl:when test="( @default = 'not null' or  @default = 'NOT NULL') and @type != 'varchar'"> NULL </xsl:when>
        <xsl:when test="( @default = 'not null' or  @default = 'NOT NULL') and @type = 'varchar'"> '' </xsl:when>
        <xsl:when test="@type = 'blob'"> NULL </xsl:when>
        <xsl:when test="count(@default) != 0 and @type ='int'"> <xsl:value-of select="@default"/></xsl:when>
        <xsl:when test="count(@default) != 0 and @type ='double'"> <xsl:value-of select="@default"/></xsl:when>
        <xsl:when test="count(@default) != 0"> '<xsl:value-of select="@default"/>'</xsl:when>
        <xsl:when test="count(@auto-increment) != 0"> 0 </xsl:when>
        <xsl:otherwise> NULL</xsl:otherwise>
      </xsl:choose>
	  </xsl:variable>
	  	$this-><xsl:value-of select="@name"/> = <xsl:value-of select="$default"/><xsl:text>;</xsl:text>
  </xsl:template>

  <!--   RELATIONS -->

  <xsl:template match="table" mode="relation">
    <xsl:text>

    </xsl:text>

    <xsl:variable name="pair" select="column[count(@foreign-key)!=0]"/>

    <xsl:variable name="first-class">
      <xsl:apply-templates select="$pair[position() =1]" mode="get-foreign-class">
        <xsl:with-param name="prefix" select="$prefix"/>
      </xsl:apply-templates>
    </xsl:variable>
    <xsl:variable name="second-class">
      <xsl:apply-templates select="$pair[position() =2]" mode="get-foreign-class">
        <xsl:with-param name="prefix" select="$prefix"/>
      </xsl:apply-templates>
    </xsl:variable>

    <xsl:choose>
      <xsl:when test="count(@class)!=0">
        <xsl:call-template name="make-class">
          <xsl:with-param name="adapter" select="."/>
          <xsl:with-param name="master" select="$pair[position() =1]"/>
          <xsl:with-param name="member" select="$pair[position() =2]"/>
          <xsl:with-param name="class-prefix" select="@class"/>
        </xsl:call-template>

      </xsl:when>
      <xsl:when test="$first-class != '' and $second-class != ''">
        <xsl:call-template name="make-class">
          <xsl:with-param name="adapter" select="."/>
          <xsl:with-param name="master" select="$pair[position() =1]"/>
          <xsl:with-param name="member" select="$pair[position() =2]"/>
        </xsl:call-template>

        <xsl:if test="$second-class != $first-class">
          <xsl:call-template name="make-class">
            <xsl:with-param name="adapter" select="."/>
            <xsl:with-param name="master" select="$pair[position() =2]"/>
            <xsl:with-param name="member" select="$pair[position() =1]"/>
          </xsl:call-template>
        </xsl:if>
      </xsl:when>
    </xsl:choose>
</xsl:template>

  <xsl:template name="make-class">
    <xsl:param name="adapter"/>
    <xsl:param name="master"/>
    <xsl:param name="member"/>
    <xsl:param name="class-prefix"/>
    <xsl:variable name="adapter-class">
      <xsl:choose>
        <xsl:when test="count( $adapter/@class ) != 0"><xsl:value-of select="$adapter/@class"/></xsl:when>
        <xsl:otherwise><xsl:value-of select="$prefix"/><xsl:value-of select="$adapter/@name"/></xsl:otherwise>
      </xsl:choose>
    </xsl:variable>
    <xsl:variable name="master-class">
      <xsl:apply-templates select="$master" mode="get-foreign-class">
        <xsl:with-param name="prefix" select="$prefix"/>
      </xsl:apply-templates>
    </xsl:variable>
    <xsl:variable name="master-class-ns">
      <xsl:choose>
        <xsl:when test="count($master/@class-ns) =0">
          <xsl:value-of select="/database/namespace/@name"/><xsl:text>\</xsl:text>
        </xsl:when>
        <xsl:otherwise>
          <xsl:value-of select="$master/@class-ns"/>
          <xsl:if test="$master/@class-ns != ''">\</xsl:if>
        </xsl:otherwise>
      </xsl:choose>
    </xsl:variable>


    <xsl:variable name="member-class">
      <xsl:apply-templates select="$member" mode="get-foreign-class">
        <xsl:with-param name="prefix" select="$prefix"/>
      </xsl:apply-templates>
    </xsl:variable>
    <xsl:variable name="member-class-ns">
      <xsl:choose>
        <xsl:when test="count($member/@class-ns) =0">
          <xsl:value-of select="/database/namespace/@name"/><xsl:text>\</xsl:text>
        </xsl:when>
        <xsl:otherwise>
          <xsl:value-of select="$member/@class-ns"/>
          <xsl:if test="$member/@class-ns != ''">\</xsl:if>
        </xsl:otherwise>
      </xsl:choose>
    </xsl:variable>


    <xsl:variable name="class-name">
      <xsl:choose>
        <xsl:when test="count(@relation-class-prefix)!=0"><xsl:value-of select="@relation-class-prefix"/></xsl:when>
        <xsl:otherwise>
          <xsl:value-of select="$class-prefix"/>
          <xsl:value-of select="$master-class"/>
          <xsl:value-of select="$member-class"/>
        </xsl:otherwise>
      </xsl:choose>
      <xsl:text>Relation</xsl:text>
    </xsl:variable>

//@class <xsl:value-of select="$class-name"/>

/** \ingroup table_relations
   Relation adapter for loading <xsl:value-of select="$member/@class"/>
   objects as members of  <xsl:value-of select="$master/@class"/>
*/
class <xsl:value-of select="$class-name"/> extends \Sigmalab\Database\Relations\DBRelationAdapter
{
	/** @inheritDoc */
	protected function getObject( int $objectId, int $memberId ):\Sigmalab\Database\Core\DBObject
	{
		$obj = new <xsl:value-of select="$adapter-class"/>;

		$obj-><xsl:value-of select="$master/@name"/> = $objectId;
		$obj-><xsl:value-of select="$member/@name"/> = $memberId;
		return( $obj );
	}

	/** @inheritDoc */
	protected function getDataObject(int $objectId ) : \Sigmalab\Database\Core\DBObject
	{
		$obj = new \<xsl:value-of select="$master-class-ns"/><xsl:value-of select="$master-class"/>();
		$obj-><xsl:value-of select="$master/@foreign-key"/> = $objectId;
		return( $obj );
	}
	/** @inheritDoc */
	protected function getMemberObject(int $memberId ): \Sigmalab\Database\Core\DBObject
	{
		$obj = new \<xsl:value-of select="$member-class-ns"/><xsl:value-of select="$member-class"/>();
		$obj-><xsl:value-of select="$member/@foreign-key"/> = $memberId;
		return( $obj );
	}
	/** returns foreing keys for linking
	 */
	protected function getForeignKeys()
	{
		return( [
			<xsl:text/>
			<xsl:value-of select="$adapter-class"/>Fields::<xsl:value-of select="$master/@name"/>,
			<xsl:value-of select="$adapter-class"/>Fields::<xsl:value-of select="$member/@name"/>
		] );
	}

	/** select <xsl:value-of select="$member-class-ns"/><xsl:value-of select="$member-class"/> objects by <xsl:value-of select="$master-class"/> primary key ID.
	 * @param int $objectID  primary key of <xsl:value-of select="$master-class"/>.
	 * @param \Sigmalab\Database\Core\IDataSource $ds
	 * @return \<xsl:value-of select="$member-class-ns"/><xsl:value-of select="$member-class"/>[]  collection ob member objects.
	 * @throws \Sigmalab\Database\DatabaseException
	*/
	public function select<xsl:value-of select="$member-class"/>s( int $objectID, \Sigmalab\Database\Core\IDataSource $ds ):array
	{
		//return $this->select( $objectID, $ds);
		//KPHP mode
		return array_map(function (\Sigmalab\Database\Core\IDataObject $x) {
			return instance_cast($x, \<xsl:value-of select="$member-class-ns"/><xsl:value-of select="$member-class"/>::class);},
			$this->select( $objectID, $ds));
	}
}

  </xsl:template>

  <xsl:template match="include">
    <xsl:apply-templates select="document(@href)/database"/>
  </xsl:template>

  <xsl:template match="*" mode="get-return-declaration">
    <xsl:text> :</xsl:text> <xsl:apply-templates select="." mode="get-type-nullable"/>
  </xsl:template>

  <xsl:template match="*[@type='jsonb']" mode="get-return-declaration">:string</xsl:template>

  <xsl:template match="*[@type='datetime']" mode="get-type-nullable">int</xsl:template>
  <xsl:template match="*[@type='datetime']" mode="get-type-nullable-php-doc">int</xsl:template>
  <xsl:template match="*[@type='datetime']" mode="get-return-declaration">:int</xsl:template>

  <xsl:template match="*[@type='datetime' and @default='null']" mode="get-type-nullable">?int</xsl:template>
  <xsl:template match="*[@type='datetime' and @default='null']" mode="get-type-nullable-php-doc">int|null</xsl:template>
  <xsl:template match="*[@type='datetime' and @default='null']" mode="get-return-declaration">:?int</xsl:template>

  <xsl:template match="*[@type='jsonb']" mode="get-type-nullable">string</xsl:template>

  <xsl:template match="*[@type='blob']" mode="get-return-declaration">:string</xsl:template>
  <xsl:template match="*[@type='blob']" mode="get-type-nullable">?string</xsl:template>
  <xsl:template match="*[@type='blob']" mode="get-type-nullable-php-doc">string</xsl:template>

  <xsl:template match="*[@type='blob' and @default='null']" mode="get-return-declaration">:?string</xsl:template>
  <xsl:template match="*[@type='blob' and @default='null']" mode="get-type-nullable">?string</xsl:template>
  <xsl:template match="*[@type='blob' and @default='null']" mode="get-type-nullable-php-doc">string|null</xsl:template>

  <xsl:template match="*[@type ='jsonb']" mode="get-type-nullable-php-doc">string</xsl:template>
  <xsl:template match="*[@type ='jsonb' and @default='not null']" mode="get-type-nullable-php-doc">string</xsl:template>
  <xsl:template match="*[@type ='int' and (@default='null' or @parent-key = 'yes' or @primary-key = 'yes')]" mode="get-type-nullable-php-doc">int|null</xsl:template>
  <xsl:template match="*[@type ='int' and count(@foreign-key) != 0]" mode="get-type-nullable-php-doc">int|null</xsl:template>
  <xsl:template match="*[(@type ='float' or @type ='double') and @default='null']" mode="get-type-nullable-php-doc">float|null</xsl:template>
  <xsl:template match="*[(@type ='text' or @type ='varchar') and @default='null']" mode="get-type-nullable-php-doc">string|null</xsl:template>


  <xsl:template match="*" mode="get-type-nullable-php-doc">
    <xsl:apply-templates select="." mode="get-type-nullable"/>
  </xsl:template>

  <xsl:template match="*" mode="get-type-nullable">
    <!-- Use if for arguments, not use it for column defs -->
    <xsl:choose>
      <xsl:when test="@default = 'null'">?</xsl:when>
      <xsl:when test="@parent-key = 'yes'">?</xsl:when>
      <xsl:when test="@primary-key = 'yes'">?</xsl:when>
      <xsl:when test="count(@foreign-key) > 0">?</xsl:when>
    </xsl:choose>

    <xsl:variable name="type" select="@type"/>
    <xsl:choose>
      <xsl:when test="starts-with($type,'enum')">int</xsl:when>
      <xsl:when test="$type = 'datetime'">string</xsl:when>
      <xsl:when test="$type = 'jsonb'">string</xsl:when>
      <xsl:otherwise>
        <xsl:apply-templates select="." mode="get-type"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>

  <xsl:template match="*" mode="get-type">
    <xsl:variable name="type" select="@type"/>
    <xsl:choose>
      <xsl:when test="starts-with($type,'enum')">enum</xsl:when>
      <xsl:when test="$type = 'varchar'">string</xsl:when>
      <xsl:when test="$type = 'text'">string</xsl:when>
      <xsl:when test="$type = 'jsonb'">string</xsl:when>
      <xsl:when test="$type = 'blob'">blob</xsl:when>
      <xsl:when test="$type = 'double'">float</xsl:when>
      <xsl:otherwise>
        <xsl:value-of select="$type"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>

  <xsl:template match="*" mode="get-type-cast">
    <xsl:variable name="type" select="@type"/>
    <xsl:choose>
      <xsl:when test="starts-with($type,'enum')">int</xsl:when>
      <xsl:when test="$type = 'varchar'">string</xsl:when>
      <xsl:when test="$type = 'text'">string</xsl:when>
      <xsl:when test="$type = 'jsonb'">string</xsl:when>
      <xsl:when test="$type = 'blob'">string</xsl:when>
      <xsl:when test="$type = 'double'">float</xsl:when>
      <xsl:when test="$type = 'datetime'">int</xsl:when>
      <xsl:otherwise>
        <xsl:value-of select="$type"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>

  <xsl:template match="table" mode="enum">
    <xsl:variable name="table" select="."/>
    <xsl:value-of select="$eol"/>
    <xsl:text/>//Enum for <xsl:value-of select="@class"/>/<xsl:value-of select="@name"/> /  <xsl:value-of select="@description"/>

    <xsl:variable name="prefix" select="@enum"/>
    <xsl:variable name="value" select="$table/column[@primary-key='yes']/@name"/>
    <xsl:variable name="name" select="@enum-name"/>
    <xsl:variable name="comment" select="@enum-comment"/>

    <xsl:for-each select="data/item">
      <xsl:value-of select="$eol"/>define( "<xsl:value-of select="$prefix"/><xsl:value-of select="@*[name()=$name]"/>", <xsl:text/>
      <xsl:value-of select="@*[name()=$value]"/>); // <xsl:value-of select="@*[name()=$comment]"/>
    </xsl:for-each>
  </xsl:template>

  <xsl:template mode="is-nullable" match="*[@default='null' or @default='NULL']">true</xsl:template>
  <xsl:template mode="is-nullable" match="*">false</xsl:template>


  <xsl:template match="column" mode="insert-get-set">
    <xsl:param name="class"/>
	/** set value to <xsl:value-of select="@name"/>  column
	 * @param <xsl:apply-templates select="." mode="get-type-nullable-php-doc"/> $value  value
	 * @return bool true when value changed
	 */
	public function set_<xsl:value-of select="@name"/>(<xsl:apply-templates select="." mode="get-type-nullable"/> $value ) : bool
	{
		if ($this-><xsl:value-of select="@name"/> === $value) return false;
		$this->setChangedValue(<xsl:value-of select="$class"/>Fields::<xsl:value-of select="@name"/>, $this-><xsl:value-of select="@name"/>);
		$this-><xsl:value-of select="@name"/> = $value;
		return( true );
	}

	/** get value from \a <xsl:value-of select="@name"/>  column
	 * @return <xsl:apply-templates select="." mode="get-type-nullable-php-doc"/> value
	 */
	public function get_<xsl:value-of select="@name"/>() <xsl:apply-templates select="." mode="get-return-declaration"/>
	{
		return( $this-><xsl:value-of select="@name"/> );
	}
  </xsl:template>

  <xsl:template match="column" mode="insert-tags">
    <xsl:param name="class"/>
	/** get column definition for \a <xsl:value-of select="@name"/> column
	 * @param string|null $alias  alias for \a <xsl:value-of select="@name"/> column which will be used for on SQL query generation stage
	 * @return \Sigmalab\Database\Core\IDBColumnDefinition
	 */
	public function tag_<xsl:value-of select="@name"/>(?string $alias=null ):\Sigmalab\Database\Core\IDBColumnDefinition
	{
		$def = new \Sigmalab\Database\Core\DBColumnDefinition( <xsl:text/>
    <xsl:value-of select="$class"/>Fields::<xsl:text/><xsl:value-of select="@name"/>, <xsl:text/>
    <xsl:text/>"<xsl:apply-templates select="." mode="get-type"/><xsl:text>", $alias,$this, false, </xsl:text>
    <xsl:text/>"<xsl:value-of select="@description"/><xsl:text>", </xsl:text>
		<xsl:apply-templates select="." mode="is-nullable"/>,<xsl:text/>
    <xsl:value-of select="$class"/>FieldKeys::<xsl:text/><xsl:value-of select="@name"/><xsl:text/>
    <xsl:text>);</xsl:text>

		return( $def );
	}
  </xsl:template>

  <xsl:template match="*" mode="set_primary_key_value">
    <xsl:param name="class"/>
    <xsl:variable name="pkname" select="column[@primary-key='yes']/@name"/>
	/** returns primary key tag */
	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition
	{
		return $this->tag_<xsl:value-of select="column[@primary-key='yes']/@name"/>() ;
	}

	/** get primary key value
	 * @return int primary key value with type as defined in database (value of \a <xsl:value-of select="$pkname"/> )
	 * @noinspection PhpMissingParentCallCommonInspection
	 */
	public function primary_key_value():int
	{
		<xsl:choose>
		<xsl:when test="count( column[@primary-key='yes'] ) != 0" >
		<xsl:text>return( (int)$this-&gt;</xsl:text><xsl:value-of select="column[@primary-key='yes']/@name"/> );
		</xsl:when>
		<xsl:otherwise>return( 0 );</xsl:otherwise>
		</xsl:choose>
	}


  /** @inheritDoc */
	public function set_primary_key_value(int $value):void
	{
<xsl:text/><xsl:choose>
    <xsl:when test="count( column[@primary-key='yes'] ) != 0" >
<xsl:text>		$this-&gt;</xsl:text><xsl:value-of select="column[@primary-key='yes']/@name"/> = $value;<xsl:text/>
    </xsl:when>
	</xsl:choose>
	}

  </xsl:template>
  <xsl:template match="*" mode="insert_table_name">
	public function createSelf():\Sigmalab\Database\Core\IDataObject
	{
		if ( get_class($this) !== __CLASS__) {
			\Sigmalab\Database\Core\DataSourceLogger::getInstance()->warning(get_class($this)."::createSelf() not implemented fallback to parent");
			return parent::createSelf();
		}
		return new self();
	}

	/** always contains \a "<xsl:value-of select="@name"/>"
	 */
	public function table_name() :string
	{
		return( "<xsl:value-of select="@name"/>" );
	}

	/** always contains \a "<xsl:value-of select="@name"/>"
	*/
	public function table_description():string
	{
		return( "<xsl:value-of select="@description"/>" );
	}
  </xsl:template>
</xsl:stylesheet>
