<?php 

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
	
	function writeHeadContent()
	{
		echo "\n<head>
			\n<title>".$this->pageTitle."</title>";
		
		// add page specific style sheets
		if (isset($_GET['pg']) && ($_GET['pg']=='calendar'))
		{
			array_push($this->styleSheetFiles, "calendar.css");
		}
		
		$this->writeStyleSheetLinks();
		
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
		echo "\n<!-- opening content DIV --> \n <div id='content'>\n";
		switch ($content)
		{
			case "home":
				require_once 'home.php';
				break;
			case "register":
				require_once 'register.php';
				break;
			case "roster":
				require_once 'roster.php';
				break;
			case "calendar":
				require_once 'calendar.php';
				break;
			case "manage":
				require_once 'manage.php';
				break;
			case "GCal":
				require_once 'GCal.php';
				break;
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
	
	function writeStyleSheetLinks ($additionalStyleSheets = NULL)
	{
		if (isset($additionalStyleSheets))
		{
			
			// echo links for each value passed to function
			// check if array or string
		}
		foreach ($this->styleSheetFiles as $styleSheetFile)
		{
			echo "\n<link href='$styleSheetFile' rel='stylesheet' type='text/css'>\n";
		}
	}
}
	
?>