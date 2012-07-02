<?php
/**
 * @author Matthew Larsen
 * 
 * 
 */

require_once 'validateForm.php'; // functions to validate and evaluate form data

function echoLoggedIn (){
	echo "<h3>You're successfully logged in</h3>\n
			<p>Get started by <a href='index.php?pg=manage&mgtPg=teams'>creating a team</a> or checking which teams your registred for</p>\n";
	return;
}

// bring in the $db object from index.php
global $db;
global $dbConnection;

if( isset($_GET['register']) && ($_GET["register"] == "y") ){
	// check $_POST is set with values
	// DEGUG var_dump($_POST);
	
	if (!isset($_POST) || empty($_POST)){  // we came here without $_POST set
		
		if (isset($_SESSION['auth']) && ($_SESSION['auth'] == TRUE)){
			//The user is logged in so we don't need to give them the register form
			// Would find themselves here after logging in from successfully filling in the register form.
			echoLoggedIn();
			return;
		}
		else { 
			// user isn't logged in
			// Find yourself here after successfully registering but messing up the login form
			// also need to handle login errors rather than just saying the form isn't filled out.
			if (isset($_GET['err']) || !empty($_GET['err'])){ 
				// had a login error
				echo "<p>There was a problem logging in.  More information is given above.</p>";
				return;
			}
			else{
				echo "<p>Form not filled out.<br>Please fill out the <a href='index.php?pg=register'>registration form.</a></p>";
				return;
			}
		}
	} // end if (!isset($_POST) || empty($_POST)) bracket
	// $_POST IS set and NOT empty - we came here with $_POST set
	/**
	 * @todo add logic for validating that registration form was filled out appropriately
	 */
	
	
	//check if email address is alread in the User table in the database
	$emailSelect = "select * from User where UserEmailAddress like '".$_POST['email']."'";
	$selectResult = $db->query($dbConnection, $emailSelect);  // would like to work in some soft of form validation for this before submit
	
	if (mysqli_num_rows($selectResult) > 0) //email address exists in database already
	{
		echo "Email address ".$_POST['email']." already used";
	}
	else // insert User info to database
	{
		$insertEmailQuery = "insert into User values 
								(NULL,'".$_POST['firstName']."','".$_POST['lastName']."','"
										.$_POST['email']."','".$_POST['mobilePhone']."',
										(select idUserType from UserType where UserTypeName like 'Player'),
										'".$_POST['password1']."',".(isGirl($_POST['gender'])).")";
		
		// echo $insertEmailQuery; // runs down more space for testing

		try {
			if ($insertResult = $db->query($dbConnection, $insertEmailQuery)){
				// User inserted to the database
				// can I call login.php to set the session variables and then givem the further instruction?
				// would need to send $_POST['emailAddress'] and $_POST['password']
				/**
				 * @todo build external confirmation of registration
				 * @todo set session variables to indicate logged in after filling out form and successfully inserting user		
				 */
				$insertConfirmation = 
					"<h3>You've successfully registered.</h3>
							<p>Please login above to get started.</p>\n";
				
				echo $insertConfirmation;
				// would like to use this to indicate next step
				// echoLoggedIn(); 
				
				// DEGUB echo "<br>".mysqli_affected_rows($dbConnection)." users inserted.<br>$insertConfirmation";
			}
			else
				throw new Exception('Unable to add user to the database');
		}
		catch (Exception $e){
			echo "Error encountered : ".$e->getMessage();
		}
		
								
	}
/*	
	?>

		<h3>You filled out:</h3>
			First Name (firstName): <?php echo $_POST["firstName"]; ?> <br>
			Last Name (lastName): <?php echo $_POST["lastName"]; ?><br>
			Email Address (email): <?php echo $_POST["email"]; ?><br>
			Password (password): <?php echo $_POST["password1"]?><br>
			Cell Phone (mobilePhone): <?php echo $_POST["mobilePhone"]; ?><br>
			Gender: <?php echo $_POST['gender']?><br>
	
	<?php 
*/	
	
} // end if( isset($_GET['register']) && ($_GET["register"] == "y") ) bracket
else
{
	if (isset($_SESSION['auth']) && ($_SESSION['auth'] == TRUE)){
		//user is logged in so they don't need the registration form
		echoLoggedIn();
	}
	else{
		// user is not logged in 
		// && $_GET['register'] not set to run registration code
		// so show them the form
		require_once 'registerForm.php';
	}	
}



?>