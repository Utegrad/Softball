<?php 
/**
 * @author Matthew Larsen
 * 
 * 
 */

require_once ("headingClass.php");

$heading = new heading();

$heading->openHeadingDivTag();
$heading->writeHeadingImg();

?>
		 <h1 style="margin: 0; text-align: center;">
<?php echo "$heading->headingTitle"; ?>
		 </h1>
		 <p style="text-align: right; margin: 0 auto; padding: 0;">
		 	Organize your team&#39;s schedule and communications
		 </p>	
		 
		 <!-- Start login DIV -->
		 <div id="login" style="float: right; margin: 0; padding:0px; height: 100px; background-image: url(imgs/loginBG.png); ">
		 <?php 
		 	// Check if the user is logged in
		 	if( (!isset($_SESSION['auth'])) || ($_SESSION['auth'] == false) ) {
				// User isn't logged in
				global $db;
				global $dbConnection;
				/**
				 * check if _GET['err'] is set and not empty
				 * lookup description of error code from err
				 * indicate error desc for login form submission
				 */
				
				//  Check for login errors in the query string from previous login attempt
				if ( isset($_GET['err']) && !empty($_GET['err']) ){
					$errorQS = "select ErrorCode, ErrorType.ErrorTypeName, ErrorDesc 
		 				from Error, ErrorType 
		 				where Error.ErrorType_idErrorType = ErrorType.idErrorType 
		 				and Error.ErrorCode like '".$_GET['err']."'";
					if ($errorQR = $db->query($dbConnection, $errorQS)){
						$row = mysqli_fetch_assoc($errorQR);
						$errorString = "<p id='loginError'>Login failed for the following reason:<br>
				 			".$row['ErrorDesc']."</p>\n";
						echo $errorString; 
					}
					
				}
				
		 ?>
		 
		 	<table>
		 		<tr>
		 			<td style="vertical-align: bottom;">
		 			<!--  This is where to handle login failure messages -->
		 			<form action="login.php" method="post">
		 				Login: <input type="text" size=15 maxlength="40" value="Email Address" name="emailAddress" onfocus="if(this.value == 'Email Address') { this.value = ''; }"> 
		 				Password: <input type="password" size=15 maxlength="40" name="password"> 
		 				<input type="submit" value="Submit">
		 			</form>
		 			<p style="text-align: right; margin=0 auto; padding: 0;"><a href="index.php?pg=register&clrForm=1" class="footerLink">Register</a></p> 
		 			</td>
	 			</tr>
		 	</table>
		 
		<?php 
			}
			else{
			// User is logged in
				echo "<p>Logged in as: ".$_SESSION['confirmedUser']['UserFirstName']." ".$_SESSION['confirmedUser']['UserLastName']." :: <a href='logout.php'>LOGOUT</a></p>
						<p style='text-align: right; margin=0 padding=0;'>::<a href='index.php?pg=profile'>Profile</a>::</p>";
			}
		?>		 
		 </div> 
		 <!-- End login DIV -->
<?php 
$heading->closeHeadingDivTag();
?>