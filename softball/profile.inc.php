<?php 

function writeProfileForm($formFields,$error = FALSE){
	
	$firstName = $formFields['firstName']['userData'];
	$lastName = $formFields['lastName']['userData'];
	$email = $formFields['email']['userData'];
	$mobilePhone = $formFields['mobilePhone']['userData'];
	
	
	$heading = "<div class='registerFormHeading'>Please update your user information with this form</div>\n";
	if($error === TRUE){
		$heading .= "<div class='registerFormSubHeading'>There was a problem with how you filled out the form.</div>";
	}
	//$heading .= "<p style='text-align: left; padding-left: 20px; margin: 0;'><span style='color: red; vertical-align: super;'>&#42;</span> indicates a required field.</p>";
	$fieldColors = array('orig' => '#99FFFF', 'changed' => '#FFFF99', 'error' => '#FF9999');
	$heading .= "<style type=\"text/css\">
					<!--
					input.profileFormField {
						background-color: ".$fieldColors['orig'].";
					}
					-->
				</style>";
	
	echo $heading;
	
	?>

<script type="text/javascript">
<!--
function colorChangedInput(elementId,color){
	
	document.getElementById(elementId).style.backgroundColor = color ;
	
	return;
}
//-->
</script>	
	
<form action="index.php?pg=profile" method="post">
	<table>
		<tr style="border-bottom-width: thin;">
			<th>&nbsp;</th>
			<th colspan=3 style="text-align: left;">Check the box to the right of a value to delete it</th>
			
		</tr>
		<tr>
			<td class='label'>First Name:<?php //echoRequired('firstName','black') ?></td>
			<td width=170><input class="profileFormField" type="text" name="firstName" ID="firstName" size=24 maxlength=40 
			<?php echo "value=\"".$firstName."\""; hightlightError('firstName', $formFields, $fieldColors['error']);  ?>
			onchange="colorChangedInput('firstName','<?php echo $fieldColors['changed'] ?>');">
			</td>
			<td><input type="hidden" name="updateFirstName"></td>
			<td class='errorInfo'><?php echoError('firstName',$formFields) ?></td>
		</tr>
		<tr>
			<td class='label'>Last Name:<?php  //echoRequired('lastName','black') ?></td>
			<td><input class="profileFormField" type="text" name="lastName" ID="lastName" size=24 maxlength=40 
			<?php echo "value=\"".$lastName."\""; hightlightError('lastName', $formFields, $fieldColors['error']);  ?>
			onchange="colorChangedInput('lastName','<?php echo $fieldColors['changed'] ?>');">
			</td>
			<td><input type="hidden" name="updateLastName"></td>
			<td class='errorInfo'><?php echoError('lastName',$formFields) ?></td>
		</tr>
		<tr>
			<td class='label'>Email Address:<?php //echoRequired('email','black') ?></td>
			<td><input class="profileFormField" type="text" name="email" ID="email" size=24 maxlength=50 
			<?php echo "value=\"".$email."\""; hightlightError('email', $formFields, $fieldColors['error']);  ?>
			onchange="colorChangedInput('email','<?php echo $fieldColors['changed'] ?>');">
			</td>
			<td><input type="hidden" name="updateEmail"></td>
			<td class='errorInfo'><?php echoError('email',$formFields) ?></td>
		</tr>
		<tr>
			<td class='label'>Password:<?php //echoRequired('password1','black') ?></td>
			<td><input class="profileFormField" type="password" name="password1" ID="password1" size=24 maxlength="40" 
			<?php echo hightlightError('password1', $formFields, $fieldColors['error']);  ?>
			onchange="colorChangedInput('password1','<?php echo $fieldColors['changed'] ?>');">
			</td>
			<td><input type="hidden" name="updatePassword"></td>
			<td class='errorInfo'><?php echoError('password1',$formFields) ?></td>
		</tr>				
		<tr>
			<td class='label'>Confirm Password:<?php  //echoRequired('password2','black') ?></td>
			<td><input class="profileFormField" type="password" name="password2" ID="password2" size=24 maxlength="40"
			<?php echo hightlightError('password2', $formFields, $fieldColors['error']);  ?> 
			onchange="colorChangedInput('password2','<?php echo $fieldColors['changed'] ?>');">
			 </td>
			<td>&nbsp;</td>
			<td class='errorInfo'><?php echoError('password2',$formFields) ?></td>
		</tr>
		<tr>
			<td class='label'>Cell Phone:</td>
			<td><input class="profileFormField" type="text" name="mobilePhone" ID="mobilePhone" size=24 maxlength=20 
			<?php echo "value=\"".$mobilePhone."\""; echo hightlightError('mobilePhone', $formFields, $fieldColors['error']);  ?>
			onchange="colorChangedInput('mobilePhone','<?php echo $fieldColors['changed'] ?>');">
			</td>
			<td><input type="checkbox" name="chkMobilePhone" onchange="colorChangedInput('mobilePhone','<?php echo $fieldColors['changed'] ?>'); 
				document.getElementById('mobilePhone').style.textDecoration = 'line-through';">
				<input type="hidden" name="updateMobilePhone">
			</td>
			<td class='errorInfo'><?php echoError('mobilePhone',$formFields) ?></td>
		</tr>
		<tr>
			<td><input type="hidden" name="update" value="YES"></td><td><input type="reset" name="reset" value="Reset"> <input type="submit" value="Submit"></td>
		</tr> 
	</table>
</form>
<?php 			
}

function echoRequired($ID,$color = 'red'){
	echo "<span id='reqBullet$ID' style='color: $color; vertical-align: super;'>&#42;</span>";
}

function echoError($name,$values){
	// DEBUG var_dump($values);
	foreach($values as $key => $value){
		if($name == $key){
			if(isset($value['needsAttention'])){
				if($value['needsAttention'] === FALSE){
					//field doesn't need attention
					// check if valueUpdated === true  
					if(isset($value['valueUpdate'])){
						// the value was updated so reflect that here
						echo "< &nbsp; Profile data updated";
					}
					echo "&nbsp;";
				}
				else{
					// field needs attention
					$msg = "<span style='color: red; vertical-align: super;'>&#42;</span> ";
					$msg .= "Error : ".$value['needsAttention']." ";
					
					echo $msg;
				}
			}// $value['needsAttention'] is not set - Clicked the Register link vs having submitted the form
			else 
				echo "&nbsp;";
		}
	}
	unset($value);
}

function hightlightError($name,$values,$color){
	foreach($values as $key => $value){
		if($name == $key){
			if(isset($value['needsAttention'])){
				if($value['needsAttention'] === FALSE){
					//field doesn't need attention
					echo "&nbsp;";
				}
				else{
					// field needs attention
					$msg = "style='background-color: $color;'";
						
					echo $msg;
				}
			}
		}
	}
	unset($value);
}

function updateConfirmedUserSession($email){
	
	global $db;
	global $dbConnection;
	
	$QS = "SELECT UserFirstName, UserLastName, UserEmailAddress, UserMobilePhone from User
			WHERE UserEmailAddress like '".$email."'";

	if ($QR = $db->query($dbConnection, $QS)){

		// 	var_dump($loginQR);
	
		if (mysqli_num_rows($QR) > 0 ){
			// match found.  Set _SESSION['auth'] = TRUE
			// DEBUG echo "<p>Match found</p>\n";
	
			$confirmedUser = mysqli_fetch_assoc($QR);
	
			/**
			 * Set session variables 
			*/
		
			$_SESSION['confirmedUser'] = $confirmedUser;
		
		}
	}
	else{
		echo 'Error with query to update session values';
	}
}
?>