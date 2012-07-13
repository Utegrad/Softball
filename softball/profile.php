<?php

require_once 'UserData.php';
$userData = new UserData();

global $db;
global $dbConnection;

require_once 'profile.inc.php';

if (!isset($_SESSION['auth']) || ($_SESSION['auth'] != TRUE)){
	/**
	 * They aren't logged in so give instruction to do so
	 */
	echo "<h3>You need to be logged in to update your profile.</h3>\n<p>Please login at the top of the page</p>\n";
	return;
}

// we need $_SESSION['confirmedUser'] so check that it's set and not empty
if(!isset($_SESSION['confirmedUser']) || empty($_SESSION['confirmedUser'])){
	// mission the confirmed user's information from the database
	echo "<h3>Your profile information is missing for some reason.</h3>\n<p>Try logging out and back in to see if that fixes the problem</p>";
	return;
}


// add the $_SESSION['confirmedUser'] values into $userData->formField
$formValues = array( 'firstName' => $_SESSION['confirmedUser']['UserFirstName'],
		'lastName' => $_SESSION['confirmedUser']['UserLastName'],
		'email' => $_SESSION['confirmedUser']['UserEmailAddress'],
		'mobilePhone' => $_SESSION['confirmedUser']['UserMobilePhone']
		);
foreach($formValues as $FVkey => $FVvalue){
	foreach($userData->formField as $FFkey => $FFval){
		if($FVkey == $FFkey){
			$userData->formField[$FFkey]['userData'] = $FVvalue;
		}
	}
	unset($FFval);
}
unset($FVvalue);

// set all the $userData->formField[$KEY]['required'] values to FALSE
// can't do this.  firstName, lastName, and email must be true
/* foreach ($userData->formField as &$value){
	$value['required'] = FALSE;
}
unset($value);
 */
$userData->formField['password1']['required'] = FALSE;
$userData->formField['password2']['required'] = FALSE;

if(isset($_POST['update']) && $_POST['update'] == 'YES'){
	/**
	 * form has been submitted.
	 * sanitze input and identify which fields have changed
	 * 			santiy tests don't pass
	 * 				write out profile form with error indicators
	 * 	update database records for changed fields
	 * 	update $_SESSION['confirmedUser']
	 * 	write out profile form with indicators for updated fields
	 * 
	 * 
	 */
	
	// set received values to TRUE on $userData-formField for sanitizing input
	$userData->fieldsGiven($_POST);
	// store new user input in $userData->formField[FIELDNAME]['newUserData']
	$userData->formField['email']['newUserData'] = $userData->sanitizeEmail($_POST['email'],FALSE);
	$userData->formField['firstName']['newUserData'] = $userData->sanitizeName($_POST['firstName'], 'firstName', NULL);
	$userData->formField['lastName']['newUserData'] = $userData->sanitizeName($_POST['lastName'], 'lastName', NULL);
	$userData->formField['mobilePhone']['newUserData'] = $userData->sanitizePhone($_POST['mobilePhone'], 'mobilePhone',NULL);
	$userData->formField['password1']['newUserData'] = $userData->sanitizePassword($_POST['password1'], 'password1');
	$userData->formField['password2']['newUserData'] = $userData->sanitizePassword($_POST['password2'], 'password2');
	

	if( ($userData->formField['password1']['newUserData'] == $userData->formField['password2']['newUserData']) ){
		// new values for password1 and password2 match
		if( !empty($userData->formField['password1']['newUserData']) ){
			// new password values are not blank so update them
			$updatePWQuery = "UPDATE User SET ".$userData->formField['password1']['dbField']." = '".$userData->formField['password1']['newUserData']."'
										WHERE ".$userData->formField['email']['dbField']." LIKE '".$userData->formField['email']['userData']."'";
			// DEBUG echo $updatePWQuery."<br>";
			$updatePWQR = $db->query($dbConnection, $updatePWQuery);
			if($updatePWQR){
				$userData->formField['password1']['valueUpdate'] = TRUE;
				$userData->formField['password1']['userData'] = 'what ever you set it to';
				$userData->formField['password1']['oldUserData'] = 'what ever it was';
			}
			else{
				echo "<p>Encountered a problem updating your password</p>";
			}
			
			
			
			// DEBUG var_dump($userData->formField);
		}
		else{
			// password values match and are empty
			// don't do anything with the password
		}
	}
	else{
		// password values are not equal
		$userData->formField['password1']['needsAttention'] = "Passwords did not match";
		$userData->formField['password2']['needsAttention'] = '&nbsp;';
		$userData->needsCorrection = TRUE;
	}

	// compare $userData->formField[FIELD]['newUserData'] to $userData->formField[FIELD]['userData']
	// if newUserData != userData then update database values with newUserData
	
	// how to handle when nothing needed changing?
	// how to report back that changes were made?
	// update items as we need to and mark the formField array that a change was made
	// start with a flag set to false and set it true if changes were made.

	/**
	 * @todo update userData values to have new values if changed
	 */
	
	foreach($userData->formField as $key => $value){
	
		// DEBUG var_dump($key);
		// DEBUG var_dump($value);
	
		if($key == 'password1' || $key == 'password2' || $key == 'teamID' || $key == 'gender'){
			// password value handled earlier.
			// not updating teamID or gender either
			// move to next value
			continue;
		}
		elseif($key == 'mobilePhone' && isset($_POST['chkMobilePhone']) && $_POST['chkMobilePhone'] == 'on' && !empty($_POST['mobilePhone']) ){
			// box checked to delete the mobile phone number
			$mblDelQ = "UPDATE User SET UserMobilePhone = NULL where UserEmailAddress LIKE '".$userData->formField['email']['userData']."'";
			
			// DEBUG echo "<p>$mblDelQ</p>";
			$mblDelQR = $db->query($dbConnection, $mblDelQ);
			if($mblDelQR){
				$userData->formField[$key]['oldUserData'] = $userData->formField[$key]['userData'];
				$userData->formField[$key]['userData'] = 'DELETED';
				unset($userData->formField[$key]['newUserData']);
				// indicate that this userData has been updated
				$userData->formField[$key]['valueUpdate'] = TRUE;
			}
			else{
				echo "<p>Encountered a problem updating your password</p>";
			}

			continue;
		}
		
		// DEBUG var_dump($key);
		if($value['newUserData'] == $value['userData']){
			// value hasn't changed.  Nothing to do
			
			continue;
		}
		else{
			//values are different - update the database
			/**
			 * @todo check if the new value needs attention, if it does skip it.  Otherwise, update it
			 */
			// DEBUG echo "<br>Different Values<br>Key : $key<br>Value : ".$value['needsAttention']."<br>";
			// DEBUG var_dump($userData->formField);
			
			if($value['needsAttention'] === FALSE){
				// update the relivent database field
				if(empty($_POST['mobilePhone']) && $key == 'mobilePhone'){
					// mobile phone value removed but check box not used
					$userData->formField[$key]['needsAttention'] = 'please use the checkbox to remove the phone number';
					continue;
				}
				$updateQ = "UPDATE User SET ".$value['dbField']." = '".$value['newUserData']."' 
						WHERE ".$userData->formField['email']['dbField']." LIKE '".$userData->formField['email']['userData']."'";
				
				// DEBUG echo "<p>$updateQ</p>";
				// update user data to new values to fill in the form if other fields have errors that need to be reflected
				$updateQR = $db->query($dbConnection, $updateQ);
				if($updateQR){
					
					$userData->formField[$key]['oldUserData'] = $userData->formField[$key]['userData'];
					$userData->formField[$key]['userData'] = $userData->formField[$key]['newUserData'];
					unset($userData->formField[$key]['newUserData']);
					// indicate that this userData has been updated
					$userData->formField[$key]['valueUpdate'] = TRUE;
				}
				else{
					echo "<p>Encountered a problem updating your profile</p>";
				}
			} // end if($value['needsAttention'] === FALSE)
			else{
				// value needs attention so continue and leave it to be reflected in the form later
				continue;
			}
			
			// update $_SESSION['confirmedUser'] with the values we've set.
			updateConfirmedUserSession($userData->formField['email']['userData']);
		}
	}
	unset($value);
	
	
	// DEBUG echo "<br>End loop to compair values<br>";
	// DEBUG var_dump($userData->formField);
	
	if($userData->needsCorrection === TRUE){
		writeProfileForm($userData->formField,TRUE);
	}
	else{
		// None of the values set needsCorrection to TRUE so indicate which values were updated.

		foreach($userData->formField as $key=> $value){
			if(isset($userData->formField[$key]['valueUpdate'])){
				$updated = TRUE;
			}
			else 
				continue;
		}
		unset($value);
		
		if(!isset($updated)){
			echo "<h3 id='noChanges'>Nothing set to be changed</h3>";
			writeProfileForm($userData->formField);
			return;
		}
		
		
		echo "<p>Values Updated:</p>";
		foreach($userData->formField as $key => $value){
			
			if(isset($userData->formField[$key]['valueUpdate'])){
									
				switch ($key){
					case 'email':
						$k = "email address";
						break;
					case 'firstName':
						$k = "first name";
						break;
					case 'lastName':
						$k = "last name";
						break;
					case 'mobilePhone':
						$k = 'mobile phone number';
						break; 
					case 'password1':
						$k = 'password';
						// $value['oldUserData'] = 'what ever it was';
						break;
				}
				echo "<p>Your $k has been changed from \"".$value['oldUserData']."\" to \"".$value['userData']."\" </p>";
			}
			
		}
		unset($value);
		updateConfirmedUserSession($userData->formField['email']['userData']);
	}
	
} // end if(isset($_POST['update']) && $_POST['update'] == 'YES')
else{
	// came here without $_POST['update'] == 'YES'
	// show the regular form without error processing
	writeProfileForm($userData->formField);
}


?>
