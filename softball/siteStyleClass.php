<?php 

require_once ("page.php");

class siteStyle extends page
{

	function __construct()
	{
		$this->menuWidth = (($this->containerWidth * 0.18) + ($this->appPadding*2));
		$this->contentWidth = $this->containerWidth - $this->menuWidth -($this->appPadding*4);
	}

	var $appPadding = 10;
	var	$containerWidth = 765;
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