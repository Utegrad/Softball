<?php

class db 
{
	function __construct(array $params)
	{
		$this->dbCon = mysql_pconnect($params['server'],$params['username'],$params['password']) or die("couldn't connect to the database");
		$this->dbDatabase = $params['database'];
		mysql_select_db($this->dbDatabase);
	}
	
	var $dbCon;
	var $dbDatabase;
	
	function query($qs)
	{
		$result = mysql_query($qs);
		return $result;
	}
}

?>