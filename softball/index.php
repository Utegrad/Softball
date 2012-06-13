<?php 
session_start();



require_once 'page.php';
$page = new page();

$page->writeHtmlDocType();
$page->openHTMLTag();
$page->writeHeadContent();
$page->openBodyTag();

/* open parent div tag with ID for CSS styling */
$page->openParentDiv("container");

require_once 'heading.php';
require_once 'menu.php';

// Get the name of the page from $_GET and include the appropriate file for content
if (isset($_GET['pg']))
{
	$page->getContentPage($_GET['pg']);
}
else
{
	$page->getContentPage();
}


$page->writeFooter();
$page->closeParentDiv();
$page->closeBodyTag();
$page->closeHTMLTag();

?>
