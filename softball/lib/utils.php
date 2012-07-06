<?php
/**
 * Utility functions for the site
 * @author Matthew Larsen
 * 
 */

/**
 * Returns the root URI of the application -- maybe ;)
 * 
 * @param string $file
 * @param string $secure set to TRUE for https
 * @return string
 */
function getAppRoot($file,$secure = FALSE){
	$host = $_SERVER['HTTP_HOST'];
	$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	if ($secure === FALSE)
		$appRoot = "http://".$host."/".$uri."/";
	else
		$appRoot = "https://".$host."/".$uri."/";
	return $appRoot;
}

/**
 * Checks first parameter for type and length
 * @param string $type  The type of variable can be bool, float, numeric, string, array, or object
 * @param string $string The variable name you would like to check
 * @param string $length The maximum length of the variable
 * @param boolean $allowEmpty allow empty $string
 *
 * @return boolean
 */
function sanityCheck($string, $type, $length, $allowEmpty = FALSE){

	// assign the type
	$type = 'is_'.$type;

	if(!$type($string))
	{
		return FALSE;
	}
	// now we see if there is anything in the string
	elseif($allowEmpty == false && empty($string))
	{
		return FALSE;
	}
	// then we check how long the string is
	elseif(strlen($string) > $length)
	{
		return FALSE;
	}
	else
	{
		// if all is well, we return TRUE
		return TRUE;
	}
}

/**
 * Sends HTTP header of $URL + $extra
 *
 * @param string $URL
 * @param string $extra
 */
function headerLocation($URL,$extra = NULL){
	// need to check URL to see if it already has a query string
	// if it does add $extra as last part
	// if not add '?$extra'
	// 	echo "\$URL : ";
	// 	var_dump($URL);

	if (contains('?', $URL))
		$URL .= '&'.$extra;
	else
		$URL .= "?".$extra;

	// 	echo "set location to : ";
	// 	var_dump($URL);
	header("Location: $URL");
	//return;
	exit;
}

/**
 * Checks to see of a string contains a particular substring
 * @param $substring the substring to match
 * @param $string the string to search
 * @return true if $substring is found in $string, false otherwise
 */
function contains($substring, $string) {
	$pos = strpos($string, $substring);

	if($pos === false) {
		// string needle NOT found in haystack
		return false;
	}
	else {
		// string needle found in haystack
		return true;
	}

}

/**
 * Sanitizes an input string to strip tags
 * @param string $var
 * @return string
 */
function sanitizeString($var)
{
	$var = strip_tags($var);
	// $var = stripslashes($var);
    $var = htmlentities($var);
    $var = trim($var);
    return $var;
}

/**
 * Sanitizes an input string for mysql by escaping special characters
 * Then does sanitizeString()
 * @param string $var
 * @return string
 */
function sanitizeMySQL(mysqli $con, $var)
{
    $var = mysqli_real_escape_string($con, $var);
    $var = sanitizeString($var);
    return $var;
}
?>