<?php
/**
 * check if $_SESSION['auth'] isset and !empty and == true
 * if not indicate they need to login
 * else show page
 */
require_once 'lib/utils.php';
if (!isset($_SESSION['auth']) || ($_SESSION['auth'] != TRUE)){
	/**
	 * They aren't logged in so instruction to do so
	 */
	echo "<h3>You need to be logged in to use the management tools.</h3>\n<p>Please login at the top of the page</p>\n";
}
else{
?>

	<h3>Management Page!</h3>
	<div class="mgt" id="teams">Teams &nbsp;&#124;</div>
	<div class="mgt" id="people">&#124;&nbsp; Participants &nbsp;&#124;</div>
	<div class="mgt" id="cal">&#124;&nbsp; Calendars &nbsp;&#124;</div>
	<div class="mgt" id="events">&#124;&nbsp; Events</div>
	


<?php 
}

?>
