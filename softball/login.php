<?php
/**
 * This page should 
 * 	check to see if the user is already logged in
 * 		If they are take them to ???
 * 	if not then query the database for their username and password
 * 		If U/P are matched then set session variable 'auth' to true
 * 			set other session variables we'll need elsewhere
 * 			kick them back to where they came from
 * 				refering page to recognize session variable and give logged in content
 * 		If U/P aren't matched kick them back to where they came from???
 * 			need to send some sort of of signal with kick back to say Oops
 * 
 * Notes to self:
 * 	_SESSION['HTTP_REFERER'] doesn't include the query string
 * 
 * Sets _SESSION['confirmedUser'] with values from login query for use 
 * by other parts of the application
 * 
 */

session_start();
require_once 'lib/utils.php';


/**********   Establish some variables *************/

$host = $_SERVER['HTTP_HOST'];
// echo '<p>$host : </p>';
// var_dump($host);

if (isset($_SERVER['QUERY_STRING']))
	$qs = $_SERVER['QUERY_STRING'];

/*
 * set $referer to the string of the URI they came from on our site.
 * If HTTP_REFERER not set, or from something not on our site, send them to the index page.
 * Should include _GET['pg'] if it's defined
 */
if (isset($_SERVER['HTTP_REFERER'])) { 
	/* 
	 * check if HTTP_REFERER isn't from our HTTP_HOST ?
	 * HTTP_REFERER includes the QUERY_STRING
	 * ??? as below, need to break out $qs and decide what to include  ???
	 */
	$referer = $_SERVER['HTTP_REFERER']; 
}
else {  
	/* 
	 * set $referer to the HTTP_HOST/.../index.php URI with pg from query string
	 * would need to pull out from $qs the string between 'pg=' and the next '?' to include it.
	 */
	$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$referer = "http://$host".$uri."/index.php";
}

// echo '<p>$referer : </p>';
// var_dump($referer);

/**************  Do the login stuff  *****************/

/**
 * _SESSION['auth'] checking and login
 */

// check to see if they are already logged in
if ( isset($_SESSION['auth']) && $_SESSION['auth'] == true){  
	/**
	 * They are logged in so kick them back
	 * to the page they came from
	 */
	// use headerLocation() function to send them back to $referer
	headerLocation($referer);
	exit;
}
else { 
	   /** They are not logged in.  
	    * Check U/P _POST variables
	    * Check U/P against database
	    * If U/P good set _SESSION['auth'] = true
	    * else kick them to $referer from with
	    * some indicator that their login failed 
	    */

	//  check for emailAddress being submitted
	if (isset($_POST['emailAddress']) && sanityCheck($_POST['emailAddress'], 'string', 60 ) )
		$email = $_POST['emailAddress'];
	else {
		headerLocation($referer, "err=EEA");	// need to add login failure indicator - Done
		exit;
	}
	
	// check for password being submitted
	if (isset($_POST['password']) && sanityCheck($_POST['password'], 'string', 45) )
		$password = $_POST['password'];
	else {
		headerLocation($referer,"err=EP");	// need to add login failure indicator
		exit;
	}
	
	/*********  Database checking section *********/
	
	/** 
	 * Need to get values from the database necessary for login and setting 
	 * user identifying session variables.
	 */
	$loginQS = "SELECT * from User 
			WHERE UserEmailAddress like '".$email."' 
			and UserPassword ='".$password."'";
	
// 	echo '<p>$loginQS : </p>';
// 	var_dump($loginQS);
	
	require_once 'mysqlClass.php';
	$db = new db();
	if (!$db){
		headerLocation($referer,'err=NoDBO');
// 		echo "Couldn't create database object.";
		exit;
	}
		
	$dbConnection = $db->connect();
	if (!$dbConnection){
		headerLocation($referer,'err=NoDBCon');
// 		echo "Database connection problems encountered.";
		exit;
	}
	
	if ($loginQR = $db->query($dbConnection, $loginQS)){
		
		// 	var_dump($loginQR);
		
		if (mysqli_num_rows($loginQR) > 0 ){
			// U/P match found.  Set _SESSION['auth'] = TRUE
			// 		echo "<p>Match found</p>\n";
		
			$confirmedUser = mysqli_fetch_assoc($loginQR);
						
			/**
			 * Set session variables from login here
			 */
			$_SESSION['auth'] = TRUE;
			$_SESSION['confirmedUser'] = $confirmedUser;
			unset($_SESSION['confirmedUser']['UserPassword']);
			
			headerLocation($referer);
			exit;
		}
		else{
			// no U/P match found.
			// 		echo '<p>No match found.</p>';
			headerLocation($referer,"err=noMatch");  // add login failure indiciator
			exit;
		}
	}

	
	// unset POST['password'] and $password?

}

/*********************************/


?>