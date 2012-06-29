<?php 
/**
 * @author Matthew Larsen
 * interface for adding and managing teams  
 * 
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

<h3>Page for managing teams</h3>

<?php 

} // closing of else bracket

?>