<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                version="1.0">

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
<xsl:text>//@flow</xsl:text>
/*
 *
 *  DONT EDIT THIS FILE. AUTO CREATED BY genjs.xsl
 *
 *  File: <!-- <xsl:value-of select="$file"/> -->
 */

  <xsl:apply-templates select="database/include"/>

  <xsl:apply-templates select="table"/>

</xsl:template>

  <xsl:template match="table" >
  <xsl:variable name="class">
    <xsl:choose>
      <xsl:when test="count( @class ) != 0"><xsl:value-of select="@class"/></xsl:when>
      <xsl:otherwise><xsl:value-of select="$prefix"/><xsl:value-of select="@name"/></xsl:otherwise>
    </xsl:choose>
  </xsl:variable>
  <xsl:variable name="pkname" select="column[@primary-key='yes']/@name"/>
  <xsl:variable name="table-name" select="@name"/>
  <xsl:variable name="defined-baseclass" select="@baseclass"/>
  <xsl:variable name="basetable" select="//table[@class=$defined-baseclass]"/>

  <xsl:variable name="use-baseclass">
    <xsl:choose>
      <xsl:when test="@baseclass != ''"><xsl:value-of select="translate(@baseclass, '\', '')"/></xsl:when>
      <xsl:otherwise><xsl:value-of select="translate($baseclass, '\', '')"/></xsl:otherwise>
    </xsl:choose>
  </xsl:variable>
///Data object of table '<xsl:value-of select="@name"/>'
export class <xsl:value-of select="$class"/> <xsl:if test="$use-baseclass != ''"> extends  <xsl:value-of select="$use-baseclass"/></xsl:if>
{
  <xsl:apply-templates select="column" mode="create"/>
}
  </xsl:template>

  <xsl:template match="column" mode="create">
    <xsl:if test="count(@description) !=0 "><xsl:text>
  ///</xsl:text><xsl:value-of select="@description"/><xsl:text>
</xsl:text></xsl:if>
	<xsl:text>  </xsl:text><xsl:value-of select="@name"/> : <xsl:apply-templates select="@type" mode="get-type"/>;
  </xsl:template>


  <xsl:template match="include">
    <xsl:apply-templates select="document(@href)/database"/>
  </xsl:template>

  <xsl:template match="@*|node()" mode="get-type">
    <xsl:param name="value" select="@*|node()"/>
    <xsl:choose>
      <xsl:when test="starts-with(.,'enum')">number</xsl:when>
      <xsl:when test=". = 'varchar'">string</xsl:when>
      <xsl:when test=". = 'text'">string</xsl:when>
      <xsl:when test=". = 'jsonb'">string</xsl:when>
      <xsl:when test=". = 'blob'">string</xsl:when>
      <xsl:when test=". = 'float'">number</xsl:when>
      <xsl:when test=". = 'int'">number</xsl:when>
      <xsl:when test=". = 'double'">number</xsl:when>
      <xsl:when test=". = 'datetime'">number</xsl:when>
      <xsl:otherwise>
        <xsl:value-of select="."/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>


</xsl:stylesheet>
