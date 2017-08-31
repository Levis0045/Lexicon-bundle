<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<xsl:stylesheet version="1.0"
	xmlns="http://www.w3.org/1999/xhtml"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
	xmlns:d="http://www-clips.imag.fr/geta/services/dml"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xmlns:jbk="xalan://fr.imag.clips.papillon.business.xsl.JibikiXsltExtension"
	extension-element-prefixes="jbk"
	exclude-result-prefixes="xsl">    
	
	<xsl:output method="xml" encoding="utf-8" indent="no"/>

	<!-- Root template -->
	<xsl:template match="/">
		<xsl:apply-templates select="//entrée">
 			<xsl:with-param name="cid" select="//d:contribution/@d:contribid"/>
 		</xsl:apply-templates>
	</xsl:template>

	<!-- Entry template -->
	<xsl:template match="entrée">
	  <xsl:param name="cid" select="@id"/>
	  <div class="contribution">
			<div style="float:left;">
			<a class="entry_navigation">
				<xsl:attribute name="href">?FACET.0=cdm-headword&amp;OPERATOR.0=0&amp;search_type=previous_entry&amp;action=lookup&amp;TARGETS=*ALL*&amp;SOURCE.0=<xsl:value-of select="jbk:getEntrySourceLanguage(string($cid))"/>&amp;VOLUME=<xsl:value-of select="jbk:getEntryVolume(string($cid))"/>&amp;FACETVALUE.0=<xsl:copy-of select="jbk:getEntryHeadword(string($cid))"/></xsl:attribute>↩</a>
			<a class="entry_navigation"><xsl:attribute name="href">?FACET.0=cdm-headword&amp;OPERATOR.0=0&amp;search_type=next_entry&amp;action=lookup&amp;TARGETS=*ALL*&amp;SOURCE.0=<xsl:value-of select="jbk:getEntrySourceLanguage(string($cid))"/>&amp;VOLUME=<xsl:value-of select="jbk:getEntryVolume(string($cid))"/>&amp;FACETVALUE.0=<xsl:copy-of select="jbk:getEntryHeadword(string($cid))"/></xsl:attribute>↪</a>
			</div>&#xA0;
	  			<div style="float:right;"><span class="level"><xsl:value-of select="jbk:getEntryGroups(string($cid))"/></span></div>
	  			<xsl:copy-of select="jbk:editingCommands(string($cid))"/>
	  	<div>
	  		<xsl:attribute name="class">motamot-entry
	  			<!--xsl:call-template name="statusclass">
	  				<xsl:with-param name="author"><xsl:value-of select="jbk:getEntryModificationAuthor(string($cid))"/></xsl:with-param>
	  				<xsl:with-param name="login"><xsl:value-of select="jbk:getUserLogin()"/></xsl:with-param>
	  				<xsl:with-param name="status"><xsl:value-of select="jbk:getEntryStatus(string($cid))"/></xsl:with-param>
	  			</xsl:call-template>
	  			<xsl:text> </xsl:text>
	  			<xsl:value-of select="@status"/-->
	  		</xsl:attribute>
	  		<xsl:apply-templates />
				<!-- Created by - Modifed by -->
				<!--span class="status">[<xsl:value-of select="@status"/>/<xsl:value-of select="@process_status"/>]</span>
				<span>, </span>
				<span class="status">created by <xsl:value-of select="//d:metadata/d:author/text()" xmlns:d="http://www-clips.imag.fr/geta/services/dml"
					/>, last modified by <xsl:value-of select="//d:modification/d:author/text()" xmlns:d="http://www-clips.imag.fr/geta/services/dml"
				/></span-->
	  	</div>
    </div>
	</xsl:template>
		
	<xsl:template match="terme">
		<span class="headword"><xsl:apply-templates /></span>
	</xsl:template>
	
	<xsl:template match="##pronunciation_element##">
		<xsl:if test="text()!=''">
			<xsl:text> </xsl:text>/<span class="pronunciation"><xsl:apply-templates /></span>/
		</xsl:if>
	</xsl:template>
		
	<xsl:template match="##pos_element##">
		<xsl:text> </xsl:text>[<span class="pos"><xsl:apply-templates /></span>]
	</xsl:template>
		
	<xsl:template match="##example_element##">
	  <xsl:if test="text()!=''">
		<xsl:text> </xsl:text><span class="example">
			<xsl:apply-templates />
		</span>
		</xsl:if>
	</xsl:template>

	<xsl:template match="##sense_element##">
	  <blockquote>
			<xsl:apply-templates />
		</blockquote>
	</xsl:template>

	<xsl:template match="##idiom_element##">
	<xsl:if test="text()!=''">
		<xsl:text> </xsl:text><span class="idiom">
			<xsl:apply-templates />
		</span>
		</xsl:if>
	</xsl:template>
	
	<xsl:template name="statusclass">
		<xsl:param name="author">unknown</xsl:param>
		<xsl:param name="login">guest</xsl:param>
		<xsl:param name="status">unknown</xsl:param>
		<xsl:choose>
			<xsl:when test="$author=$login">
				<xsl:choose>
					<xsl:when test="$status='finished'">myFinishedEntry</xsl:when>
					<xsl:when test="$status='modified'">modifiedEntry</xsl:when>
					<xsl:when test="$status='deleted'">modifiedEntry</xsl:when>
					<xsl:when test="$status='not finished'">myNotFinishedEntry</xsl:when>
				</xsl:choose>
			</xsl:when>
			<xsl:otherwise>
				<xsl:choose>
					<xsl:when test="$status='finished'">finishedEntry</xsl:when>
					<xsl:when test="$status='modified'">modifiedEntry</xsl:when>
					<xsl:when test="$status='deleted'">modifiedEntry</xsl:when>
					<xsl:when test="$status='not finished'">notFinishedEntry</xsl:when>
				</xsl:choose>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

</xsl:stylesheet>
