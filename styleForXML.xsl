<?xml version="1.0" encoding="UTF-8"?>
<html xsl:version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<body style="font-family:Arial;font-size:13pt">

  <xsl:for-each select="ROOT/DOC">
    <div>
      <span style="font-weight:bold;color:black">DOCNO: <xsl:value-of select="DOCNO"/></span>
    </div>

    <div>
      <span style="font-weight:bold;color:red">Title: <xsl:value-of select="TITLE"/></span>
    </div>

    <div>
      <span style="font-weight:bold;color:grey">Authors: <xsl:value-of select="AUTHORS"/></span>
    </div>    
   
    <xsl:for-each select="DETAILS/ITEMS">
      <div>
        <span style="font-weight:bold;color:blue">PMID: <xsl:value-of select="PMID"/></span>
      </div>
      
      <div>
        <span style="font-weight:bold;color:green">Published Year: <xsl:value-of select="PUBLISHED_YEAR"/></span>
      </div>
    </xsl:for-each>

    <div><p></p></div>

  </xsl:for-each>

</body>
</html>