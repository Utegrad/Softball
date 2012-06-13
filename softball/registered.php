<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>

<title>Simple Softball Team Tool</title>

<link href='calendar.css' rel='stylesheet' type='text/css'>

<?php require_once 'appLayoutCss.php'; ?>

</head>

<body>
	<div id="container">
		
		<?php require_once 'heading.php'; ?>
		
		<?php require_once 'menu.php';?>
		
		<h3>You filled out:</h3>
			First Name (firstName): <?php echo $_POST["firstName"]; ?> <br>
			Last Name (lastName): <?php echo $_POST["lastName"]; ?><br>
			Email Address (email): <?php echo $_POST["email"]; ?><br>
			Cell Phone (mobilePhone): <?php echo $_POST["mobilePhone"]; ?><br>
			
				
		<?php require_once 'footer.php';?>
		
	</div>


</body>

</html>