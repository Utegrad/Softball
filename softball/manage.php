<?php
/**
 * check if $_SESSION['auth'] isset and !empty and == true
 * if not indicate they need to login
 * else show page
 */
require_once 'libs/utils.php';
if (!isset($_SESSION['auth']) || ($_SESSION['auth'] != TRUE)){
	/**
	 * They aren't logged in so instruction to do so
	 */
	echo "<h3>You need to be logged in to use the management tools.</h3>\n<p>Please login at the top of the page</p>\n";
}
else{
?>

	<h3>Management Page!</h3>
	<ul>
		<li>Teams
		<li>Calendaring
		<li>Participants
		<li>Events
		
	</ul>
<?php 
}

?>
