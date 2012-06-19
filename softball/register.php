<?php
require_once 'validateForm.php'; // functions to validate and evaluate form data

// bring in the $db object from index.php
global $db;

if( isset($_GET['register']) && ($_GET["register"] == "y") )
{
	// check $_POST is set with values
	if (!$_POST)
	{
		echo "Form not filled out.  Please fill out <a href='index.php?pg=register' class='menuButton'>the form.</a>";
		return;
	}
	
	//check if email address is alread in the User table in the database
	$emailSelect = "select * from User where UserEmailAddress like '".$_POST['email']."'";
	$selectResult = $db->query($emailSelect);  // would like to work in some soft of form validation for this before submit
	
	if (mysql_num_rows($selectResult) > 0) //email address exists in database already
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
				
		$insertResult = $db->query($insertEmailQuery);
		if ($insertResult)
		{
			echo "<br>".mysql_affected_rows()." users inserted.";
		}
		else 
			echo "<br>insert failed.";
								
	}
	
	?>

		<h3>You filled out:</h3>
			First Name (firstName): <?php echo $_POST["firstName"]; ?> <br>
			Last Name (lastName): <?php echo $_POST["lastName"]; ?><br>
			Email Address (email): <?php echo $_POST["email"]; ?><br>
			Password (password): <?php echo $_POST["password1"]?><br>
			Cell Phone (mobilePhone): <?php echo $_POST["mobilePhone"]; ?><br>
			Gender: <?php echo $_POST['gender']?><br>
	
	<?php 
}
else
{
	// $db = new db($dbValues) or die("Can't create database connection object");
	
	require_once 'registerForm.php';
	
}



?>