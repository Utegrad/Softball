<?php 

require_once ("page.php");

class siteStyle extends page
{

	function __construct()
	{
		$this->menuWidth = (($this->containerWidth * $this->menuWidthPercentage) + ($this->appPadding*2));
		$this->contentWidth = $this->containerWidth - $this->menuWidth -($this->appPadding*4);
	}

	var $menuWidthPercentage = 0.12;
	var $appPadding = 10;
	var	$containerWidth = 800;
 	var $menuWidth;
	var $contentWidth;
	
	function get_contentWidth ()
	{
		return $this->contentWidth;
	}
	
	function get_containerWidth ()
	{
		return $this->containerWidth;
	}
	
	function get_menuWidth ()
	{
		return $this->menuWidth;
	}
	
	function get_appPadding ()
	{
		return $this->appPadding;
	}
	
}



?>