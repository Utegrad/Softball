<?php

require_once 'mysqlClass.php';

require_once 'priv.php';
$dbValues = array(
		'server' => SERVER,
		'username' => USERNAME,
		'password' => PASSWORD,
		'database' => DATABASE
);

$db = new db($dbValues);
print_r($db);

if( isset($_GET["register"]) && ($_GET["register"] == "y") )
{
	?>
		<h3>You filled out:</h3>
			First Name (firstName): <?php echo $_POST["firstName"]; ?> <br>
			Last Name (lastName): <?php echo $_POST["lastName"]; ?><br>
			Email Address (email): <?php echo $_POST["email"]; ?><br>
			Cell Phone (mobilePhone): <?php echo $_POST["mobilePhone"]; ?><br>
	<?php 
}
else
{
	$db = new db($dbValues) or die("Can't create database connection object");
	
	?>
		<h3>Please fill out this form to register for with your team</h3>

			<form action="index.php?register=y&pg=register" method="post">
			<table >
				<tr>
					<td>First Name:</td><td><input type="text" name="firstName" size=24 maxlength=24></td>
				</tr>
				<tr>
					<td>Last Name:</td><td><input type="text" name="lastName" size=24 maxlength=24></td>
				</tr>

				<tr>
					<td>Email Address:</td><td><input type="text" name="email" size=24 maxlength=35></td>
				<tr>
					<td>Cell Phone:</td><td><input type="text" name="mobilePhone" size=24 maxlength=15></td>
				</tr>
				<tr>
					<td>I am a:</td>
					<td>
						<select name="gender">
							<option value="male">Boy</option>
							<option value="female">Girl</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td><td><input type="reset" name="reset" value="Reset"> <input type="submit" value="Submit"></td>
				</tr> 
			</table>
			</form>
<?php 
}
?>