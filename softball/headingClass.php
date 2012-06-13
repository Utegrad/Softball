<?php
/*
 * Need to figure out something to make folder seperator "\ vs /" OS agnostic
 */

require_once ("page.php");

class heading extends page
{
	
	var $headingImgAlt = "Flying softball";
	var $headingImg = "imgs\\flying_softball_logo.png";
	var $headingTitle = "Simple Team Organization Tool";
	
	function openHeadingDivTag ($headingDIVID = "header")
	{
		echo "<!-- opening heading DIV tag -->
				<div id='$headingDIVID'>";
	}

	function closeHeadingDivTag()
	{
		echo "<!-- closing heading DIV tag -->
				</div>";
	}
	
	function writeHeadingImg ()
	{
		echo "\n<img alt='".$this->headingImgAlt."' src='".$this->headingImg."' height='90' width='95' style='float: left; margin: 0; padding: 0;'>";
	}
	
}

?>