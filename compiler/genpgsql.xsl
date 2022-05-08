<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                version="1.0">

  <xsl:output method="text"
    encoding="utf-8"
    />

  <!--


       this file renders SQLite schema from xml.


       -->

  <xsl:variable name="autoincrement-supported" select="'yes'"/>
  <xsl:variable name="sqlite-version" select="'3.6'"/>

  <xsl:template match="/">
    <xsl:apply-templates select="database"/>
  </xsl:template>

  <xsl:template match="database">
    CREATE COLLATION russian (LOCALE = 'ru_RU.utf8');
    <xsl:apply-templates select="table"/>
    <xsl:apply-templates select="include"/>

    <xsl:for-each select="table">
        <xsl:apply-templates select="column[count(@foreign-key) !=0 ]" mode="foreign-key">
          <xsl:with-param name="table" select="@name"/>
        </xsl:apply-templates>
    </xsl:for-each>
  </xsl:template>

  <xsl:template match="include">
    <xsl:apply-templates select="document(@href)/database"/>
  </xsl:template>

  <xsl:template match="table">
    <xsl:variable name="table" select="@name"/>
<xsl:if test="$sqlite-version > 3.0">    DROP TABLE IF EXISTS <xsl:value-of select="@name"/>; </xsl:if>
         
CREATE TABLE <xsl:value-of select="@name"/> (
  <xsl:for-each select="column">
    <xsl:if test="position() > 1">
  ,</xsl:if>
    <xsl:apply-templates select="." mode="define">
      <xsl:with-param name="table" select="$table"/>
    </xsl:apply-templates>
  </xsl:for-each>
  <xsl:text>

  </xsl:text>


  <xsl:text>
  </xsl:text>    

  <!--
  <xsl:apply-templates select="column[count(@primary-key) !=0 ]" mode="primary-key">
    <xsl:with-param name="table" select="$table"/>
  </xsl:apply-templates>
  -->
  <xsl:apply-templates select="column[@unique = 'yes' ]" mode="unique">
    <xsl:with-param name="table" select="$table"/>
  </xsl:apply-templates>

  ) <xsl:text/><xsl:text> </xsl:text>
  <!--
  <xsl:if test="count( /database/@encoding ) =1">CHARSET <xsl:value-of select="/database/@encoding"/></xsl:if>
  <xsl:if test="count( /database/@collate ) = 1">COLLATE <xsl:value-of select="/database/@collate"/></xsl:if>-->;
    <xsl:apply-templates select="column[@index ='yes' or count(@foreign-key) !=0 ]" mode="index">
      <xsl:with-param name="table" select="$table"/>
    </xsl:apply-templates>

   <xsl:apply-templates select="." mode="insert-data"/>
</xsl:template>


  <xsl:template match="column" mode="select-default">
    <xsl:choose>
      <xsl:when test="@default = 'null' or @default = 'NULL'"> DEFAULT NULL </xsl:when>
      <xsl:when test="@default = 'not null' or @default = 'NOT NULL'"> NOT NULL </xsl:when>
      <xsl:when test="@default = '0'"> DEFAULT 0</xsl:when>
      <xsl:when test="@default = '' and @type='int'">
        <xsl:message terminate="yes">
          <xsl:text>GenSql Error: Attribute @default for column '</xsl:text>
          <xsl:value-of select="../@name"/>::<xsl:value-of select="@name"/>
          
          <xsl:text>' is not defined correctly</xsl:text>
        </xsl:message>
      </xsl:when>
      <xsl:when test="@default = '' and @type='varchar'"> DEFAULT ''</xsl:when>
      <xsl:when test="@default = '' and count( @foreign-key ) != 0">
        <xsl:message terminate="yes">
          <xsl:text>GenSql Error: Attribute @default for column '</xsl:text>
          <xsl:value-of select="../@name"/>::<xsl:value-of select="@name"/>
          
          <xsl:text>' is not defined correctly</xsl:text>
        </xsl:message>
      </xsl:when>
      <xsl:when test="count(@default) != 0 and @type='int'"> DEFAULT <xsl:value-of select="@default"/></xsl:when>
      <xsl:when test="count(@default) != 0"> DEFAULT '<xsl:value-of select="@default"/>'</xsl:when>
      <xsl:when test="@primary-key='yes'"> NOT NULL </xsl:when>
      <xsl:otherwise> DEFAULT NULL</xsl:otherwise>
    </xsl:choose>
  </xsl:template>
  
  <xsl:template match="column" mode="define">
    <xsl:variable name="type">
      <xsl:choose>
        <xsl:when test="@auto-increment = 'yes'">SERIAL</xsl:when>
        <xsl:when test="starts-with(@type, 'enum')">
          <xsl:text>text</xsl:text>
          <xsl:message >
            <xsl:text>
Warning: Enums not supported. changed to 'string' value.
</xsl:text>
          </xsl:message>
        </xsl:when>
        <xsl:when test="@type = 'int'">integer</xsl:when>
        <xsl:when test="@type = 'double'">double precision</xsl:when>
        <xsl:when test="@type = 'datetime'">timestamp</xsl:when>
        <xsl:when test="@type = 'blob'">bytea</xsl:when>
        <xsl:otherwise>
          <xsl:value-of select="@type"/>
        </xsl:otherwise>
      </xsl:choose>
    </xsl:variable>

    
    <xsl:text></xsl:text>"<xsl:value-of select="@name"/>"<xsl:text> </xsl:text><xsl:value-of select="$type"/>
    <xsl:if test="@length != ''">
      <xsl:text>(</xsl:text><xsl:value-of select="@length"/><xsl:text>)</xsl:text>
    </xsl:if>
    <xsl:apply-templates select="." mode="select-default"/>

    <xsl:if test="@auto-increment='yes' and $autoincrement-supported='yes'">
      <xsl:text>PRIMARY KEY </xsl:text>
    </xsl:if>
    <!--
    <xsl:if test="@unique='yes'">
      <xsl:text> unique </xsl:text>
    </xsl:if>
    -->

    <xsl:apply-templates select="node()[@primary-key='yes']">
      <xsl:with-param name="table" select="$table"/>
    </xsl:apply-templates>
  </xsl:template>

  <xsl:template match="column" mode="index">
    <xsl:param name="table"/>
    <xsl:text>CREATE INDEX IF NOT EXISTS</xsl:text> ix_<xsl:value-of select="$table"/>_<xsl:value-of select="@name"/> on <xsl:value-of select="$table"/>("<xsl:value-of select="@name"/>");<xsl:text>
</xsl:text>
  </xsl:template>

  <xsl:template match="column" mode="primary-key">
    <xsl:param name="table"/>
    <xsl:text>,</xsl:text>CONSTRAINT c_<xsl:value-of select="$table"/>_<xsl:value-of select="@name"/> PRIMARY KEY("<xsl:value-of select="@name"/>")
  </xsl:template>

  <xsl:template match="column" mode="unique">
    <xsl:param name="table"/>
	<xsl:text>,</xsl:text>CONSTRAINT c_<xsl:value-of select="$table"/>_<xsl:value-of select="@name"/> UNIQUE("<xsl:value-of select="@name"/>")
  </xsl:template>

  <xsl:template match="column" mode="foreign-key">
    <xsl:param name="table"/>
    <xsl:variable name="this" select="."/>

    <!-- verify tables if available -->
    <xsl:variable name="foreign-table" select="//table[@name = $this/@foreign-table]"/>
    <xsl:if test="count( $foreign-table ) = 1">
      <xsl:if test="count( $foreign-table/column[@name = $this/@foreign-key] ) = 0 ">
        <xsl:message terminate="yes">
          <xsl:text>GenSql Error: Foreign Key constaints fail in '</xsl:text>
          <xsl:value-of select="../@name"/>::<xsl:value-of select="@name"/>
          <xsl:text>'. The column '</xsl:text>
          <xsl:value-of select="@foreign-table"/>::<xsl:value-of select="@foreign-key"/>
          <xsl:text>' does not exists</xsl:text>
        </xsl:message>
      </xsl:if>
    </xsl:if>
    
    <xsl:text>
  </xsl:text>ALTER TABLE <xsl:value-of select="$table"/> ADD CONSTRAINT c_<xsl:value-of select="$table"/>_<xsl:value-of select="@name"/> FOREIGN KEY("<xsl:value-of select="@name"/>")
    REFERENCES <xsl:value-of select="@foreign-table"/>("<xsl:value-of select="@foreign-key"/>"<xsl:text>)</xsl:text>
    <xsl:if test="count(@on-delete)"> ON DELETE <xsl:value-of select="@on-delete"/></xsl:if>
    <!-- DEFERRABLE -->
    ;
  </xsl:template>



  <xsl:template match="*" mode="insert-data">
    <xsl:variable name="table" select="."/>
    <xsl:for-each select="data/item">
      <xsl:text>INSERT INTO </xsl:text>
      <xsl:value-of select="$table/@name"/><xsl:text> (</xsl:text>

      <xsl:for-each select="*">
        <xsl:if test="position() != 1">,</xsl:if>
        <xsl:text/>"<xsl:value-of select="name()"/>"
      </xsl:for-each>
      <xsl:text>)</xsl:text>
      VALUES (<xsl:text/>

      <xsl:for-each select="*" >
        <xsl:if test="position() != 1">,</xsl:if>
        <xsl:variable name="column-name" select="name()"/>
        <xsl:variable name="column" select="$table/column[@name=$column-name]"/>
        <xsl:choose>
          <xsl:when test="$column/@type = 'int' or $column/@type = 'integer'">
            <xsl:text/><xsl:value-of select="."/><xsl:text></xsl:text>
          </xsl:when>
          <xsl:otherwise>
            <xsl:text>'</xsl:text><xsl:value-of select="."/><xsl:text>'</xsl:text>
          </xsl:otherwise>
        </xsl:choose>
      </xsl:for-each>
      <xsl:text/> );
    </xsl:for-each>
  </xsl:template>

</xsl:stylesheet>
