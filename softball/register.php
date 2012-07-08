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


$needsCorrection = FALSE;
// array describing register form values
$values = array (
		array ('name' => 'email', 'required' => true),
		array ('name' => 'password1', 'required' => true),
		array ('name' => 'password2', 'required' => true),
		array ('name' => 'firstName', 'required' => true),
		array ('name' => 'lastName', 'required' => true),
		array ('name' => 'mobilePhone', 'required' => false),
		array ('name' => 'teamID', 'required' => false),
		array ('name' => 'gender', 'required' => false)
);

if (isset($_GET['clrForm']) && $_GET['clrForm'] == 1){
	// clear the session variables for the form to start fresh
	$fields = array ('email','firstName','lastName','mobilePhone','teamID');
	foreach($fields as $field){
		if(isset($_SESSION[$field])){
			unset($_SESSION[$field]);
		}
	}
	
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
	
	/**
	 * @todo add logic for validating that registration form was filled out appropriately
	 * 
	 * Check that necessary post varibles are set
	 * 	yes - sanitize the input
	 * 		check that email doesn't already exist
	 * 			yes - report back that the email address already exists with form to fix or password rest
	 * 			no - insert values into database
	 * 	no - report back that the form input needs to be completed / changed
	 */
		
/************* Validate and sanitize form data ***********/		
		// required fields given
		// sanitize
		// register form values as session variables : 'email', ??? 
	

		
		foreach ($values as &$value){
			/***  Look for and flag blank values ***/
			if (!isset($_POST[$value['name']]) || empty($_POST[$value['name']])){
				// $value not set or empty
				// if the form was submitted, they values should be set, but could be empty
				// check to see if we care if they are empty
				$value['received'] = false;
				unset($_SESSION[$value['name']]);
				if($value['required'] == TRUE){
					// required form value not provided.  Now what....
					$value['needsAttention'] = "Required value not given";
					$needsCorrection = true;
					
					// DEBUG echo "<p>Value required but not received : ".$value['name']."</p>\n";
				}
				else{  // value not required
					$value['needsAttention'] = FALSE;
				}
			}
			/*** Sanitize given form data ***/
			else{  // value received
				$value['received'] = TRUE;
				$_POST[$value['name']] = trim($_POST[$value['name']]);
				
		/*****  email   *****/
				if($value['name'] == 'email'){
					//we're checking the email value
					// DEBUG echo $_POST[$value['name']];
					if(filter_var($_POST[$value['name']],FILTER_VALIDATE_EMAIL) !== FALSE && strlen($_POST[$value['name']]) <= 60){
						//and it's passed the VALIDATE_EMAIL filter
						$_POST[$value['name']] = filter_var($_POST[$value['name']],FILTER_SANITIZE_EMAIL);
						$_POST[$value['name']] = mysqli_real_escape_string($dbConnection,$_POST[$value['name']]);
						$value['needsAttention'] = FALSE;
						
						// check email has already been used
						$emailSelect = "select * from User where UserEmailAddress like '".$_POST[$value['name']]."'";
						$selectResult = $db->query($dbConnection, $emailSelect);  // would like to work in some soft of form validation for this before submit
						
						if (mysqli_num_rows($selectResult) > 0){ //email address exists in database already
							// DEBUG echo "<p>1 or more</p>\n";
							$needsCorrection = TRUE;
							$value['needsAttention'] = 'Email address is already used';
						
						}
						
					}
					else{
						// found an invalid email address
						$_POST[$value['name']] = filter_var($_POST[$value['name']],FILTER_SANITIZE_STRING);
						$value['needsAttention'] = "Invalid email address format found";
						$needsCorrection = TRUE;
					}
					$_SESSION[$value['name']] = $_POST[$value['name']];
					continue;
				}
		/*****  firstName  *****/
				elseif($value['name'] == 'firstName'){
					// check firstName for a reasonable string
					$pattern = "/^(?:[A-Za-z'-]*(?:\s+|$)){2,3}$/";
					if(filter_var($_POST[$value['name']],FILTER_VALIDATE_REGEXP,array('options' => array('regexp' => "$pattern"))) !== FALSE  && strlen($_POST[$value['name']]) <= 40){
						// valid string given for name
						$_POST[$value['name']] = filter_var($_POST[$value['name']],FILTER_SANITIZE_STRING);
						$value['needsAttention'] = FALSE;
					}
					else{
						// Invalid string given for name
						$_POST[$value['name']] = filter_var($_POST[$value['name']],FILTER_SANITIZE_STRING);
						$value['needsAttention'] = 'Invalid data given in first name';
						$needsCorrection = TRUE;
					}
					unset($pattern);
					$_SESSION[$value['name']] = $_POST[$value['name']];
					continue;
				}
		/*****  lastName  *****/
				elseif($value['name'] == 'lastName'){
					// check lastName for a reasonable string
					$pattern = "/^(?:[A-Za-z'-]*(?:\s+|$)){2,3}$/";
					if(filter_var($_POST[$value['name']],FILTER_VALIDATE_REGEXP,array('options' => array('regexp' => "$pattern"))) !== FALSE){
						// valid string given for name
						$_POST[$value['name']] = filter_var($_POST[$value['name']],FILTER_SANITIZE_STRING);
						$value['needsAttention'] = FALSE;
					}
					else{
						// Invalid string given for name
						$_POST[$value['name']] = filter_var($_POST[$value['name']],FILTER_SANITIZE_STRING);
						$value['needsAttention'] = 'Invalid data given in last name';
						$needsCorrection = TRUE;
					}
					unset($pattern);
					$_SESSION[$value['name']] = $_POST[$value['name']];
					continue;
				}
		/****   Mobile Phone   ******/
				elseif($value['name'] == 'mobilePhone'){
					//check mobilePhone format
					$pattern = '/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/';
					$replacement = '$1-$2-$3';
					if(filter_var($_POST[$value['name']],FILTER_VALIDATE_REGEXP,array('options' => array('regexp' => "$pattern"))) !== FALSE){
						// valid phone number input
						$_POST[$value['name']] = filter_var($_POST[$value['name']],FILTER_SANITIZE_STRING);
						$_POST[$value['name']] = preg_replace($pattern, $replacement, $_POST[$value['name']]);
						$value['needsAttention'] = FALSE;
					}
					else{
						// invalid phone number value given
						$_POST[$value['name']] = filter_var($_POST[$value['name']],FILTER_SANITIZE_STRING);
						$value['needsAttention'] = "Invalid phone number given";
						$needsCorrection = TRUE;
					}
					unset($pattern);
					unset($replacement);
					$_SESSION[$value['name']] = $_POST[$value['name']];
					continue;
				}
		/*****  TeamID    *******/
				elseif($value['name'] == 'teamID'){
					//check teamID
					// Not doing anything with this yet
					continue;
				}
		/*****  Gender   *******/
				elseif($value['name'] == 'gender'){
					// check gender
					if ($_POST[$value['name']] == 'male' || $_POST[$value['name']] == 'female'){
						$value['needsAttention'] = FALSE;
					}
					else{
						$value['needsAttention'] = 'Wrong gender value given';
						$needsCorrection = TRUE;
					}
					$_SESSION[$value['name']] = $_POST[$value['name']];
					continue;
				} 
		/*****  password1  *****/
				elseif($value['name'] == 'password1'){
					// we're checking password1
					if(is_string($_POST[$value['name']]) && strlen($_POST[$value['name']]) >= 4 && strlen($_POST[$value['name']]) <= 40){
						// password1 is a string and at least 4 characters long and less than 40 characters long
						$value['needsAttention'] = FALSE;
						$_POST[$value['name']] = mysqli_real_escape_string($dbConnection,$_POST[$value['name']]);
					}
					else{
						// password1 not acceptable
						$value['needsAttention'] = "Invalid value for password given";
						$needsCorrection = TRUE;
						continue;
					}
				}
		/*****  password2 *****/
				elseif($value['name'] == 'password2'){
					$_POST[$value['name']] = mysqli_real_escape_string($dbConnection,$_POST[$value['name']]);
					continue;		
				}
			} // end of else - value received
		} // end of foreach($values as $value) loop
		unset($value);
		
		// check that password2 matches password1
		if($_POST['password2'] !== $_POST['password1']){
			foreach($values as &$value){
				if($value['name'] == 'password2'){
					$value['needsAttention'] = 'Passwords do not match';
					$needsCorrection = TRUE;
					break;
				}				
			}
			unset($value);
		}
		
		
		
/*****  POST values validated and sanitized   *****/
				
		// required field not right.  notify user to fix
		if($needsCorrection == TRUE){
			
			
			writeRegisterForm($values,TRUE);
			// DEBUG echo "<p style='font-weight: bold;'> sanitized POST array :</p>";
			// DEBUG var_dump($_POST);
			// DEBUG var_dump($values);
			// DEBUG var_dump($_SESSION);
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
		
		writeRegisterForm($values);
	}	
}



?>