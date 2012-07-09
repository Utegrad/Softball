<?php
/**
 * @author Matthew Larsen
 * 
 * 
 */

require_once 'validateForm.php'; // functions to validate and evaluate form data
require_once 'lib\utils.php';
require_once 'registerForm.php';

function echoLoggedIn (){
	echo "<h3>You're successfully logged in</h3>\n
			<p>Get started by <a href='index.php?pg=manage&mgtPg=teams'>creating a team</a> or checking which teams your registred for</p>\n";
	return;
}

// bring in the $db object from index.php
global $db;
global $dbConnection;

require_once 'UserData.php';
$userData = new UserData();



if (isset($_GET['clrForm']) && $_GET['clrForm'] == 1){
	// clear the session variables for the form to start fresh
	$fields = array ('email','firstName','lastName','mobilePhone','teamID');
	foreach($fields as $field){
		if(isset($_SESSION[$field])){
			unset($_SESSION[$field]);
		}
	}
	unset($field);
	
}

// check that the register form has been submitted
if( isset($_GET['register']) && ($_GET["register"] == "y") ){
	// check $_POST is set with values
	// DEGUG var_dump($_POST);
	
	if (!isset($_POST) || empty($_POST)){  // we came here without $_POST set
			// generally would come here from being redirected back to here by the login.php script
		
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
	

		
/************* Validate and sanitize form data ***********/		
		// required fields given
		// sanitize
		// register form values as session variables : 'email', ??? 
	
		$userData->fieldsGiven($_POST);
 		
		/*****  email   *****/
		$_POST['email'] = $userData->sanitizeEmail($_POST['email']);
		
		/*****  firstName  *****/
		$_POST['firstName'] = $userData->sanitizeName($_POST['firstName'], 'firstName', 'firstName');
		
		/*****  lastName  *****/
		$_POST['lastName'] = $userData->sanitizeName($_POST['lastName'], 'lastName', 'lastName');
		
		/****   Mobile Phone   ******/
		$_POST['mobilePhone'] = $userData->sanitizePhone($_POST['mobilePhone'], 'mobilePhone');
		
		/*****  TeamID    *******/
			
		/*****  Gender   *******/
		$userData->sanitizeGender($_POST['gender']);

		/*****  password1  *****/
		$_POST['password1'] = $userData->sanitizePassword($_POST['password1'], 'password1');

		/*****  password2 *****/
		$_POST['password2'] = $userData->sanitizePassword($_POST['password2'], 'password2');

		// check that password2 matches password1
		$userData->checkPasswordsMatch($_POST['password1'], $_POST['password2']);

/*****  POST values validated and sanitized   *****/
				
		// required field not right.  notify user to fix
		if($userData->needsCorrection == TRUE){
			writeRegisterForm($userData->formField,TRUE);
			return;
		}
		
/*****  POST values validated and sanitized - insert into Database ****/
				
 // insert User info into database
			
			
			$insertEmailQuery = "insert into User values
								(NULL,'".$_POST['firstName']."','".$_POST['lastName']."','"
												.$_POST['email']."','".$_POST['mobilePhone']."',
										(select idUserType from UserType where UserTypeName like 'Player'),
										'".$_POST['password1']."',".(isGirl($_POST['gender'])).")";
			
			
			// DEBUG echo $insertEmailQuery;
		
			try {
				if ($insertResult = $db->query($dbConnection, $insertEmailQuery)){
					// User inserted to the database
					// can I call login.php to set the session variables and then givem the further instruction?
					// 	would need to send $_POST['emailAddress'] and $_POST['password']
					/**
					 * @todo set session variables to indicate logged in after filling out form and successfully inserting user
					 */
					$insertConfirmation =
					"<h3>You've successfully registered.</h3>
							<p>Please login above to get started.</p>\n";
		
					echo $insertConfirmation;
					
					/**
					 * might want to unset these session variables now that we're logged in
					 * becuase I don't want to confuse them with session variables set
					 * by login.php
					 */
					/* $fields = array ('email','firstName','lastName','mobilePhone','teamID');
					foreach($fields as $field){
						if(isset($_SESSION[$field])){
							unset($_SESSION[$field]);
						}
					} */
					
					// would like to use this to indicate next step
					// echoLoggedIn();
		
					// DEGUB echo "<br>".mysqli_affected_rows($dbConnection)." users inserted.<br>$insertConfirmation";
				}
				else{
					$queryError = '<p>Unable to add user to the database:</p>';
					
					// DEBUG $queryError .= "Error num : ".mysqli_errno($dbConnection)."<br>";
					// DEBUG $queryError .= mysqli_error($dbConnection);
					
					throw new Exception("$queryError");
				}
					
			}
			catch (Exception $e){
				echo "Error encountered : ".$e->getMessage();
			}
	

/************* register command not given - give form ***********/
	
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
		
		writeRegisterForm($userData->formField);
	}	
}



?>