<?php 
function writeRegisterForm($values,$error = FALSE){

	// DEBUG var_dump($value);
	$heading = "<div class='registerFormHeading'>Please fill out this form to register</div>\n";
	if($error === TRUE){
		$heading .= "<div class='registerFormSubHeading'>There was a problem with how you filled out the form.</div>";
	}
	$heading .= "<p style='text-align: left; padding-left: 20px;'><span style='color: red; vertical-align: super;'>&#42;</span> indicates a required field.</p>";
	
	echo $heading;

?>
			<form action="index.php?register=y&pg=register" method="post">
			<table >
				<tr>
					<td class='label'>First Name:<?php echoRequired() ?></td>
					<td><input type="text" name="firstName" size=24 maxlength=40 value="<?php echoName('firstName')  ?>"></td>
					<td class='errorInfo'><?php echoError('firstName',$values) ?></td>
				</tr>
				<tr>
					<td class='label'>Last Name:<?php  echoRequired() ?></td>
					<td><input type="text" name="lastName" size=24 maxlength=40 value="<?php echoName('lastName') ?>"></td>
					<td class='errorInfo'><?php echoError('lastName',$values) ?></td>
				</tr>

				<tr>
					<td class='label'>Email Address:<?php echoRequired() ?></td>
					<td><input type="text" name="email" size=24 maxlength=50 value="<?php echoName('email') ?>"></td>
					<td class='errorInfo'><?php echoError('email',$values) ?></td>
				</tr>
				<tr>
					<td class='label'>Password:<?php echoRequired() ?></td>
					<td><input type="password" name="password1" size=24 maxlength="40"></td>
					<td class='errorInfo'><?php echoError('password1',$values) ?></td>
				</tr>				
				<tr>
					<td class='label'>Confirm Password:<?php  echoRequired() ?></td>
					<td><input type="password" name="password2" size=24 maxlength="40"></td>
					<td class='errorInfo'><?php echoError('password2',$values) ?></td>
				</tr>
				<tr>
					<td class='label'>Cell Phone:</td>
					<td><input type="text" name="mobilePhone" size=24 maxlength=20 value="<?php echo echoName('mobilePhone') ?>"></td>
					<td class='errorInfo'><?php echoError('mobilePhone',$values) ?></td>
				</tr>
				<tr>
					<td class='label'>Team ID:</td>
					<td><input type="text" name="teamID" size=24 maxlength=24 value="<?php echo echoName('teamID') ?>" onfocus="if(this.value == 'ID from team manager') { this.value = ''; }"></td>
					<td class='errorInfo'><?php echoError('teamID',$values) ?></td>
				</tr>
				<tr>
					<td class='label'>I am a:</td>
					<td>
						<select name="gender">
							<option value="male">Boy</option>
							<option value="female">Girl</option>
						</select>
					</td>
					<td class='errorInfo'>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td><td><input type="reset" name="reset" value="Reset"> <input type="submit" value="Submit"></td>
				</tr> 
			</table>
			</form>
<?php 			
}

function echoRequired($color = 'red'){
	echo "<span style='color: $color; vertical-align: super;'>&#42;</span>";
}

function echoName($name){
	if(isset($_SESSION[$name])){
		echo $_SESSION[$name];
	}
	else 
		return;
}

function echoError($name,$values){
	
	foreach($values as $value){
		if($name == $value['name']){
			if(isset($value['needsAttention'])){
				if($value['needsAttention'] === FALSE){
					//field doesn't need attention
					echo "&nbsp;";
				}
				else{
					// field needs attention
					$msg = "<span style='color: red; vertical-align: super;'>&#42;</span> ";
					$msg .= "Error encountered : ".$value['needsAttention']." ";
					
					echo $msg;
				}
			}// $value['needsAttention'] is not set - Clicked the Register link vs having submitted the form
			else 
				echo "&nbsp;";
		}
	}
}

?>