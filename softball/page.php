<?php 
/**
 * 
 * @author Matthew Larsen
 * @created Jun 24, 2012
 */


 class page {
	function __construct() {
		
	}
	
	var $htmlDocType ='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
	var $pageTitle = "Simple Softball Team Tool";
	var $parentDIVID;
	
	var $styleSheetFiles = array ( "appLayout.css.php" );
	
	
	function writeHtmlDocType()
	{
		echo $this->htmlDocType;
	}
	
	function openHTMLTag(){
		echo "\n<html>";
	}
	
	/**
	 * Writes the <head> tag and its contents
	 * @param array $extraCSS extra CSS sheets to include in the head
	 */
	function writeHeadContent(array $extraCSS = null)
	{
		echo "\n<head>
			\n<title>".$this->pageTitle."</title>";
		
		$this->writeStyleSheetLinks($extraCSS);
		
		echo "\n</head>";
	}
	
	function openBodyTag()
	{
		echo "\n<body>";
	}
	
	function openParentDiv($parentDIVID)
	{
		$this->parentDIVID = $parentDIVID;
		echo "\n<!-- opening parent  id='$this->parentDIVID' DIV tag -->";
		echo "\n<div id='$parentDIVID'>\n";
	}
	
	function getPageHeading()
	{
		
	}
	
	function getContentPage($content = 'home')
	{
		/* get the page URL from the database for inclusion in the page */
		echo "\n<!-- opening content DIV --> \n <div id='content'>\n";
		global $db;
		global $dbConnection;
		
		if (!$content){
			echo "Content not set.";
			return;
		}
				
		$pageqs = "SELECT PageBaseURL, PageURL from Page where PageName like '$content'";
		$pageqr = $db->query($dbConnection,$pageqs);
		
		if (mysqli_num_rows($pageqr) != 0){
			$row = mysqli_fetch_assoc($pageqr);
			include $row['PageURL'];
		}
		else{
			echo "<h4>Ooops!</h4>
					Couldn't find the page: $content for some reason...";			
		}
				
		echo "\n<!-- closing content DIV --> \n </div>\n";
			
	}
	
	function writeFooter()
	{
		require_once "footer.php";
	}
	
	function closeParentDiv()
	{
		echo "\n<!-- closing parent id='$this->parentDIVID' DIV tag -->
			</div>";
	}
	
	function closeBodyTag()
	{
		echo "\n</body>";
	}
	
	function closeHTMLTag()
	{
		echo "\n</html>";
	}
	
	/**
	 * Writes the style sheet links into the page <head> tab
	 * @param array $additionalStyleSheets CSS pages to include
	 */
	function writeStyleSheetLinks (array $additionalStyleSheets = NULL)
	{
		if (!empty($additionalStyleSheets))
		{
			// echo links for each value passed to function
			foreach ($additionalStyleSheets as $extraCSS){
				echo "\n<link href='$extraCSS' rel='stylesheet' type='text/css'>\n";
			}
			
		}
		foreach ($this->styleSheetFiles as $styleSheetFile)
		{
			echo "\n<link href='$styleSheetFile' rel='stylesheet' type='text/css'>\n";
		}
	}
}
	
?>