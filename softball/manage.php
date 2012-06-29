<?php
/**
 * check if $_SESSION['auth'] isset and !empty and == true
 * if not indicate they need to login
 * else show page
 */
require_once 'lib/utils.php';
require_once 'mgmtClass.php';

$mgtHeading = new mgmtContentPage();

if (!isset($_SESSION['auth']) || ($_SESSION['auth'] != TRUE)){
	/**
	 * They aren't logged in so instruction to do so
	 */
	echo "<h3>You need to be logged in to use the management tools.</h3>\n<p>Please login at the top of the page</p>\n";
}
else{
	$mgtHeading->getTitle();
	
	$mgtHeading->getHeadings();
	
	/* check $_GET['mgtPg'] for which mangement page to show 
	 * loop through $mgtHeading->headings['mgtPg'] for value matching $_GET['mgtPg']
	 * include $mgtHeading->heading['URI'] from match
	 * 
	 * */
	echo "\n<br>\n";
	
	if (isset($_GET['mgtPg']) && !empty($_GET['mgtPg']) ){
		foreach ($mgtHeading->headings as $heading){
			if ($heading['mgtPg'] == $_GET['mgtPg']){
				try {
					if (@!include $heading['URI'])
						throw new Exception('Could not open file : '.$heading['URI']);
				}
				catch (Exception $e){
					echo "Error encountered : ".$e->getMessage();
				}
			}
		}
	}
	
/* 	echo "\n<p style='clear: left;'>";
	var_dump($mgtHeading->headings);
	echo "</p>\n"
	 */
?>

<!--  
	<h3>Management Page!</h3>
	<div class="mgt" id="teams"><a href='index.php?pg=teams'>Teams</a> &nbsp;&#124;</div>
	<div class="mgt" id="people">&#124;&nbsp; Participants &nbsp;&#124;</div>
	<div class="mgt" id="cal">&#124;&nbsp; Calendars &nbsp;&#124;</div>
	<div class="mgt" id="events">&#124;&nbsp; Events</div>
	
 -->

<?php 
}

?>
