<?php 
session_start();
if (!isset($_SESSION['auth'])){
	$_SESSION['auth'] = false;
}


// require files defining classes and essential config data
require_once 'mysqlClass.php';
require_once 'page.php';
//require_once 'priv.php';
require_once 'siteStyleClass.php';

// create object to use as globals in other files
$db = new db();
$dbConnection = $db->connect() or die("Couldn't connect to the datbase<br>\n");
$pageStyle = new siteStyle();
$page = new page();

// start writing html to the browser
$page->writeHtmlDocType();
$page->openHTMLTag();

if (isset($_GET['pg']) && ($_GET['pg']=='manage'))
{
	$extraCSS = array( 'mgmtStyles.css.php' );
	$page->writeHeadContent($extraCSS);
}
elseif (isset($_GET['pg']) && ($_GET['pg']=='calendar')){
	$extraCSS = array( 'calendar.css' );
	$page->writeHeadContent($extraCSS);
}
else 
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
