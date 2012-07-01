<?php 
/**
 * @author Matthew Larsen
 * interface for adding and managing teams  
 * 
 */

require_once 'lib/utils.php';

global $db;
global $dbConnection;
if (empty($db)){
	// No $db object for database stuff.  We're going to have problems
}
if (empty($dbConnection)){
	// No $dbConnection object for database stuff.  We're going to have problems.
}

if (!isset($_SESSION['auth']) || ($_SESSION['auth'] != TRUE)){
	/**
	 * They aren't logged in so instruction to do so
	 */
	echo "<h3>You need to be logged in to use the management tools.</h3>\n<p>Please login at the top of the page</p>\n";
}
else{ // User is logged in
	// Check to see if they are a team owner.
	//  If yes, then give options to add or update
	//  If not, give 'wizard' for getting started
	
	$teamOwnerQS = 
	"select idTeam, TeamName, UserEmailAddress, TeamOwner_User_idUser from Team, User
			where TeamOwner_User_idUser = idUser
			and UserEmailAddress like '".$_SESSION['confirmedUser']['UserEmailAddress']."'";
	
	// DEBUG var_dump($_SESSION);
	
	// DEBUG var_dump($teamOwnerQS);
	
	try {
		// require teamsForms.php to create teamsForms object
		if (@!require_once 'teamsForms.php')
			throw new Exception('Could not open teamsForms.php');
		// create object for teamsForms
		$forms = new teamsForms();
	}
	catch (Exception $e){
		echo "Encountered Error: ".$e->getMessage();
		exit;
	}
	
	
	if ($teamOwnerQR = $db->query($dbConnection,$teamOwnerQS)){
		if (mysqli_num_rows($teamOwnerQR) > 0){
			// User is a team owner
			// Could have multiple teams
			// create an array of teams owned IDs & names and store it as a SESSION variable
			// Give content for managing teams
			
			echo "<p>You're a team owner</p>";
			
		}
		else{
			// User is NOT a team owner
			// Give content for creating a team
			
			$newTeamFormIntro = $forms->get_newTeamFormIntro();
			echo $newTeamFormIntro;
					
			// echo the new team form
			$newTeamForm = $forms->get_newTeamForm();
			echo $newTeamForm;
			
		} // closing of "User is NOT a team owner" else bracket
	} // closing of "if ($teamOwnerQR = $db->query($dbConnection,$teamOwnerQS))" bracket
	else { 
		// Query for $teamOwnerQR had a problem
		printf("Query for team ownership failed: %s\n", mysqli_connect_error());
		exit;
	}
	
	


} // closing of "User is logged in" else bracket

?>