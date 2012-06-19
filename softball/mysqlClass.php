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
	
	function pConnect()
	{

		$params = $this->dbValues;
		//print_r($params);
		$connection = $this->dbCon = mysql_pconnect($params['server'],$params['username'],$params['password']) or die("couldn't connect to the database");
		mysql_select_db($this->dbDatabase);
		if($connection){
			return $connection;
		}
	}
	
	function query($qs)
	{
		$result = mysql_query($qs);
		return $result;
	}
}


?>