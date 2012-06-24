<?php

class db 
{

	private $dbValues;
	var $dbCon;
	var $dbDatabase;
	
	function __construct()
	{
		require_once 'priv.php';
		$this->dbValues = array(
				'server' => SERVER,
				'username' => USERNAME,
				'password' => PASSWORD,
				'database' => DATABASE
		);
		$this->dbDatabase = $this->dbValues['database'];
		
		
	}
	
	function connect()
	{

		$params = $this->dbValues;
		//print_r($params);
		$connection = mysqli_connect($params['server'],$params['username'],$params['password'],$params['database']) or die("couldn't connect to the database");
		
		if ($connection->connect_errno) {
			echo "Failed to connect to MySQL: (" . $connection->connect_errno . ") " . $connection->connect_error;
			return false;
		}
		
		if($connection){
			return $connection;
		}
	}
	
	function query($connection, $qs)
	{
		$result = mysqli_query($connection, $qs);
		return $result;
	}
}


?>