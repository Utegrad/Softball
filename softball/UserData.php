<?php

class UserData{
	
	private $db;
	private $dbConnection;
	var $needsCorrection = FALSE;
	var $formField = array ('email' => array ('required' => true,
												'received' => FALSE),
							'password1' => array('required' => true,
												'received' => FALSE),
							'password2' => array('required' => true,
												'received' => FALSE),
							'firstName' => array('required' => true,
												'received' => FALSE),
							'lastName' => array('required' => true,
												'received' => FALSE),
							'mobilePhone' => array('required' => false,
												'received' => FALSE),
							'teamID' => array('required' => false,
												'received' => FALSE),
							'gender' => array('required' => false,
												'received' => FALSE)
			
					);
	
	function __construct(){
		require_once 'mysqlClass.php';
		$this->db = new db();
		$this->dbConnection = $this->db->connect();
		
	}
	
	/**
	 * Sets each of the fieldsGiven['received'] attibute based on the array passed as $array and trims the values passed into $array
	 * @param array $array Array to be checked against the formFields property
	 */
	function fieldsGiven(&$array){
		foreach ($this->formField as $key => &$field){
			/***  Look for and flag blank values ***/
			if (!isset($array[$key]) || empty($array[$key])){
				// $value not set or empty
				// if the form was submitted, they values should be set, but could be empty
				// check to see if we care if they are empty
				
				$field['received'] = false;
				unset($_SESSION[$key]);
				if($field['required'] === TRUE){
					// required form value not provided.  Now what....
					$field['needsAttention'] = "Required value not given";
					$this->needsCorrection = true;
				}
				else{  // value not required
					$field['needsAttention'] = FALSE;
				}
			} //  end if (!isset($array[$key]) || empty($array[$key]))
			else{
				// value received.  mark formField array as such
				$field['received'] = TRUE;
				$array[$key] = trim($array[$key]);
			}
		}
		return;		
	}
	
	/**
	 * Validates and sanitizes the email address given in $email
	 * Updates $formField or tracking which fields need attention.
	 * Sets the session variable email to $email
	 * 
	 * @param string $email Email address to validate and sanitize
	 * @return string returns the sanitized email address 
	 */
	function sanitizeEmail($email){
		//we're checking the email value
		if ($this->formField['email']['received'] === TRUE){
			
			if(filter_var($email,FILTER_VALIDATE_EMAIL) !== FALSE && strlen($email) <= 60){
				//and it's passed the VALIDATE_EMAIL filter
				$email = filter_var($email,FILTER_SANITIZE_EMAIL);
				$email = mysqli_real_escape_string($this->dbConnection,$email);
				$this->formField['email']['needsAttention'] = FALSE;
			
				// check email has already been used
				$emailSelect = "select idUser,UserEmailAddress from User where UserEmailAddress like '".$email."'";
				$selectResult = $this->db->query($this->dbConnection,$emailSelect);
			
				if (mysqli_num_rows($selectResult) > 0){ //email address exists in database already
					$this->needsCorrection = TRUE;
					$this->formField['email']['needsAttention'] = 'Email address is already used';
				}
			}
			else{
				// found an invalid email address
				$email = filter_var($email,FILTER_SANITIZE_STRING);
				$this->formField['email']['needsAttention'] = "Invalid email address format found";
				$this->needsCorrection = TRUE;
			}
			$_SESSION['email'] = $email;
		}
		return $email;
	}
	
	/**
	 * Validates and sanitizes the value given for $phoneNumber.
	 * Updates $formField for tracking which fields need attention.
	 * Sets the session variable given for $sessionVar, defaults to 'mobilePhone'
	 * @param string $phoneNumber Phone number to be checked and updated
	 * @param string $field form field to mark for needing attention
	 * @param string $sessionVar Session variable to set
	 * @return string Sanitized and formatted phone number
	 * 
	 */
	function sanitizePhone($phoneNumber,$field,$sessionVar = 'mobilePhone'){
		
		$pattern = '/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/';
		$replacement = '$1-$2-$3';
		if($this->formField[$field]['received'] === TRUE){
			if(filter_var($phoneNumber,FILTER_VALIDATE_REGEXP,array('options' => array('regexp' => "$pattern"))) !== FALSE){
				// valid phone number input
				$phoneNumber = filter_var($phoneNumber,FILTER_SANITIZE_STRING);
				$phoneNumber = preg_replace($pattern, $replacement, $phoneNumber);
				$this->formField[$field]['needsAttention'] = FALSE;
			}
			else{
				// invalid phone number value given
				$phoneNumber = filter_var($phoneNumber,FILTER_SANITIZE_STRING);
				$this->formField[$field]['needsAttention'] = "Invalid phone number given";
				$this->needsCorrection = TRUE;
			}
			$_SESSION[$sessionVar] = $phoneNumber;
		}
		return $phoneNumber;
	}

	/**
	 * Sanity check and return of $name.  Sets needsAttention value for this->formField.  Sets this->needsCorrection if necessary
	 * @param string $name  Name value to sanitize
	 * @param string $field formField to update
	 * @param string $sessionVar Session variable to set with $name
	 * @return string sanitized value of $name
	 * 
	 */
	function sanitizeName($name,$field,$sessionVar){
		// check Name for a reasonable string
		
		$pattern = "/^(?:[A-Za-z'-]*(?:\s+|$)){2,3}$/";
		// this doesn't take into account a null value for name
		// either need to check that for account for it in the regex
		// check $field['received'] if we didn't receive a value, no point in sanitizing it
		if ($this->formField[$field]['received'] === TRUE){
			// we received a value for this field
			if(filter_var($name,FILTER_VALIDATE_REGEXP,array('options' => array('regexp' => "$pattern"))) !== FALSE  && strlen($name) <= 40){
				// valid string given for name
				// set formField for value
				$this->formField[$field]['needsAttention'] = FALSE;
			}
			else{
				// Invalid string given for name
				$this->formField[$field]['needsAttention'] = "Invalid data given for $field";
				$this->needsCorrection = TRUE;
			}
			$name = filter_var($name,FILTER_SANITIZE_STRING);
			$_SESSION[$sessionVar] = $name;
			
		} // end if ($this->formField[$field]['received'] === TRUE)
		
		return $name;
	}	
	
	function sanitizeTeamID(){
		// not doing anything with this yet
	}
	
	/**
	 * Checks $gender for male || female and sets needsAttention value
	 * @param string $gender Gender value to check
	 * @param string $field fromField to update
	 * @return boolean
	 * 
	 */
	function sanitizeGender($gender,$field = 'gender'){
		if($this->formField['gender']['received'] === TRUE){
			
			if ($gender == 'male' || $gender == 'female'){
				$this->formField[$field]['needsAttention'] = FALSE;
				$_SESSION[$field] = $gender;
				return TRUE;
			}
			else{
				$this->formField[$field]['needsAttention'] = 'Wrong gender value given';
				$this->needsCorrection = TRUE;
				return FALSE;
			}
			
		}
	}
	
	/**
	 * Check $password is a string and between 4 and 40 characters long
	 * @param string $password password value to check and sanitize
	 * @param string $field formField value to update needsAttention value on
	 * @return string returns the sanitized password or unsanitized password if doesn't pass
	 * 
	 */
	function sanitizePassword($password,$field){
		if($this->formField[$field]['received'] === TRUE){

			if(is_string($password) && strlen($password) >= 4 && strlen($password) <= 40){
				// password value is a string and at least 4 characters long and less than 40 characters long
				$this->formField[$field]['needsAttention'] = FALSE;
				$password = mysqli_real_escape_string($this->dbConnection,$password);
			}
			else{
				// password1 not acceptable
				$this->formField[$field]['needsAttention'] = "Invalid value for password given";
				$this->needsCorrection = TRUE;
			}	
			
		}
		return $password;
	}
	
	/**
	 * Checks to see if the values given for $password1 and $password2 match
	 * @param string $password1 value for password1
	 * @param string $password2 value for password2
	 * @return boolean
	 */
	function checkPasswordsMatch($password1,$password2){
		
		if($this->formField['password2']['received'] === TRUE){
			if($password1 === $password2){
				return TRUE;
			}
			else{
				$this->formField['password2']['needsAttention'] = "Passwords do not match";
				$this->needsCorrection = TRUE;
				return FALSE;
			}
		}
		else{
			$this->needsCorrection = TRUE;
			return FALSE;
		}
			
		
	}
	
	
	
} // end of class UserData

?>