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